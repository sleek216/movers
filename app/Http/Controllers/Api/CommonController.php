<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CountryCode;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function countryCodes()
    {
        $codes = CountryCode::where('status', 1)->get();
        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Country Code List Received!',
            'CountryCode' => $codes
        ]);
    }

    public function homePage(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::find($uid);
        $settings = Setting::first();

        $banners = Banner::where('status', 1)->get()->map(function ($item) {
            return [
                'id'     => (string) $item->id,
                'img'    => (string) $item->img,
                'status' => (string) $item->status,
                'b_type' => (string) $item->b_type,
            ];
        });

        $states = State::where('status', 1)->get();

        // Batch load counts — 2 queries total instead of 2 per state (N+1 fix)
        $stateIds = $states->pluck('id');

        $loadCountsPick = DB::table('tbl_load')
            ->whereIn('pick_state_id', $stateIds)
            ->select('pick_state_id as state_id', DB::raw('count(*) as cnt'))
            ->groupBy('pick_state_id')
            ->pluck('cnt', 'state_id');

        $loadCountsDrop = DB::table('tbl_load')
            ->whereIn('drop_state_id', $stateIds)
            ->select('drop_state_id as state_id', DB::raw('count(*) as cnt'))
            ->groupBy('drop_state_id')
            ->pluck('cnt', 'state_id');

        $lorryCounts = DB::table('tbl_lorry')
            ->whereIn('curr_state_id', $stateIds)
            ->select('curr_state_id as state_id', DB::raw('count(*) as cnt'))
            ->groupBy('curr_state_id')
            ->pluck('cnt', 'state_id');

        $stateList = $states->map(function ($state) use ($loadCountsPick, $loadCountsDrop, $lorryCounts) {
            $totalLoad  = ($loadCountsPick[$state->id] ?? 0) + ($loadCountsDrop[$state->id] ?? 0);
            $totalLorry = $lorryCounts[$state->id] ?? 0;
            return [
                'id'          => (string) $state->id,
                'title'       => (string) $state->title,
                'img'         => (string) $state->img,
                'status'      => (string) $state->status,
                'total_load'  => (int) $totalLoad,
                'total_lorry' => (int) $totalLorry,
            ];
        });

        return response()->json([
            'ResponseCode' => '200',
            'Result'       => 'true',
            'ResponseMsg'  => 'Home Data Received!',
            'HomeData'     => [
                'wallet'    => (string) ($user ? $user->wallet : 0),
                'currency'  => $settings ? ($settings->currency ?? '$') : '$',
                'is_verify' => (string) ($user ? $user->is_verify : 0),
                'top_msg'   => 'Welcome to Movers Freight & Logistics',
                'Banner'    => $banners,
                'Statelist' => $stateList,
            ]
        ]);
    }

    public function vehicles()
    {
        $vehicles = Vehicle::where('status', 1)->get();
        $setting = DB::table('tbl_setting')->first();
        $dieselPrice = $setting->diesel_price ?? 275.00;

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Vehicle List Received!',
            'VehocleList' => $vehicles,
            'diesel_price' => (string) $dieselPrice,
        ]);
    }

    public function calculatorSettings()
    {
        $vehicles = Vehicle::where('status', 1)->get();
        $setting = DB::table('tbl_setting')->first();
        $dieselPrice = $setting->diesel_price ?? 275.00;

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Calculator Settings Received!',
            'diesel_price' => (string) $dieselPrice,
            'google_map_key' => (string) ($setting->google_map_key ?? ''),
            'ai_provider' => (string) ($setting->ai_provider ?? 'gemini'),
            'vehicles' => $vehicles,
        ]);
    }

    public function states()
    {
        $states = State::where('status', 1)->get();
        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'State List Received!',
            'Statelist' => $states
        ]);
    }

    public function faqs()
    {
        $faqs = Faq::where('status', 1)->get();
        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'FAQ List Received!',
            'FaqData' => $faqs
        ]);
    }

    public function pages()
    {
        $pages = Page::where('status', 1)->get();
        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Page List Received!',
            'pagelist' => $pages
        ]);
    }

    public function notifications(Request $request)
    {
        $uid = $request->input('uid');
        $notifications = Notification::where('uid', $uid)->orderBy('id', 'desc')->get();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Notifications Received!',
            'NotificationData' => $notifications
        ]);
    }

    public function aiParseRoute(Request $request)
    {
        $raw = $request->input('text') ?? $request->input('speech_text') ?? $request->input('query');
        if (empty($raw) && $request->isJson()) {
            $raw = $request->json('text') ?? $request->json('speech_text') ?? $request->json('query');
        }
        if (empty($raw)) {
            $body = json_decode($request->getContent(), true);
            if (is_array($body)) {
                $raw = $body['text'] ?? $body['speech_text'] ?? $body['query'] ?? '';
            }
        }
        $text = trim((string)$raw);

        if (empty($text)) {
            return response()->json([
                'ResponseCode' => '400',
                'Result' => 'false',
                'ResponseMsg' => 'Text query is required'
            ]);
        }

        $setting = DB::table('tbl_setting')->first();
        $aiProvider = $setting->ai_provider ?? 'gemini';
        $geminiKey = !empty($setting->gemini_api_key) ? $setting->gemini_api_key : env('GEMINI_API_KEY', '');
        $openaiKey = $setting->openai_api_key ?? '';

        $from = null;
        $to = null;

        // 1. ChatGPT / OpenAI Provider
        if ($aiProvider === 'chatgpt' && !empty($openaiKey)) {
            $ch = curl_init('https://api.openai.com/v1/chat/completions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $openaiKey
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an AI route extractor for Pakistan logistics. Extract pickup origin ("from") and destination ("to") from the user sentence. Reply ONLY in raw JSON: {"from": "...", "to": "..."}'
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'temperature' => 0.2
            ]));

            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $data = json_decode($response, true);
                $rawText = $data['choices'][0]['message']['content'] ?? '';
                $rawText = preg_replace('/```json|```/', '', $rawText);
                $parsed = json_decode(trim($rawText), true);
                if (is_array($parsed)) {
                    $from = $parsed['from'] ?? null;
                    $to = $parsed['to'] ?? null;
                }
            }
        }
        // 2. Google Gemini AI Provider (Default)
        else {
            $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent?key=' . $geminiKey;
            $prompt = "You are an expert AI route extractor for Pakistan logistics. Extract Pickup ('from') and Drop ('to') location from the user sentence: '$text'. Output ONLY a raw valid JSON object without markdown or code fences: {\"from\": \"...\", \"to\": \"...\"}. If a location is not mentioned, use null.";

            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]));

            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $data = json_decode($response, true);
                $rawText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $rawText = preg_replace('/```json|```/', '', $rawText);
                $parsed = json_decode(trim($rawText), true);
                if (is_array($parsed)) {
                    $from = $parsed['from'] ?? null;
                    $to = $parsed['to'] ?? null;
                }
            }
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ai_engine' => $aiProvider,
            'from' => $from,
            'to' => $to,
            'raw_query' => $text
        ]);
    }
}