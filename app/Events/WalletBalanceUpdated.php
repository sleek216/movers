<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WalletBalanceUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $newBalance;
    public $amount;
    public $type;
    public $message;
    public $timestamp;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $newBalance, $amount, $type = 'Credit', $message = '')
    {
        $this->userId = (string) $userId;
        $this->newBalance = (string) $newBalance;
        $this->amount = (string) $amount;
        $this->type = $type;
        $this->message = $message;
        $this->timestamp = now()->toIso8601String();
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return [
            new Channel('user.' . $this->userId)
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs()
    {
        return 'wallet.updated';
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'type' => 'WALLET_UPDATE',
            'userId' => $this->userId,
            'newBalance' => $this->newBalance,
            'amount' => $this->amount,
            'status' => $this->type,
            'message' => $this->message,
            'timestamp' => $this->timestamp,
        ];
    }
}
