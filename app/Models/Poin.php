<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Poin extends Model
{
    use HasFactory;

    protected $dates = ['tgl_tenggat'];
    protected $table = 'poin';
    protected $primaryKey = 'id_poin';
    protected $fillable = [
        'id_user', 'jumlah', 'tgl_tenggat'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
