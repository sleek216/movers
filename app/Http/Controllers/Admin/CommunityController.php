<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CommunityController extends Controller
{
    /**
     * Display listing of all community groups
     */
    public function index()
    {
        $groups = DB::table('tbl_community_group')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($groups as $group) {
            $group->members_count = DB::table('tbl_community_member')
                ->where('group_id', $group->id)
                ->count();

            $group->messages_count = DB::table('tbl_community_message')
                ->where('group_id', $group->id)
                ->count();
        }

        $totalGroups = $groups->count();
        $totalMessages = DB::table('tbl_community_message')->count();
        $totalMemberships = DB::table('tbl_community_member')->count();

        return view('admin.communities.index', compact('groups', 'totalGroups', 'totalMessages', 'totalMemberships'));
    }

    /**
     * Create a new community group
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = 'comm_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/communities');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            $file->move($destinationPath, $filename);
            $iconPath = 'images/communities/' . $filename;
        }

        $groupId = DB::table('tbl_community_group')->insertGetId([
            'title' => $request->title,
            'description' => $request->description ?? '',
            'icon' => $iconPath,
            'category' => $request->category ?? 'General Hub',
            'is_official' => $request->has('is_official') ? 1 : 0,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Auto add admin / system member
        DB::table('tbl_community_member')->insert([
            'group_id' => $groupId,
            'user_id' => 1,
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.communities.index')->with('success', 'Community Group created successfully!');
    }

    /**
     * Update an existing group
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $group = DB::table('tbl_community_group')->where('id', $id)->first();
        if (!$group) {
            return redirect()->back()->with('error', 'Group not found');
        }

        $updateData = [
            'title' => $request->title,
            'description' => $request->description ?? '',
            'category' => $request->category ?? 'General Hub',
            'is_official' => $request->has('is_official') ? 1 : 0,
            'updated_at' => now(),
        ];

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = 'comm_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/communities');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            $file->move($destinationPath, $filename);
            $updateData['icon'] = 'images/communities/' . $filename;
        }

        DB::table('tbl_community_group')->where('id', $id)->update($updateData);

        return redirect()->route('admin.communities.index')->with('success', 'Community Group updated successfully!');
    }

    /**
     * Delete a community group
     */
    public function destroy($id)
    {
        DB::table('tbl_community_message')->where('group_id', $id)->delete();
        DB::table('tbl_community_member')->where('group_id', $id)->delete();
        DB::table('tbl_community_group')->where('id', $id)->delete();

        return redirect()->route('admin.communities.index')->with('success', 'Community Group and its messages deleted successfully!');
    }

    /**
     * View and moderate messages in a group
     */
    public function messages($id)
    {
        $group = DB::table('tbl_community_group')->where('id', $id)->first();
        if (!$group) {
            return redirect()->route('admin.communities.index')->with('error', 'Group not found');
        }

        $messages = DB::table('tbl_community_message as m')
            ->leftJoin('tbl_user as u', 'm.sender_id', '=', 'u.id')
            ->where('m.group_id', $id)
            ->select('m.*', 'u.name as sender_name', 'u.mobile as sender_mobile', 'u.pro_pic as profile_pic')
            ->orderBy('m.id', 'desc')
            ->paginate(50);

        return view('admin.communities.messages', compact('group', 'messages'));
    }

    /**
     * Delete a specific spam or abusive message
     */
    public function destroyMessage($id)
    {
        DB::table('tbl_community_message')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Message removed successfully.');
    }
}
