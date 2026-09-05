<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoadPost;
use App\Models\LoadResponse;
use App\Models\User;
use App\Models\Lorry;
use App\Models\LorryOwner;
use App\Models\WalletReport;
use App\Services\FirebasePushService;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    public function createLoad(Request $request)
    {
        $uid = $request->input('uid');
        $vehicle_id = $request->input('vehicle_id');
        $weight = $request->input('weight');
        $amount = $request->input('amount');
        $amt_type = $request->input('amt_type', 'Fixed');
        $total_amt = $request->input('total_amt', $amount);
        $pickup_point = $request->input('pickup_point');
        $drop_point = $request->input('drop_point');
        $material_name = $request->input('material_name');
        $description = $request->input('description');
        $visible_hours = $request->input('visible_hours', 24);
        $pick_lat = $request->input('pick_lat', '0.0');
        $pick_lng = $request->input('pick_lng', '0.0');
        $drop_lat = $request->input('drop_lat', '0.0');
        $drop_lng = $request->input('drop_lng', '0.0');
        $pick_state_id = $request->input('pick_state_id', 1);
        $drop_state_id = $request->input('drop_state_id', 1);
        $pick_name = $request->input('pick_name', '');
        $pick_mobile = $request->input('pick_mobile', '');
        $drop_name = $request->input('drop_name', '');
        $drop_mobile = $request->input('drop_mobile', '');

        $load = LoadPost::create([
            'uid' => $uid,
            'vehicle_id' => $vehicle_id,
            'load_type' => 'POST_LOAD',
            'load_status' => 'Pending',
            'weight' => $weight,
            'amount' => $amount,
            'amt_type' => $amt_type,
            'total_amt' => $total_amt,
            'pickup_point' => $pickup_point,
            'drop_point' => $drop_point,
            'material_name' => $material_name,
            'description' => $description,
            'visible_hours' => $visible_hours,
            'pick_lat' => $pick_lat,
            'pick_lng' => $pick_lng,
            'drop_lat' => $drop_lat,
            'drop_lng' => $drop_lng,
            'pick_state_id' => $pick_state_id,
            'drop_state_id' => $drop_state_id,
            'pick_name' => $pick_name,
            'pick_mobile' => $pick_mobile,
            'drop_name' => $drop_name,
            'drop_mobile' => $drop_mobile,
            'post_date' => now(),
            'status' => 1
        ]);

        // Push notification & in-app alert for user
        FirebasePushService::notifyUser(
            $uid,
            'Load Posted Successfully! 🚚',
            "Your load for {$material_name} ({$pickup_point} ➔ {$drop_point}) has been posted. Transporters will send bids shortly.",
            ['load_id' => (string)$load->id, 'type' => 'post_load']
        );

        // Broadcast to transporters
        FirebasePushService::broadcastToAllTransporters(
            'New Load Available! 📦',
            "New load posted: {$material_name} from {$pickup_point} to {$drop_point}. Open app to place your bid!",
            ['load_id' => (string)$load->id, 'type' => 'new_load']
        );

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Load Posted Successfully!'
        ]);
    }

    public function editLoad(Request $request)
    {
        $record_id = $request->input('record_id');
        $load = LoadPost::find($record_id);

        if ($load) {
            $load->update($request->only([
                'vehicle_id', 'weight', 'amount', 'amt_type', 'total_amt',
                'pickup_point', 'drop_point', 'material_name', 'description',
                'visible_hours', 'pick_name', 'pick_mobile', 'drop_name', 'drop_mobile'
            ]));

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Load Updated Successfully!'
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'Load Record Not Found!'
        ]);
    }

    public function loadHistory(Request $request)
    {
        $uid = $request->input('uid');

        $active = LoadPost::where('uid', $uid)
            ->whereIn('load_status', ['Pending', 'Load_start', 'Accepted'])
            ->with('vehicle')
            ->orderBy('id', 'desc')
            ->get();

        $complete = LoadPost::where('uid', $uid)
            ->where('load_status', 'Completed')
            ->with('vehicle')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Load History Received!',
            'LoadHistory' => [
                'active' => $active,
                'complete' => $complete
            ]
        ]);
    }

    public function loadDetails(Request $request)
    {
        $post_id = $request->input('post_id');
        $load = LoadPost::with('vehicle')->find($post_id);

        if (!$load) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Load Not Found!'
            ]);
        }

        $bids = LoadResponse::where('load_id', $post_id)->with(['owner', 'lorry'])->get();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Load Details Received!',
            'PostData' => $load,
            'bider_data' => $bids
        ]);
    }

    public function deleteLoad(Request $request)
    {
        $post_id = $request->input('post_id');
        $load = LoadPost::find($post_id);
        if ($load) {
            $load->update(['load_status' => 'Cancelled', 'status' => 0]);
            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Load Deleted Successfully!'
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'Load Not Found!'
        ]);
    }

    public function makeDecision(Request $request)
    {
        $post_id = $request->input('post_id');
        $bider_id = $request->input('bider_id');
        $decision = $request->input('decision'); // Accept / Reject
        $p_method_id = $request->input('p_method_id');
        $trans_id = $request->input('trans_id');

        $bid = LoadResponse::find($bider_id);
        $load = LoadPost::find($post_id);

        if (!$bid || !$load) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Record Not Found!'
            ]);
        }

        if ($decision == 'Accept') {
            $bid->update(['status' => 1]);
            $load->update([
                'load_status' => 'Accepted',
                'lorry_owner_id' => $bid->owner_id,
                'lorry_id' => $bid->lorry_id,
                'p_method_id' => $p_method_id,
                'trans_id' => $trans_id,
                'is_accept' => 1
            ]);

            // Notify User
            FirebasePushService::notifyUser(
                $load->uid,
                'Bid Accepted! ✅',
                "You have accepted the bid for Load #{$post_id}. Transporter will coordinate pickup.",
                ['load_id' => (string)$post_id, 'type' => 'bid_accept']
            );

            // Notify Transporter
            FirebasePushService::notifyTransporter(
                $bid->owner_id,
                'Congratulations! Bid Accepted! 🎉',
                "Your bid on Load #{$post_id} ({$load->material_name}) was accepted by the customer. Get ready for pickup!",
                ['load_id' => (string)$post_id, 'type' => 'bid_accepted']
            );

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Bid Accepted Successfully!'
            ]);
        } else {
            $bid->update(['status' => 2]);

            // Notify Transporter
            FirebasePushService::notifyTransporter(
                $bid->owner_id,
                'Bid Update ℹ️',
                "Your bid on Load #{$post_id} was not accepted.",
                ['load_id' => (string)$post_id, 'type' => 'bid_rejected']
            );

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Bid Rejected!'
            ]);
        }
    }
}