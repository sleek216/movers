<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $title;
    public $description;
    public $data;
    public $timestamp;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, string $title, string $description, array $data = [])
    {
        $this->userId = (string) $userId;
        $this->title = $title;
        $this->description = $description;
        $this->data = $data;
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
        return 'notification.created';
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'type' => 'PUSH_NOTIFICATION',
            'userId' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'data' => $this->data,
            'timestamp' => $this->timestamp,
        ];
    }
}
