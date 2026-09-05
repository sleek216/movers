<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lorry;
use App\Models\LorryOwner;
use App\Models\LoadPost;
use App\Models\Vehicle;
use App\Services\FirebasePushService;
use Illuminate\Http\Request;

class LorryController extends Controller
{
    public function findLorry(Request $request)
    {
        $pick_state_id = $request->input('pick_state_id');
        $drop_state_id = $request->input('drop_state_id');
        $vehicle_id = $request->input('vehicle_id');

        $query = Lorry::with(['owner', 'vehicle'])->where('status', 1);

        if ($vehicle_id) {
            $query->where('vehicle_id', $vehicle_id);
        }

        $lorries = $query->get();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Lorries List Received!',
            'LorryData' => $lorries
        ]);
    }

    public function bookLorry(Request $request)
    {
        $uid = $request->input('uid');
        $lorry_id = $request->input('lorry_id');
        $lorry_owner_id = $request->input('lorry_owner_id');
        $vehicle_id = $request->input('vehicle_id');
        $pickup_point = $request->input('pickup_point');
        $drop_point = $request->input('drop_point');
        $material_name = $request->input('material_name');

        $booking = LoadPost::create([
            'uid' => $uid,
            'lorry_id' => $lorry_id,
            'lorry_owner_id' => $lorry_owner_id,
            'vehicle_id' => $vehicle_id,
            'load_type' => 'FIND_LORRY',
            'load_status' => 'Pending',
            'weight' => $request->input('weight'),
            'amount' => $request->input('amount'),
            'amt_type' => $request->input('amt_type', 'Fixed'),
            'total_amt' => $request->input('total_amt'),
            'pickup_point' => $pickup_point,
            'drop_point' => $drop_point,
            'material_name' => $material_name,
            'description' => $request->input('description'),
            'pick_name' => $request->input('pick_name'),
            'pick_mobile' => $request->input('pick_mobile'),
            'drop_name' => $request->input('drop_name'),
            'drop_mobile' => $request->input('drop_mobile'),
            'post_date' => now(),
            'status' => 1
        ]);

        // Push notification to User
        FirebasePushService::notifyUser(
            $uid,
            'Booking Request Sent! 🚛',
            "Your booking request for lorry has been submitted. Awaiting transporter approval.",
            ['booking_id' => (string)$booking->id, 'type' => 'booking_created']
        );

        // Push notification to Transporter
        FirebasePushService::notifyTransporter(
            $lorry_owner_id,
            'New Booking Request! 🔔',
            "You received a new booking request for {$material_name} ({$pickup_point} ➔ {$drop_point}).",
            ['booking_id' => (string)$booking->id, 'type' => 'new_booking']
        );

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Booking Request Sent Successfully!'
        ]);
    }

    public function bookHistory(Request $request)
    {
        $uid = $request->input('uid');
        $bookings = LoadPost::where('uid', $uid)->where('load_type', 'FIND_LORRY')->with(['vehicle'])->get();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Booking History Received!',
            'HistoryData' => $bookings
        ]);
    }

    public function bookDetails(Request $request)
    {
        $record_id = $request->input('record_id');
        $booking = LoadPost::with(['vehicle'])->find($record_id);

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Booking Details Received!',
            'BookData' => $booking
        ]);
    }

    public function offerDecision(Request $request)
    {
        $record_id = $request->input('record_id');
        $decision = $request->input('decision'); // Accept / Reject

        $booking = LoadPost::find($record_id);
        if ($booking) {
            $isAccept = ($decision == 'Accept');
            $booking->update([
                'is_accept' => ($isAccept ? 1 : 2),
                'load_status' => ($isAccept ? 'Accepted' : 'Cancelled')
            ]);

            // Notify customer
            FirebasePushService::notifyUser(
                $booking->uid,
                $isAccept ? 'Booking Confirmed! 🎉' : 'Booking Declined ❌',
                $isAccept
                    ? "Transporter accepted your booking request #{$record_id}."
                    : "Transporter was unable to accept your booking request #{$record_id}.",
                ['booking_id' => (string)$record_id, 'type' => 'booking_decision']
            );

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Offer Updated Successfully!'
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'Record Not Found!'
        ]);
    }

    public function rateUpdate(Request $request)
    {
        $post_id = $request->input('post_id');
        $total_star = $request->input('total_star', 5);
        $rate_text = $request->input('rate_text', '');

        $load = LoadPost::find($post_id);
        if ($load) {
            $load->update([
                'is_lrate' => 1,
                'total_lrate' => $total_star,
                'rate_ltext' => $rate_text
            ]);

            if ($load->lorry_owner_id) {
                FirebasePushService::notifyTransporter(
                    $load->lorry_owner_id,
                    'New Customer Review! ⭐',
                    "You received a {$total_star}-star rating for trip #{$post_id}: \"{$rate_text}\"",
                    ['load_id' => (string)$post_id, 'type' => 'review']
                );
            }

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Review Submitted Successfully!'
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'Record Not Found!'
        ]);
    }

    public function lorryProfile(Request $request)
    {
        $lorry_id = $request->input('lorry_id');
        $lorry = Lorry::with(['owner', 'vehicle'])->find($lorry_id);

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Lorry Profile Received!',
            'LorryProfile' => $lorry
        ]);
    }

    public function transProfile(Request $request)
    {
        $owner_id = $request->input('owner_id');
        $owner = LorryOwner::find($owner_id);

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Transporter Profile Received!',
            'TransProfile' => $owner
        ]);
    }
}