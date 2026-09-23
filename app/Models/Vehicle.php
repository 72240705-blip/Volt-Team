<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $primaryKey = 'id_vehicle';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'merek',
        'model',
        'nomor_polisi',
        'tipe_konektor',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}