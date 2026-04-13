<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    protected $guarded = [];

    protected $casts = [
        'acquisition_date' => 'date',
    ];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}
