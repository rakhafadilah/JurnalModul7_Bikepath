<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomunitasPesan extends Model
{
    protected $table = 'komunitas_pesan';

    protected $fillable = ['komunitas_id', 'user_id', 'pesan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
