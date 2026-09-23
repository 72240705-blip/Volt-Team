<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargingSession extends Model
{
    use HasFactory;

    protected $table = 'charging_sessions';
    protected $primaryKey = 'id_session';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_charger',
        'waktu_mulai',
        'waktu_selesai',
        'energi_kwh',
        'tarif_per_kwh_snapshot',
        'estimasi_biaya',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function charger()
    {
        return $this->belongsTo(Charger::class, 'id_charger', 'id_charger');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_session', 'id_session');
    }
}