<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $primaryKey = 'id_location';
    public $timestamps = false;

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'latitude',
        'longitude',
        'jam_operasional',
        'fasilitas',
        'foto_lokasi',
        'status',
    ];

    public function chargers()
    {
        return $this->hasMany(Charger::class, 'id_location', 'id_location');
    }

    public function tariffs()
    {
        return $this->hasMany(Tariff::class, 'id_location', 'id_location');
    }
}