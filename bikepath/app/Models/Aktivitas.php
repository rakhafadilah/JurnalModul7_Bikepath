<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    protected $table = 'aktivitas';

    protected $fillable = [
        'user_id', 'jalur_sepeda_id', 'judul', 'tanggal',
        'durasi_menit', 'jarak_km', 'kecepatan_rata', 'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jalur()
    {
        return $this->belongsTo(JalurSepeda::class, 'jalur_sepeda_id');
    }
}
