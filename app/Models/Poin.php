<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\Cabang;

class Poin extends Model
{
    use HasFactory;

    protected $dates = ['tgl_tenggat'];
    protected $table = 'poin';
    protected $primaryKey = 'id_poin';
    protected $fillable = [
        'id_user', 'id_transaksi', 'id_cabang', 'jumlah', 'tgl_tenggat', 'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }
}
