<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    protected $guarded = [];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}
