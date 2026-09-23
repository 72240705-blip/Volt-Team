<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    protected $table = 'tariffs';
    protected $primaryKey = 'id_tariff';
    public $timestamps = false;

    protected $fillable = [
        'id_location',
        'harga_per_kwh',
        'biaya_minimum',
        'biaya_parkir',
        'biaya_admin',
        'periode_berlaku',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location', 'id_location');
    }
}