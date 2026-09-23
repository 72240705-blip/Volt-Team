<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charger extends Model
{
    use HasFactory;

    protected $table = 'chargers';
    protected $primaryKey = 'id_charger';
    public $timestamps = false;

    protected $fillable = [
        'id_location',
        'kode_perangkat',
        'tipe_konektor',
        'daya_kw',
        'status',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location', 'id_location');
    }

    public function chargingSessions()
    {
        return $this->hasMany(ChargingSession::class, 'id_charger', 'id_charger');
    }
}