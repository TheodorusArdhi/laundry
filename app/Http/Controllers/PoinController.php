<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poin;
use App\Models\User;
use App\Models\Transaksi;
use Auth;

class PoinController extends Controller
{
    public function indexAdmin(){  
        $user = 'Semua';
        $pengguna = User::whereIn("level", ["anggota"])->get();
        //$transaksi = Transaksi::orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->get();
        $temp = Poin::select('id_transaksi')->get();
        $poin = Poin::orderBy('id_user', 'asc')->orderBy('status', 'asc')->orderBy('tgl_tenggat', 'asc')->get();
        return view('poin.index', compact('poin', 'user', 'pengguna'));
    }

    public function indexUser(){  
        $poin = Poin::where('id_user', Auth::user()->id_user)->orderBy('status', 'asc')->orderBy('tgl_tenggat', 'asc')->get();
        $user = User::find(Auth::user()->id_user);
        return view('poin.index', compact('poin', 'user'));
    }

    public function poin(Request $request){  
        if($request->nama == "Semua"){
            return redirect('admin/poin');          
        }

        $user = User::find($request->nama);
        $pengguna = User::whereIn("level", ["pelanggan", "anggota"])->get();
        $transaksi = Transaksi::orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->where('id_user', $request->nama)->get();
        $poin = Poin::where('id_user', $request->nama)->orderBy('status', 'asc')->orderBy('tgl_tenggat', 'asc')->get();
        $sum = Poin::where('id_user', $request->nama)->where('status', 'aktif')->sum('jumlah');
        return view('poin.index', compact('poin', 'user', 'transaksi', 'pengguna', 'sum'));
    }
}
