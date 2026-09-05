<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    /**
     * City road distance matrix (in KM) across major logistics hubs in Pakistan.
     */
    protected $cityDistances = [
        'Karachi' => [
            'Karachi' => 0, 'Hyderabad' => 165, 'Sukkur' => 495, 'Multan' => 930, 
            'Faisalabad' => 1140, 'Lahore' => 1210, 'Islamabad' => 1410, 'Rawalpindi' => 1400,
            'Peshawar' => 1560, 'Quetta' => 690, 'Gwadar' => 635, 'Gujranwala' => 1280,
            'Sialkot' => 1340, 'Rahim Yar Khan' => 620, 'Bahawalpur' => 840, 'Sargodha' => 1190
        ],
        'Lahore' => [
            'Karachi' => 1210, 'Hyderabad' => 1050, 'Sukkur' => 740, 'Multan' => 340, 
            'Faisalabad' => 180, 'Lahore' => 0, 'Islamabad' => 375, 'Rawalpindi' => 370,
            'Peshawar' => 510, 'Quetta' => 960, 'Gwadar' => 1720, 'Gujranwala' => 75,
            'Sialkot' => 135, 'Rahim Yar Khan' => 590, 'Bahawalpur' => 420, 'Sargodha' => 195
        ],
        'Islamabad' => [
            'Karachi' => 1410, 'Hyderabad' => 1260, 'Sukkur' => 950, 'Multan' => 540, 
            'Faisalabad' => 320, 'Lahore' => 375, 'Islamabad' => 0, 'Rawalpindi' => 15,
            'Peshawar' => 170, 'Quetta' => 910, 'Gwadar' => 1920, 'Gujranwala' => 310,
            'Sialkot' => 260, 'Rahim Yar Khan' => 800, 'Bahawalpur' => 640, 'Sargodha' => 210
        ],
        'Rawalpindi' => [
            'Karachi' => 1400, 'Hyderabad' => 1250, 'Sukkur' => 940, 'Multan' => 530, 
            'Faisalabad' => 310, 'Lahore' => 370, 'Islamabad' => 15, 'Rawalpindi' => 0,
            'Peshawar' => 175, 'Quetta' => 900, 'Gwadar' => 1910, 'Gujranwala' => 300,
            'Sialkot' => 250, 'Rahim Yar Khan' => 790, 'Bahawalpur' => 630, 'Sargodha' => 205
        ],
        'Faisalabad' => [
            'Karachi' => 1140, 'Hyderabad' => 980, 'Sukkur' => 670, 'Multan' => 240, 
            'Faisalabad' => 0, 'Lahore' => 180, 'Islamabad' => 320, 'Rawalpindi' => 310,
            'Peshawar' => 450, 'Quetta' => 860, 'Gwadar' => 1650, 'Gujranwala' => 160,
            'Sialkot' => 220, 'Rahim Yar Khan' => 520, 'Bahawalpur' => 350, 'Sargodha' => 90
        ],
        'Multan' => [
            'Karachi' => 930, 'Hyderabad' => 770, 'Sukkur' => 460, 'Multan' => 0, 
            'Faisalabad' => 240, 'Lahore' => 340, 'Islamabad' => 540, 'Rawalpindi' => 530,
            'Peshawar' => 670, 'Quetta' => 650, 'Gwadar' => 1440, 'Gujranwala' => 410,
            'Sialkot' => 470, 'Rahim Yar Khan' => 310, 'Bahawalpur' => 100, 'Sargodha' => 310
        ],
        'Peshawar' => [
            'Karachi' => 1560, 'Hyderabad' => 1410, 'Sukkur' => 1100, 'Multan' => 670, 
            'Faisalabad' => 450, 'Lahore' => 510, 'Islamabad' => 170, 'Rawalpindi' => 175,
            'Peshawar' => 0, 'Quetta' => 840, 'Gwadar' => 2070, 'Gujranwala' => 440,
            'Sialkot' => 390, 'Rahim Yar Khan' => 950, 'Bahawalpur' => 790, 'Sargodha' => 340
        ],
        'Quetta' => [
            'Karachi' => 690, 'Hyderabad' => 710, 'Sukkur' => 390, 'Multan' => 650, 
            'Faisalabad' => 860, 'Lahore' => 960, 'Islamabad' => 910, 'Rawalpindi' => 900,
            'Peshawar' => 840, 'Quetta' => 0, 'Gwadar' => 920, 'Gujranwala' => 990,
            'Sialkot' => 1050, 'Rahim Yar Khan' => 560, 'Bahawalpur' => 680, 'Sargodha' => 870
        ],
        'Hyderabad' => [
            'Karachi' => 165, 'Hyderabad' => 0, 'Sukkur' => 330, 'Multan' => 770, 
            'Faisalabad' => 980, 'Lahore' => 1050, 'Islamabad' => 1260, 'Rawalpindi' => 1250,
            'Peshawar' => 1410, 'Quetta' => 710, 'Gwadar' => 800, 'Gujranwala' => 1120,
            'Sialkot' => 1180, 'Rahim Yar Khan' => 460, 'Bahawalpur' => 680, 'Sargodha' => 1030
        ],
        'Sukkur' => [
            'Karachi' => 495, 'Hyderabad' => 330, 'Sukkur' => 0, 'Multan' => 460, 
            'Faisalabad' => 670, 'Lahore' => 740, 'Islamabad' => 950, 'Rawalpindi' => 940,
            'Peshawar' => 1100, 'Quetta' => 390, 'Gwadar' => 1050, 'Gujranwala' => 810,
            'Sialkot' => 870, 'Rahim Yar Khan' => 190, 'Bahawalpur' => 380, 'Sargodha' => 720
        ],
        'Gwadar' => [
            'Karachi' => 635, 'Hyderabad' => 800, 'Sukkur' => 1050, 'Multan' => 1440, 
            'Faisalabad' => 1650, 'Lahore' => 1720, 'Islamabad' => 1920, 'Rawalpindi' => 1910,
            'Peshawar' => 2070, 'Quetta' => 920, 'Gwadar' => 0, 'Gujranwala' => 1790,
            'Sialkot' => 1850, 'Rahim Yar Khan' => 1220, 'Bahawalpur' => 1400, 'Sargodha' => 1700
        ],
        'Gujranwala' => [
            'Karachi' => 1280, 'Hyderabad' => 1120, 'Sukkur' => 810, 'Multan' => 410, 
            'Faisalabad' => 160, 'Lahore' => 75, 'Islamabad' => 310, 'Rawalpindi' => 300,
            'Peshawar' => 440, 'Quetta' => 990, 'Gwadar' => 1790, 'Gujranwala' => 0,
            'Sialkot' => 50, 'Rahim Yar Khan' => 660, 'Bahawalpur' => 490, 'Sargodha' => 140
        ],
        'Sialkot' => [
            'Karachi' => 1340, 'Hyderabad' => 1180, 'Sukkur' => 870, 'Multan' => 470, 
            'Faisalabad' => 220, 'Lahore' => 135, 'Islamabad' => 260, 'Rawalpindi' => 250,
            'Peshawar' => 390, 'Quetta' => 1050, 'Gwadar' => 1850, 'Gujranwala' => 50,
            'Sialkot' => 0, 'Rahim Yar Khan' => 720, 'Bahawalpur' => 550, 'Sargodha' => 190
        ]
    ];

    /**
     * Get shared site settings helper.
     */
    protected function getSiteData()
    {
        $setting = DB::table('tbl_setting')->first();
        $vehicles = DB::table('tbl_vehicle')->where('status', 1)->get();
        $cities = array_keys($this->cityDistances);
        sort($cities);

        return [
            'setting' => $setting,
            'vehicles' => $vehicles,
            'cities' => $cities,
        ];
    }

    /**
     * Public Homepage
     */
    public function index()
    {
        $data = $this->getSiteData();
        $faqs = DB::table('tbl_faq')->where('status', 1)->take(8)->get();
        $banners = DB::table('banner')->where('status', 1)->get();
        
        // Live counts for metrics bar
        $counts = [
            'lorries' => DB::table('tbl_lorry')->count() ?: 1250,
            'shippers' => DB::table('tbl_user')->count() ?: 3840,
            'loads' => DB::table('tbl_load')->count() ?: 8920,
            'cities' => count($this->cityDistances)
        ];

        return view('landing.index', array_merge($data, [
            'faqs' => $faqs,
            'banners' => $banners,
            'counts' => $counts
        ]));
    }

    /**
     * About Us Page
     */
    public function about()
    {
        $data = $this->getSiteData();
        $page = DB::table('tbl_page')->where('id', 1)->first();
        return view('landing.about', array_merge($data, ['page' => $page]));
    }

    /**
     * Services Directory Page
     */
    public function services()
    {
        $data = $this->getSiteData();
        return view('landing.services', $data);
    }

    /**
     * Interactive Fare Calculator Page
     */
    public function calculator()
    {
        $data = $this->getSiteData();
        return view('landing.calculator', $data);
    }

    /**
     * AJAX Route & Rate Estimator API
     */
    public function calculateFare(Request $request)
    {
        $request->validate([
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'vehicle_id' => 'required|integer',
            'weight' => 'nullable|numeric',
        ]);

        $from = $request->from_city;
        $to = $request->to_city;
        $vehicleId = $request->vehicle_id;
        $weight = floatval($request->weight ?? 1);

        $vehicle = DB::table('tbl_vehicle')->where('id', $vehicleId)->first();
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Selected vehicle type was not found.'
            ], 404);
        }

        $setting = DB::table('tbl_setting')->first();
        $dieselPrice = floatval($setting->diesel_price ?? 275);

        // Distance Lookup
        $distance = 0;
        if (isset($this->cityDistances[$from][$to])) {
            $distance = $this->cityDistances[$from][$to];
        } elseif (isset($this->cityDistances[$to][$from])) {
            $distance = $this->cityDistances[$to][$from];
        } else {
            // Default reasonable highway estimate if not in direct matrix
            $distance = ($from === $to) ? 35 : 450;
        }

        // Calculation variables
        $baseFare = floatval($vehicle->base_fare ?? 1500);
        $perKmRate = floatval($vehicle->per_km_rate ?? 75);
        $tollRatePerKm = floatval($vehicle->toll_rate_per_km ?? 3.5);
        $fuelAverage = floatval($vehicle->fuel_average ?? 6);
        if ($fuelAverage <= 0) $fuelAverage = 6;

        // Estimated distance charges
        $distanceCharge = $distance * $perKmRate;
        $tollCharge = $distance * $tollRatePerKm;
        $estimatedLiters = round($distance / $fuelAverage, 1);
        $estimatedFuelCost = round($estimatedLiters * $dieselPrice);
        
        // Weight surcharge if exceeding standard base weight
        $minWeight = floatval($vehicle->min_weight ?? 1);
        $maxWeight = floatval($vehicle->max_weight ?? 10);
        $weightFactor = 1.0;
        if ($weight > $minWeight) {
            $weightFactor += min(0.35, (($weight - $minWeight) / max(1, $maxWeight - $minWeight)) * 0.25);
        }

        $totalEstimatedFare = round(($baseFare + $distanceCharge + $tollCharge) * $weightFactor);
        $estimatedTimeHours = round($distance / 50, 1); // average commercial truck speed ~50km/h

        return response()->json([
            'success' => true,
            'data' => [
                'from_city' => $from,
                'to_city' => $to,
                'vehicle_title' => $vehicle->title,
                'distance_km' => $distance,
                'estimated_hours' => $estimatedTimeHours,
                'base_fare' => $baseFare,
                'per_km_rate' => $perKmRate,
                'distance_charge' => $distanceCharge,
                'toll_charge' => $tollCharge,
                'diesel_price' => $dieselPrice,
                'fuel_liters' => $estimatedLiters,
                'fuel_cost' => $estimatedFuelCost,
                'weight' => $weight,
                'total_fare' => $totalEstimatedFare,
                'currency' => $setting->currency ?? 'PKR'
            ]
        ]);
    }

    /**
     * Terms & Conditions Page
     */
    public function terms()
    {
        $data = $this->getSiteData();
        $page = DB::table('tbl_page')->where('id', 2)->first();
        return view('landing.terms', array_merge($data, ['page' => $page]));
    }

    /**
     * Privacy Policy Page
     */
    public function privacy()
    {
        $data = $this->getSiteData();
        $page = DB::table('tbl_page')->where('id', 3)->first();
        return view('landing.privacy', array_merge($data, ['page' => $page]));
    }

    /**
     * FAQs & Help Center Page
     */
    public function faq()
    {
        $data = $this->getSiteData();
        $faqs = DB::table('tbl_faq')->where('status', 1)->get();
        return view('landing.faq', array_merge($data, ['faqs' => $faqs]));
    }

    /**
     * Contact Us Page
     */
    public function contact()
    {
        $data = $this->getSiteData();
        return view('landing.contact', $data);
    }

    /**
     * Handle Contact Form Submission
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:25',
            'email' => 'nullable|email|max:100',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        // In a live system, we can log the inquiry or send notification to admin
        Log::info("Contact form inquiry received from {$request->name} ({$request->phone}): {$request->subject}");

        return back()->with('contact_success', 'Thank you! Your message has been sent successfully. Our logistics support team will contact you shortly.');
    }

    /**
     * App Download Page
     */
    public function download()
    {
        $data = $this->getSiteData();
        return view('landing.download', $data);
    }
}
