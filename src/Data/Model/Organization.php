<?php

namespace Joesama\Profile\Data\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];

    protected $table = 'organization';
}
