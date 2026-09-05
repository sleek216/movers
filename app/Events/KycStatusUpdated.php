<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KycStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $status;
    public $comment;
    public $title;
    public $description;
    public $timestamp;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $status, $comment = '', $title = '', $description = '')
    {
        $this->userId = (string) $userId;
        $this->status = (string) $status; // '1' = Approved, '2' = Rejected
        $this->comment = (string) $comment;
        $this->title = $title ?: ($status == 1 ? 'KYC Verification Approved 🎉' : 'KYC Verification Update ⚠️');
        $this->description = $description ?: (
            $status == 1
                ? 'Mubarak ho! Your identity documents have been approved by Movers Admin. Full features unlocked.'
                : 'Your identity documents were rejected. Reason: ' . ($comment ?: 'Incomplete or unclear photos. Please re-upload.')
        );
        $this->timestamp = now()->toIso8601String();
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return [
            new Channel('user.' . $this->userId),
            new Channel('global.notifications')
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs()
    {
        return 'kyc.updated';
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'type' => 'KYC_STATUS_UPDATE',
            'userId' => $this->userId,
            'status' => $this->status,
            'comment' => $this->comment,
            'title' => $this->title,
            'description' => $this->description,
            'timestamp' => $this->timestamp,
        ];
    }
}
