<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komunitas extends Model
{
    protected $table = 'komunitas';

    protected $fillable = ['nama', 'kota', 'deskripsi', 'jumlah_anggota'];

    public function anggota()
    {
        return $this->belongsToMany(User::class, 'komunitas_user', 'komunitas_id', 'user_id')->withTimestamps();
    }

    public function pesan()
    {
        return $this->hasMany(KomunitasPesan::class, 'komunitas_id');
    }
}
