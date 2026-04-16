<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    /**
     * Kolom yang boleh diisi secara mass assignment.
     * Menggunakan $fillable eksplisit lebih aman daripada $guarded = [].
     */
    protected $fillable = [
        'title',
        'author',
        'description',
        'cover_image',
        'status',
        'priority',
        'price',
    ];

    /**
     * Definisi cast tipe data untuk atribut model.
     */
    protected $casts = [
        'price' => 'float',
    ];

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Kembalikan label status dalam Bahasa Indonesia.
     * Dipanggil dari view sebagai $comic->statusLabel().
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'reading'      => 'Sedang Dibaca',
            'completed'    => 'Selesai',
            'wishlist'     => 'Incaran',
            'plan_to_read' => 'Rencana Dibaca',
            default        => str_replace('_', ' ', $this->status),
        };
    }
}
