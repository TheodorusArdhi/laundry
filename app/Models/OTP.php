<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $table = 'otp';
    protected $primaryKey = 'id_otp';
    protected $fillable = [
        'id_user', 'otp', 'waktu'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
