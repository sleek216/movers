<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Vehicle Categories
        $vehicles = [
            ['title' => '22-Wheeler Flatbed Trailer', 'img' => 'images/vehicle/trailer.png', 'min_weight' => 20, 'max_weight' => 50, 'status' => 1],
            ['title' => '40ft High Cube Container', 'img' => 'images/vehicle/container.png', 'min_weight' => 15, 'max_weight' => 35, 'status' => 1],
            ['title' => 'Mazda Titan 6-Wheeler', 'img' => 'images/vehicle/mazda.png', 'min_weight' => 5, 'max_weight' => 12, 'status' => 1],
            ['title' => 'Shehzore Pickup 3.5 Ton', 'img' => 'images/vehicle/shehzore.png', 'min_weight' => 1, 'max_weight' => 4, 'status' => 1],
            ['title' => 'Bedford 10-Wheeler Truck', 'img' => 'images/vehicle/bedford.png', 'min_weight' => 10, 'max_weight' => 22, 'status' => 1],
            ['title' => 'Heavy Dumper Tipper', 'img' => 'images/vehicle/dumper.png', 'min_weight' => 15, 'max_weight' => 40, 'status' => 1],
            ['title' => 'Reefer Cold Storage Van', 'img' => 'images/vehicle/reefer.png', 'min_weight' => 3, 'max_weight' => 10, 'status' => 1],
            ['title' => 'Multi-Car Carrier Trailer', 'img' => 'images/vehicle/carcarrier.png', 'min_weight' => 12, 'max_weight' => 30, 'status' => 1],
            ['title' => 'Oil & Liquid Tanker', 'img' => 'images/vehicle/tanker.png', 'min_weight' => 20, 'max_weight' => 45, 'status' => 1],
            ['title' => 'Open Lowbed Heavy Hauler', 'img' => 'images/vehicle/lowbed.png', 'min_weight' => 30, 'max_weight' => 70, 'status' => 1],
        ];

        foreach ($vehicles as $v) {
            DB::table('tbl_vehicle')->updateOrInsert(['title' => $v['title']], $v);
        }

        // 2. States / Operating Routes
        $states = [
            ['title' => 'Punjab', 'img' => 'images/state/punjab.png', 'status' => 1],
            ['title' => 'Sindh', 'img' => 'images/state/sindh.png', 'status' => 1],
            ['title' => 'Khyber Pakhtunkhwa (KPK)', 'img' => 'images/state/kpk.png', 'status' => 1],
            ['title' => 'Balochistan', 'img' => 'images/state/balochistan.png', 'status' => 1],
            ['title' => 'Islamabad Capital', 'img' => 'images/state/islamabad.png', 'status' => 1],
            ['title' => 'Gilgit Baltistan', 'img' => 'images/state/gilgit.png', 'status' => 1],
            ['title' => 'Azad Kashmir (AJK)', 'img' => 'images/state/ajk.png', 'status' => 1],
            ['title' => 'Faisalabad Hub', 'img' => 'images/state/punjab.png', 'status' => 1],
            ['title' => 'Multan Corridor', 'img' => 'images/state/punjab.png', 'status' => 1],
            ['title' => 'Gwadar Port Zone', 'img' => 'images/state/balochistan.png', 'status' => 1],
        ];

        foreach ($states as $s) {
            DB::table('tbl_state')->updateOrInsert(['title' => $s['title']], $s);
        }

        // 3. Lorry Owners / Drivers
        $drivers = [
            ['name' => 'Tariq Mehmood', 'email' => 'tariq.transport@gmail.com', 'mobile' => '03001234561', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Malik Asghar', 'email' => 'asghar.freight@gmail.com', 'mobile' => '03001234562', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Chaudhry Riaz', 'email' => 'riaz.logistics@gmail.com', 'mobile' => '03001234563', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Gul Khan Afridi', 'email' => 'gul.afridi@gmail.com', 'mobile' => '03001234564', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Rana Shahbaz', 'email' => 'shahbaz.cargo@gmail.com', 'mobile' => '03001234565', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Zubair Baloch', 'email' => 'zubair.trucks@gmail.com', 'mobile' => '03001234566', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Hamza Qureshi', 'email' => 'hamza.movers@gmail.com', 'mobile' => '03001234567', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Usman Gujjar', 'email' => 'usman.express@gmail.com', 'mobile' => '03001234568', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Nawazish Ali', 'email' => 'nawazish.fleet@gmail.com', 'mobile' => '03001234569', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
            ['name' => 'Sikandar Hayat', 'email' => 'sikandar.speed@gmail.com', 'mobile' => '03001234570', 'password' => '123456', 'ccode' => '+92', 'is_verify' => 1, 'status' => 1, 'rdate' => $now],
        ];

        foreach ($drivers as $d) {
            DB::table('tbl_lowner')->updateOrInsert(['mobile' => $d['mobile']], $d);
        }

        $ownerIds = DB::table('tbl_lowner')->pluck('id')->toArray();
        $vehicleIds = DB::table('tbl_vehicle')->pluck('id')->toArray();
        $stateIds = DB::table('tbl_state')->pluck('id')->toArray();

        // 4. Live Available Lorries (10 Lorries)
        $lorries = [
            ['lorry_no' => 'LES-24-9841', 'weight' => 35, 'curr_location' => 'Lahore Industrial Area', 'description' => 'Ready for loading. High bed 22-wheeler in prime condition with insurance.'],
            ['lorry_no' => 'KHI-23-4521', 'weight' => 28, 'curr_location' => 'Karachi Port Qasim Terminal', 'description' => '40ft container trailer available for long route Karachi to Punjab.'],
            ['lorry_no' => 'FSD-22-1190', 'weight' => 10, 'curr_location' => 'Faisalabad Textile Mills Zone', 'description' => 'Mazda Titan with tarpaulin waterproof covering ready for yarn & fabric.'],
            ['lorry_no' => 'RWP-21-7764', 'weight' => 4, 'curr_location' => 'Rawalpindi I-9 Dryport', 'description' => 'Shehzore pickup for quick intracity & intercity express deliveries.'],
            ['lorry_no' => 'Pesh-24-3321', 'weight' => 20, 'curr_location' => 'Peshawar Ring Road Terminal', 'description' => 'Bedford 10-wheeler ready for heavy goods, timber and cement bags.'],
            ['lorry_no' => 'MUL-23-6612', 'weight' => 30, 'curr_location' => 'Multan Khanewal Bypass', 'description' => 'Heavy duty flatbed trailer equipped for industrial parts & steel.'],
            ['lorry_no' => 'GWD-24-5541', 'weight' => 40, 'curr_location' => 'Gwadar Freezone Terminal', 'description' => 'Container hauler for CPEC routes and port clearances.'],
            ['lorry_no' => 'HYD-22-8874', 'weight' => 12, 'curr_location' => 'Hyderabad SITE Area', 'description' => 'Closed container 6-wheeler for FMCG, pharmaceuticals and retail.'],
            ['lorry_no' => 'ISB-23-2219', 'weight' => 8, 'curr_location' => 'Islamabad Motorway Toll Plaza', 'description' => 'Reefer temperature controlled vehicle for perishable goods.'],
            ['lorry_no' => 'SKT-24-9002', 'weight' => 15, 'curr_location' => 'Sialkot Sambrial Dryport', 'description' => 'Heavy transporter for leather, surgical items and sports export goods.'],
        ];

        foreach ($lorries as $idx => $l) {
            DB::table('tbl_lorry')->updateOrInsert(
                ['lorry_no' => $l['lorry_no']],
                [
                    'owner_id' => $ownerIds[$idx % count($ownerIds)] ?? 1,
                    'lorry_no' => $l['lorry_no'],
                    'vehicle_id' => $vehicleIds[$idx % count($vehicleIds)] ?? 1,
                    'curr_location' => $l['curr_location'],
                    'curr_state_id' => $stateIds[$idx % count($stateIds)] ?? 1,
                    'routes' => 'All Over Pakistan',
                    'description' => $l['description'],
                    'document' => 'images/lorry/doc.png',
                    'status' => 1,
                    'weight' => $l['weight'],
                    'is_verify' => 1,
                ]
            );
        }

        // 5. Live Freight Loads (10 Posts)
        $loads = [
            ['pickup_point' => 'Lahore Kot Lakhpat Industrial', 'drop_point' => 'Karachi Port Qasim', 'material_name' => 'Export Textile Bales', 'weight' => 32, 'amount' => 145000, 'amt_type' => 'Fixed', 'description' => 'Urgent container requirement for seaport shipment. Tarpaulin covering needed.'],
            ['pickup_point' => 'Faisalabad Samundri Road', 'drop_point' => 'Islamabad I-10 Sector', 'material_name' => 'Cotton Yarn Sacks', 'weight' => 12, 'amount' => 65000, 'amt_type' => 'Fixed', 'description' => 'Dry cargo loading tomorrow morning 9am. Experienced driver needed.'],
            ['pickup_point' => 'Karachi Superhighway SITE', 'drop_point' => 'Peshawar Hayatabad', 'material_name' => 'FMCG Packaged Goods', 'weight' => 24, 'amount' => 180000, 'amt_type' => 'Fixed', 'description' => 'Multi-axle trailer required with verified driver documents.'],
            ['pickup_point' => 'Rawalpindi Industrial Area', 'drop_point' => 'Lahore Sundar Estate', 'material_name' => 'Machinery & Steel Parts', 'weight' => 18, 'amount' => 85000, 'amt_type' => 'Fixed', 'description' => 'Crane loading available at both ends. Secure fastening required.'],
            ['pickup_point' => 'Multan Vehari Road', 'drop_point' => 'Faisalabad Grain Market', 'material_name' => 'Grain & Wheat Bags', 'weight' => 25, 'amount' => 75000, 'amt_type' => 'Fixed', 'description' => 'Direct mill to warehouse delivery. Same day unloading guaranteed.'],
            ['pickup_point' => 'Sialkot Daska Road', 'drop_point' => 'Karachi Airport Cargo', 'material_name' => 'Surgical Equipment Crates', 'weight' => 6, 'amount' => 90000, 'amt_type' => 'Fixed', 'description' => 'Fragile cargo, closed container required with air suspension preferred.'],
            ['pickup_point' => 'Gujranwala GT Road', 'drop_point' => 'Quetta Sariab Road', 'material_name' => 'Sanitary & Ceramic Tiles', 'weight' => 30, 'amount' => 210000, 'amt_type' => 'Fixed', 'description' => 'Heavy load for 22-wheeler flatbed trailer. Fuel advance available.'],
            ['pickup_point' => 'Rahim Yar Khan Mills', 'drop_point' => 'Lahore Badami Bagh', 'material_name' => 'Refined Sugar Bags', 'weight' => 28, 'amount' => 110000, 'amt_type' => 'Fixed', 'description' => 'Immediate loading at factory gate. Weighbridge slip provided.'],
            ['pickup_point' => 'Peshawar Ring Road', 'drop_point' => 'Islamabad Fruit Market', 'material_name' => 'Fresh Apples & Fruits', 'weight' => 14, 'amount' => 55000, 'amt_type' => 'Fixed', 'description' => 'Reefer or ventilated truck required for overnight delivery.'],
            ['pickup_point' => 'Karachi Korangi Area', 'drop_point' => 'Multan Industrial Hub', 'material_name' => 'Chemical & Paint Drums', 'weight' => 20, 'amount' => 135000, 'amt_type' => 'Fixed', 'description' => 'Sealed chemical drums. Drivers with HAZMAT safety experience needed.'],
        ];

        foreach ($loads as $idx => $ld) {
            DB::table('tbl_load')->updateOrInsert(
                ['pickup_point' => $ld['pickup_point'], 'drop_point' => $ld['drop_point']],
                [
                    'uid' => 1,
                    'vehicle_id' => $vehicleIds[$idx % count($vehicleIds)] ?? 1,
                    'load_type' => 'POST_LOAD',
                    'load_status' => 'Pending',
                    'pickup_point' => $ld['pickup_point'],
                    'drop_point' => $ld['drop_point'],
                    'material_name' => $ld['material_name'],
                    'weight' => $ld['weight'],
                    'amount' => $ld['amount'],
                    'amt_type' => $ld['amt_type'],
                    'total_amt' => $ld['amount'],
                    'description' => $ld['description'],
                    'visible_hours' => 24,
                    'pick_lat' => '31.5204',
                    'pick_lng' => '74.3587',
                    'drop_lat' => '24.8607',
                    'drop_lng' => '67.0011',
                    'pick_name' => 'Haji Aslam',
                    'pick_mobile' => '03009876543',
                    'drop_name' => 'Sheikh Farooq',
                    'drop_mobile' => '03008765432',
                    'pick_state_id' => $stateIds[$idx % count($stateIds)] ?? 1,
                    'drop_state_id' => $stateIds[($idx + 1) % count($stateIds)] ?? 1,
                    'post_date' => $now->copy()->subHours($idx * 3),
                    'status' => 1,
                ]
            );
        }

        // 6. FAQs (10 Items)
        $faqs = [
            ['question' => 'How do I post a new load for bidding?', 'answer' => 'Tap on "Post Loads" on the home dashboard, enter pickup and drop points, material type, weight, and your price offer. Drivers will start sending bids immediately.'],
            ['question' => 'How does driver bidding work (inDrive style)?', 'answer' => 'Once your load is published, verified lorry owners submit their price offers. You can view driver ratings, vehicle specifications, and accept or reject offers in real-time.'],
            ['question' => 'Are all drivers on Movers identity verified?', 'answer' => 'Yes, every lorry owner and driver submits their CNIC, Driving License, and live selfie documents which are thoroughly verified by our admin team before account approval.'],
            ['question' => 'How can I recharge my Movers Wallet?', 'answer' => 'Go to the Profile tab, tap "My Wallet & Transactions", select "Recharge Wallet", enter the deposit amount and complete the payment through your preferred gateway.'],
            ['question' => 'What should I do if cargo delivery is delayed?', 'answer' => 'You can directly call the driver from the active load card using the call button, or reach out to our 24/7 dedicated support team through the Helpdesk.'],
            ['question' => 'Can I cancel a published load?', 'answer' => 'Yes, you can cancel or edit a load post anytime before you accept a driver bid from the "My Loads" tab.'],
            ['question' => 'What vehicle categories are supported?', 'answer' => 'Movers supports 22-Wheeler Trailers, 40ft Containers, Mazda Titans, Shehzore Pickups, Bedford Trucks, Dumpers, Reefer Cold Vans, and Car Carriers.'],
            ['question' => 'How do I complete KYC Identity Verification?', 'answer' => 'Open Profile -> Identity Verification (KYC), upload a clear photo of your National ID / Driving License, take a live selfie with your camera, and tap Submit.'],
            ['question' => 'Is there any commission charged on load posting?', 'answer' => 'Posting loads and receiving driver bids is completely free for cargo owners and shippers.'],
            ['question' => 'How do I contact Movers customer support?', 'answer' => 'You can contact us 24/7 via the in-app Helpdesk, WhatsApp helpline, or by sending an email to support@movers.com.'],
        ];

        foreach ($faqs as $f) {
            DB::table('tbl_faq')->updateOrInsert(
                ['question' => $f['question']],
                [
                    'question' => $f['question'],
                    'answer' => $f['answer'],
                    'status' => 1,
                ]
            );
        }
    }
}
