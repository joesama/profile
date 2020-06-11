<?php

namespace Joesama\Profile\Events;

use Illuminate\Support\Str;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Joesama\Profile\Services\Traits\ModelTrait;

class ProfileSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels, ModelTrait;

    /**
     * Profile model.
     *
     * @var Model
     */
    public $user;

    /**
     * Profile model.
     *
     * @var Model
     */
    public $profile;

    /**
     * Request parameters.
     *
     * @var array
     */
    public $request;

    /**
     * User creation flag.
     *
     * @var bool
     */
    public $creation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $profile, array $params, bool $create = false)
    {
        $this->profile = $profile;

        $this->user = $this->model(config('profile.user.model'));

        $this->creation = $create;

        if ($create) {
            $params['password'] =  Str::random(8);
        }

        $this->request = $params;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('profile');
    }
}
