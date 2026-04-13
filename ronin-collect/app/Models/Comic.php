<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $guarded = [];

    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }
}
