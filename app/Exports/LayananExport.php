<?php

namespace App\Exports;

use App\Models\TransaksiDetail;
use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class LayananExport implements FromView, ShouldAutoSize
{
    protected $awal;
    protected $akhir;

    function __construct($awal, $akhir) {
        $this->awal = Carbon::createFromFormat('Y-m-d', $awal)->format('Y-m-d')." 00:00:00";
        $this->akhir = Carbon::createFromFormat('Y-m-d', $akhir)->format('Y-m-d')." 23:59:59";
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $batal = Transaksi::where('id_status_transaksi', 8)->select('id_transaksi')->pluck('id_transaksi');
        $layananCount = [ 'layanan' => Layanan::select('id_layanan')->get()];
        foreach ($layananCount['layanan'] as $key => $value) {
            $value->nama = Layanan::where('id_layanan', $value->id_layanan)->first()->nama;
            $value->harga = Layanan::where('id_layanan', $value->id_layanan)->first()->harga;
            $value->satuan = Layanan::where('id_layanan', $value->id_layanan)->first()->satuan;
            $value->jumlah = TransaksiDetail::whereBetween('created_at', [$this->awal, $this->akhir])->where('id_layanan', $value->id_layanan)->whereNotIn('id_transaksi', $batal)->sum('jumlah');
            $value->pemasukan = TransaksiDetail::whereBetween('created_at', [$this->awal, $this->akhir])->where('id_layanan', $value->id_layanan)->whereNotIn('id_transaksi', $batal)->sum('subtotal');
        }
        $awal = Carbon::createFromFormat('Y-m-d H:i:s', $this->awal)->format('Y-m-d');
        $akhir = Carbon::createFromFormat('Y-m-d H:i:s', $this->akhir)->format('Y-m-d');
        return view('laporan.tabel.tabelLayanan', [
            'layananCount' => $layananCount,
            'awal' => $awal,
            'akhir' => $akhir
        ]);
    }
}
