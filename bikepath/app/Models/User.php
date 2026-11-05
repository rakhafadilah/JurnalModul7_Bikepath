<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'email',
        'password',
        'bike_type',
        'cycling_level',
        'address',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** URL foto profil (null jika belum upload). Dipanggil dengan $user->avatar_url */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    public function aktivitas()
    {
        return $this->hasMany(Aktivitas::class);
    }

    /** Rider yang saya ikuti (tabel friendships) */
    public function following()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')->withTimestamps();
    }

    /** Komunitas yang saya ikuti (tabel komunitas_user) */
    public function komunitas()
    {
        return $this->belongsToMany(Komunitas::class, 'komunitas_user', 'user_id', 'komunitas_id')->withTimestamps();
    }
}
