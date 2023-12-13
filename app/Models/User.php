<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticateable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cabang;

class User extends Authenticateable 
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'id_cabang', 'nama', 'no_telp', 'level', 'email', 'password', 'notifikasi', 'remember_token'
    ];

    public function cabang(){
        return $this->belongsTo(User::class, 'id_cabang', 'id_cabang');
    }
}
