<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\CommunityMessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommunityChatController extends Controller
{
    /**
     * Get all community groups with membership status and last message
     */
    public function getGroups(Request $request)
    {
        $uid = $request->input('uid', 0);

        // Security: Enforce KYC verification
        $user = DB::table('tbl_user')->where('id', $uid)->first();
        if (!$user || (string)($user->is_verify ?? '0') !== '1') {
            return response()->json([
                'ResponseCode' => '403',
                'Result' => 'false',
                'ResponseMsg' => 'KYC verification required to access community hub',
                'is_verify' => $user ? (string)($user->is_verify ?? '0') : '0',
                'Groups' => [],
            ]);
        }

        $groups = DB::table('tbl_community_group')
            ->orderBy('is_official', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        $groupList = [];
        foreach ($groups as $group) {
            // Count members
            $memberCount = DB::table('tbl_community_member')->where('group_id', $group->id)->count();
            // Virtual minimum active base for rich community feel
            $displayMemberCount = max($memberCount, 18 + ($group->id * 7));

            // Check if user is member
            $isMember = false;
            if ($uid > 0) {
                $isMember = DB::table('tbl_community_member')
                    ->where('group_id', $group->id)
                    ->where('user_id', $uid)
                    ->exists();
                // Official groups default to joined
                if ($group->is_official == 1) {
                    $isMember = true;
                }
            }

            // Get last message
            $lastMsg = DB::table('tbl_community_message')
                ->where('group_id', $group->id)
                ->orderBy('id', 'desc')
                ->first();

            $lastMessageText = 'No messages yet';
            $lastMessageTime = $group->created_at;
            $lastSenderName = 'Movers Bot';

            if ($lastMsg) {
                $lastMessageText = $lastMsg->message;
                $lastMessageTime = $lastMsg->created_at;

                $sender = DB::table('tbl_user')->where('id', $lastMsg->sender_id)->first();
                if ($sender) {
                    $lastSenderName = $sender->name;
                } elseif ($lastMsg->sender_id == 1) {
                    $lastSenderName = 'Movers Official';
                }
            }

            $groupList[] = [
                'id' => (string) $group->id,
                'title' => $group->title,
                'description' => $group->description ?? '',
                'icon' => $group->icon ?? 'truck',
                'is_official' => (string) $group->is_official,
                'category' => $group->category ?? 'General',
                'members_count' => (int) $displayMemberCount,
                'is_joined' => $isMember ? '1' : '0',
                'last_message' => $lastMessageText,
                'last_message_time' => (string) $lastMessageTime,
                'last_sender_name' => $lastSenderName,
            ];
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Community groups fetched successfully',
            'Groups' => $groupList,
        ]);
    }

    /**
     * Get paginated messages for a group
     */
    public function getMessages(Request $request)
    {
        $groupId = $request->input('group_id');
        $uid = $request->input('uid', 0);
        $lastMsgId = (int) $request->input('last_msg_id', 0);

        if (empty($groupId)) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Group ID is required',
            ]);
        }

        // Security: Enforce KYC verification
        $user = DB::table('tbl_user')->where('id', $uid)->first();
        if (!$user || (string)($user->is_verify ?? '0') !== '1') {
            return response()->json([
                'ResponseCode' => '403',
                'Result' => 'false',
                'ResponseMsg' => 'KYC verification required to view community messages',
                'Messages' => [],
            ]);
        }

        $query = DB::table('tbl_community_message')
            ->where('group_id', $groupId);

        if ($lastMsgId > 0) {
            $query->where('id', '>', $lastMsgId);
        }

        $messages = $query->orderBy('id', 'asc')
            ->limit(100)
            ->get();

        $formattedMessages = [];
        foreach ($messages as $msg) {
            $sender = DB::table('tbl_user')->where('id', $msg->sender_id)->first();
            $senderName = 'Movers Official';
            $senderAvatar = '';
            $isVerify = '1';
            $role = 'Admin';

            if ($sender) {
                $senderName = $sender->name ?? 'Freight Member';
                $senderAvatar = $sender->pro_pic ?? '';
                $isVerify = (string) ($sender->is_verify ?? '0');
                $role = 'Shipper';
            }

            $isMe = ($uid > 0 && (string)$msg->sender_id === (string)$uid);

            $formattedMessages[] = [
                'id' => (string) $msg->id,
                'group_id' => (string) $msg->group_id,
                'sender_id' => (string) $msg->sender_id,
                'sender_name' => $senderName,
                'sender_avatar' => $senderAvatar,
                'sender_verify' => $isVerify,
                'sender_role' => $role,
                'message' => $msg->message,
                'media_url' => $msg->media_url ?? '',
                'message_type' => $msg->message_type ?? 'text',
                'created_at' => (string) $msg->created_at,
                'is_me' => $isMe,
            ];
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Messages retrieved successfully',
            'Messages' => $formattedMessages,
        ]);
    }

    /**
     * Send a message to a community group
     */
    public function sendMessage(Request $request)
    {
        $uid = $request->input('uid');
        $groupId = $request->input('group_id');
        $message = trim($request->input('message', ''));
        $messageType = $request->input('message_type', 'text');
        $mediaUrl = $request->input('media_url', '');

        // Security: Enforce KYC verification
        $user = DB::table('tbl_user')->where('id', $uid)->first();
        if (!$user || (string)($user->is_verify ?? '0') !== '1') {
            return response()->json([
                'ResponseCode' => '403',
                'Result' => 'false',
                'ResponseMsg' => 'Only KYC verified members can send messages in community',
            ]);
        }

        // Handle Image Attachment File Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'chat_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/chat');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $fileName);
            $mediaUrl = 'images/chat/' . $fileName;
            $messageType = 'image';
        }

        if (empty($uid) || empty($groupId) || (empty($message) && empty($mediaUrl))) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'UID, Group ID, and message or image are required',
            ]);
        }

        $now = now();
        $msgId = DB::table('tbl_community_message')->insertGetId([
            'group_id' => $groupId,
            'sender_id' => $uid,
            'message' => $message,
            'media_url' => $mediaUrl,
            'message_type' => $messageType,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Ensure user is recorded as member
        $exists = DB::table('tbl_community_member')
            ->where('group_id', $groupId)
            ->where('user_id', $uid)
            ->exists();
        if (!$exists) {
            DB::table('tbl_community_member')->insert([
                'group_id' => $groupId,
                'user_id' => $uid,
                'role' => 'member',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $sender = DB::table('tbl_user')->where('id', $uid)->first();
        $senderName = $sender ? ($sender->name ?? 'Movers Member') : 'Movers Member';
        $senderAvatar = $sender ? ($sender->pro_pic ?? '') : '';
        $isVerify = $sender ? ((string)($sender->is_verify ?? '0')) : '0';

        $payload = [
            'id' => (string) $msgId,
            'group_id' => (string) $groupId,
            'sender_id' => (string) $uid,
            'sender_name' => $senderName,
            'sender_avatar' => $senderAvatar,
            'sender_verify' => $isVerify,
            'sender_role' => 'Shipper',
            'message' => $message,
            'media_url' => $mediaUrl,
            'message_type' => $messageType,
            'created_at' => (string) $now,
            'is_me' => true,
        ];

        // Broadcast realtime event
        try {
            event(new CommunityMessageSent($payload));
        } catch (\Exception $e) {
            Log::warning("CommunityMessageSent broadcast error: " . $e->getMessage());
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Message sent successfully',
            'ChatMessage' => $payload,
        ]);
    }

    /**
     * Join or leave a community group
     */
    public function toggleJoin(Request $request)
    {
        $uid = $request->input('uid');
        $groupId = $request->input('group_id');

        if (empty($uid) || empty($groupId)) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'UID and Group ID are required',
            ]);
        }

        $member = DB::table('tbl_community_member')
            ->where('group_id', $groupId)
            ->where('user_id', $uid)
            ->first();

        if ($member) {
            DB::table('tbl_community_member')
                ->where('group_id', $groupId)
                ->where('user_id', $uid)
                ->delete();
            $isJoined = '0';
            $msg = 'Left community group';
        } else {
            DB::table('tbl_community_member')->insert([
                'group_id' => $groupId,
                'user_id' => $uid,
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $isJoined = '1';
            $msg = 'Joined community group successfully';
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => $msg,
            'is_joined' => $isJoined,
        ]);
    }
}
