<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class PenjualanExport implements FromView, ShouldAutoSize
{
    protected $awal;
    protected $akhir;

    function __construct($awal, $akhir) {
        $this->awal = $awal;
        $this->akhir = $akhir;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $penjualan = Transaksi::whereBetween('tgl_masuk', [$this->awal, $this->akhir])->get();
        return view('laporan.tabel.tabelPenjualan', [
            'penjualan' => $penjualan,
            'awal' => $this->awal,
            'akhir' => $this->akhir
        ]);
    }
}
