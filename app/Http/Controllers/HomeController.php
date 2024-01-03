<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Status;
use Session;
Use Illuminate\Support\Facades\Hash;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Str;
use Form;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard(){   
        if(Transaksi::where('id_user', null)->count() != 0){
            $id_transaksi = Transaksi::where('id_user', null)->first()->id_transaksi;
            TransaksiDetail::where('id_transaksi', $id_transaksi)->delete();
            Transaksi::where('id_transaksi', $id_transaksi)->delete();
        }
        $transaksi = Transaksi::count();
        $proses = Transaksi::where('id_status_transaksi', 3)->count();
        $diambil = Transaksi::where('id_status_transaksi', 7)->count();
        $batasWaktu = Transaksi::where('id_status_transaksi', 6)->count();

        $data = Transaksi::select('total_tagihan', 'tgl_masuk')->where('id_status_pembayaran', 1)->whereYear('tgl_masuk', now()->year)->orderBy('tgl_masuk', 'asc')->get()->groupBy(function($data){
            return Carbon::parse($data->tgl_masuk)->translatedFormat('F');
        });
        $bulans=[];
        $bulanTotal=[];
        $max=[];
        foreach($data as $bulan => $value){
            $bulans[]=$bulan;
            $bulanTotal[]=$value->sum('total_tagihan');
        }

        if($bulanTotal == null){
            $max = [0];
        }else{
            $max = round(max($bulanTotal), -5)+100000;
        }
        //dd($max);
        return view('dashboard', compact('transaksi', 'proses', 'diambil', 'batasWaktu', 'bulans', 'max', 'bulanTotal'));
    }

    public function home(){ 
        $layanan = Layanan::where('status', 'aktif')->get();
        $pengumuman = Pengumuman::all();
        return view('home', compact('layanan', 'pengumuman'));
    }

}
