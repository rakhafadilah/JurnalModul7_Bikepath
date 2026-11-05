<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JalurSepeda extends Model
{
    protected $table = 'jalur_sepeda';

    protected $fillable = [
        'nama', 'kota', 'titik_awal', 'titik_akhir',
        'jarak_km', 'tingkat_kesulitan', 'deskripsi', 'foto',
    ];

    public function aktivitas()
    {
        return $this->hasMany(Aktivitas::class);
    }
}
