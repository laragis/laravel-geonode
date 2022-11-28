<?php

namespace TungTT\LaravelGeoNode\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FeatureCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $feature;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($feature)
    {
        $this->feature = $feature;
    }
}
