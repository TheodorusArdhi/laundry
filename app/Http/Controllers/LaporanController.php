<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Layanan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenjualanExport;
use App\Exports\LayananExport;

class LaporanController extends Controller
{
    public function penjualan(){ 
        $transaksi = Transaksi::where('id_status_transaksi', '<', 8);
        $penjualan = $transaksi->get();
        $awal = $transaksi->min('tgl_masuk');
        $awal = date('d/m/Y', strtotime($awal));
        $akhir = $transaksi->max('tgl_masuk');
        $akhir = date('d/m/Y', strtotime($akhir));
        return view('laporan.penjualan', compact('penjualan', 'awal', 'akhir'));
    }
    
    public function layanan(){ 
        $batal = Transaksi::where('id_status_transaksi', 8)->select('id_transaksi')->pluck('id_transaksi');
        $layananCount = [ 'layanan' => Layanan::select('id_layanan')->get()];
        foreach ($layananCount['layanan'] as $key => $value) {
            $value->nama = Layanan::where('id_layanan', $value->id_layanan)->first()->nama;
            $value->harga = Layanan::where('id_layanan', $value->id_layanan)->first()->harga;
            $value->satuan = Layanan::where('id_layanan', $value->id_layanan)->first()->satuan;
            $value->jumlah = TransaksiDetail::where('id_layanan', $value->id_layanan)->whereNotIn('id_transaksi', $batal)->sum('jumlah');
            $value->pemasukan = TransaksiDetail::where('id_layanan', $value->id_layanan)->whereNotIn('id_transaksi', $batal)->sum('subtotal');
        }
        $awal = Transaksi::min('tgl_masuk');
        $awal = date('d/m/Y', strtotime($awal));
        $akhir = Transaksi::max('tgl_masuk');
        $akhir = date('d/m/Y', strtotime($akhir));
        return view('laporan.layanan', compact('layananCount', 'awal', 'akhir'));
    }
    
    public function tanggalPenjualan(Request $request){ 
        $awal = $request->awal;
        $akhir = $request->akhir;
        $penjualan = Transaksi::where('id_status_transaksi', '<', 8)->whereBetween('tgl_masuk', [
            Carbon::createFromFormat('d/m/Y', $awal)->format('Y-m-d'), 
            Carbon::createFromFormat('d/m/Y', $akhir)->format('Y-m-d')])->get();
        return view('laporan.penjualan', compact('penjualan', 'awal', 'akhir'));
    }

    public function tanggalLayanan(Request $request){ 
        $batal = Transaksi::where('id_status_transaksi', 8)->select('id_transaksi')->pluck('id_transaksi');
        $awal = $request->awal;
        $akhir = $request->akhir;
        $layananCount = [ 'layanan' => Layanan::select('id_layanan')->get()];
        foreach ($layananCount['layanan'] as $key => $value) {
            $value->nama = Layanan::where('id_layanan', $value->id_layanan)->first()->nama;
            $value->harga = Layanan::where('id_layanan', $value->id_layanan)->first()->harga;
            $value->satuan = Layanan::where('id_layanan', $value->id_layanan)->first()->satuan;
            $value->jumlah = TransaksiDetail::where('id_layanan', $value->id_layanan)->whereBetween('created_at', [
                Carbon::createFromFormat('d/m/Y', $awal)->startOfDay(), 
                Carbon::createFromFormat('d/m/Y', $akhir)->endOfDay()])->whereNotIn('id_transaksi', $batal)->sum('jumlah');
            $value->pemasukan = TransaksiDetail::where('id_layanan', $value->id_layanan)->whereBetween('created_at', [
                Carbon::createFromFormat('d/m/Y', $awal)->startOfDay(), 
                Carbon::createFromFormat('d/m/Y', $akhir)->endOfDay()])->whereNotIn('id_transaksi', $batal)->sum('subtotal');
        }
        return view('laporan.layanan', compact('layananCount', 'awal', 'akhir'));
    }
    
    public function penjualanExport(Request $request, $awal, $akhir){
        $tgl_awal = Carbon::createFromFormat('Y-m-d', $awal)->format('d-m-Y');
        $tgl_akhir = Carbon::createFromFormat('Y-m-d', $akhir)->format('d-m-Y');
        return Excel::download(new PenjualanExport($awal, $akhir), 'Laporan Penjualan '.$tgl_awal.' - '.$tgl_akhir.'.xlsx');
    }
    
    public function layananExport(Request $request, $awal, $akhir){
        $tgl_awal = Carbon::createFromFormat('Y-m-d', $awal)->format('d-m-Y');
        $tgl_akhir = Carbon::createFromFormat('Y-m-d', $akhir)->format('d-m-Y');
        return Excel::download(new LayananExport($awal, $akhir), 'Laporan Layanan '.$tgl_awal.' - '.$tgl_akhir.'.xlsx');
    }
}
   