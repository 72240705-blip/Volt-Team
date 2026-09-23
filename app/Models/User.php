<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Menyesuaikan Primary Key & Tabel khusus DB rpl2026
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false; // Set false jika tabel tidak menggunakan created_at/updated_at

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
    'nama',
    'email',
    'password',
    'nomor_telepon', 
    'peran',
    'status_akun',
    ];

    /**
     * Kolom yang disembunyikan saat data di-convert ke Array/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel Kendaraan
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'id_user', 'id_user');
    }

    // Relasi ke tabel Sesi Charging
    public function chargingSessions()
    {
        return $this->hasMany(ChargingSession::class, 'id_user', 'id_user');
    }
}