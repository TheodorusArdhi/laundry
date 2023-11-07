<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Status;
use App\Models\Pengumuman;

class Transaksi extends Model
{
    use HasFactory;

    protected $dates = ['tgl_masuk', 'tgl_selesai', 'tgl_ambil', 'tgl_tenggat'];
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_admin', 'id_user', 'id_status_pembayaran', 'id_status_transaksi', 'id_pengumuman', 'no_transaksi', 'tgl_masuk', 'tgl_selesai', 'tgl_ambil', 'tgl_tenggat', 'total_harga', 'diskon', 'total_tagihan', 'diterima', 'komplain'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function admin(){
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    public function statusPembayaran(){
        return $this->belongsTo(Status::class, 'id_status_pembayaran', 'id_status');
    }

    public function statusTransaksi(){
        return $this->belongsTo(Status::class, 'id_status_transaksi', 'id_status');
    }

    public function pengumuman(){
        return $this->belongsTo(Pengumuman::class, 'id_pengumuman', 'id_pengumuman');
    }

}
