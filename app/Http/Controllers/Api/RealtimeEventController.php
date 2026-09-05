<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RealtimeEventController extends Controller
{
    /**
     * Atomic real-time sync for Flutter App
     * Returns live KYC status, live wallet balance, and newly created notifications.
     */
    public function sync(Request $request)
    {
        $uid = $request->input('uid');
        $lastNotifId = (int) $request->input('last_notif_id', 0);

        if (empty($uid)) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'User ID is required',
            ]);
        }

        $user = DB::table('tbl_user')->where('id', $uid)->first();
        if (!$user) {
            return response()->json([
                'ResponseCode' => '404',
                'Result' => 'false',
                'ResponseMsg' => 'User not found',
            ]);
        }

        // Fetch any notifications with ID higher than client's last seen ID
        $query = DB::table('tbl_notification')->where('uid', $uid);
        if ($lastNotifId > 0) {
            $query->where('id', '>', $lastNotifId);
        }
        $newNotifications = $query->orderBy('id', 'desc')->get();

        $latestNotif = DB::table('tbl_notification')->where('uid', $uid)->orderBy('id', 'desc')->first();
        $latestId = $latestNotif ? (int) $latestNotif->id : 0;

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Realtime Sync Data Received',
            'SyncData' => [
                'userId' => (string) $user->id,
                'is_verify' => (string) $user->is_verify, // '0'=Pending, '1'=Approved, '2'=Rejected
                'reject_comment' => (string) ($user->reject_comment ?? ''),
                'wallet' => (string) $user->wallet,
                'status' => (string) $user->status,
                'latest_notif_id' => $latestId,
                'new_notifications' => $newNotifications,
                'server_time' => now()->toIso8601String(),
            ]
        ]);
    }
}
