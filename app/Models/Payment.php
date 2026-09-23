<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'id_payment';
    public $timestamps = false;

    protected $fillable = [
        'id_session',
        'metode',
        'jumlah',
        'status',
        'waktu_pembayaran',
        'referensi_gateway',
    ];

    public function chargingSession()
    {
        return $this->belongsTo(ChargingSession::class, 'id_session', 'id_session');
    }
}