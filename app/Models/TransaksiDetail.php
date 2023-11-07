<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transaksi;
use App\Models\Layanan;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id_transaksi_detail';
    protected $fillable = [
        'id_transaksi', 'id_layanan', 'jumlah', 'harga', 'subtotal'
    ];

    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function layanan(){
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }

}
