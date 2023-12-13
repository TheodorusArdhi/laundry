<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cabang;

class Penyimpanan extends Model
{
    use HasFactory;

    protected $table = 'penyimpanan';
    protected $primaryKey = 'id_penyimpanan';
    protected $fillable = [
        'id_cabang', 'nama', 'merek', 'jumlah', 'harga'
    ];

    public function cabang(){
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }
}
