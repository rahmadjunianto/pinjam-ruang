<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nip',
        'name',
        'email',
        'password',
        'bidang_id',
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

    /**
     * Get the profile URL for AdminLTE user menu.
     *
     * @return string
     */
    public function adminlte_profile_url(): string
    {
        return route('profile.show');
    }

    /**
     * Get the profile image URL for AdminLTE user menu.
     *
     * @return string
     */
    public function adminlte_image(): string
    {
        // Return default avatar or user's profile image
        return asset('images/default-avatar.svg');
    }

    /**
     * Get the user description for AdminLTE user menu.
     *
     * @return string
     */
    public function adminlte_desc(): string
    {
        return $this->nip ?? 'Pegawai Kemenag';
    }

    /**
     * Get the bookings for this user.
     */
    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class, 'user_id');
    }

    /**
     * Get the bidang for this user.
     */
    public function bidang()
    {
        return $this->belongsTo(\App\Models\Bidang::class, 'bidang_id');
    }
}
