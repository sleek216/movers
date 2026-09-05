<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FirebasePushService
{
    /**
     * Send push notification to a specific user or device
     *
     * @param string|null $fcmToken
     * @param string $title
     * @param string $body
     * @param array $data
     * @return bool
     */
    public static function sendPush(?string $fcmToken, string $title, string $body, array $data = []): bool
    {
        if (empty($fcmToken)) {
            Log::info("Push notification skipped: Empty FCM token for title: {$title}");
            return false;
        }

        try {
            // FCM Legacy / HTTP API payload with InDrive-style high-priority and sound
            $payload = [
                'to' => $fcmToken,
                'priority' => 'high',
                'content_available' => true,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'android_channel_id' => 'movers_channel_id',
                    'badge' => '1',
                ],
                'data' => array_merge([
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                ], $data),
            ];

            // Server key from Setting table or direct config
            $serverKey = env('FIREBASE_SERVER_KEY', '');

            if (empty($serverKey)) {
                $setting = DB::table('tbl_setting')->first();
                if ($setting && !empty($setting->one_key) && $setting->one_key !== 'Mover') {
                    $serverKey = $setting->one_key;
                }
            }

            if (!empty($serverKey)) {
                $response = Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type' => 'application/json',
                ])->post('https://fcm.googleapis.com/fcm/send', $payload);

                Log::info("FCM Push response: " . $response->body());
                return $response->successful();
            }

            Log::info("Push notification logged: [{$title}] {$body}");
            return true;
        } catch (\Exception $e) {
            Log::error("FCM Push error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Store in notification database and send FCM push to user
     */
    public static function notifyUser($userId, string $title, string $body, array $data = []): bool
    {
        if (empty($userId)) return false;

        try {
            // 1. Insert into notification history for in-app display
            DB::table('tbl_notification')->insert([
                'uid' => $userId,
                'datetime' => now()->format('Y-m-d H:i:s'),
                'title' => $title,
                'description' => $body,
            ]);

            // 2. Dispatch Live Broadcast Event for Sub-second Realtime Sync
            try {
                if (isset($data['type']) && $data['type'] === 'kyc_status') {
                    event(new \App\Events\KycStatusUpdated(
                        $userId,
                        $data['status'] ?? '1',
                        $data['comment'] ?? '',
                        $title,
                        $body
                    ));
                } else {
                    event(new \App\Events\RealtimeNotificationEvent(
                        $userId,
                        $title,
                        $body,
                        $data
                    ));
                }
            } catch (\Exception $broadcastEx) {
                Log::warning("Event broadcast warning: " . $broadcastEx->getMessage());
            }

            // 3. Query user's FCM token
            $user = DB::table('tbl_user')->where('id', $userId)->first();
            if ($user && !empty($user->fcm_token)) {
                return self::sendPush($user->fcm_token, $title, $body, array_merge(['uid' => (string)$userId], $data));
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Error in notifyUser: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send push notification to lorry owner / transporter
     */
    public static function notifyTransporter($ownerId, string $title, string $body, array $data = []): bool
    {
        if (empty($ownerId)) return false;

        try {
            $owner = DB::table('tbl_lowner')->where('id', $ownerId)->first();
            if ($owner && !empty($owner->fcm_token)) {
                return self::sendPush($owner->fcm_token, $title, $body, array_merge(['owner_id' => (string)$ownerId], $data));
            }
            return true;
        } catch (\Exception $e) {
            Log::error("Error in notifyTransporter: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Broadcast notification to all active transporters (e.g. on new load posted)
     */
    public static function broadcastToAllTransporters(string $title, string $body, array $data = []): void
    {
        try {
            $tokens = DB::table('tbl_lowner')
                ->where('status', 1)
                ->whereNotNull('fcm_token')
                ->where('fcm_token', '!=', '')
                ->pluck('fcm_token');

            foreach ($tokens as $token) {
                self::sendPush($token, $title, $body, $data);
            }
        } catch (\Exception $e) {
            Log::error("Error in broadcastToAllTransporters: " . $e->getMessage());
        }
    }
}

