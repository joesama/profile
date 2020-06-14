<?php

namespace Joesama\Profile\Data\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Joesama\Profile\Data\Traits\UseProfileFilter;

class Profile extends Model
{
    use Notifiable, SoftDeletes, UseProfileFilter;
    
    protected $table = 'profiles';

    protected $guarded = ['id'];

    /**
     * The position that belong to the profile.
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position');
    }

    /**
     * The user that belong to the profile.
     */
    public function user()
    {
        return $this->morphTo('user', 'user_type', 'user_id', config('profile.user.uuid'));
    }
}
