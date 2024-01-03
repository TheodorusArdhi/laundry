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
        $pengguna = User::where("level", "pengguna")->get();
        //$transaksi = Transaksi::orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->get();
        $poin = Poin::where('status', 'aktif')->orderBy('tgl_tenggat', 'asc')->get();
        return view('poin.index', compact('poin', 'user', 'pengguna'));
    }

    public function indexUser(){  
        $poin = Poin::where('id_user', Auth::user()->id_user)->where('status', 'aktif')->orderBy('tgl_tenggat', 'asc')->get();
        $user = User::find(Auth::user()->id_user);
        //$transaksi = Transaksi::orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->where('id_user', Auth::user()->id_user)->get();
        return view('poin.index', compact('poin', 'user'));
    }

    public function poin(Request $request){  
        if($request->nama == "Semua"){
            return redirect('admin/poin');          
        }
        $user = User::find($request->nama);
        $pengguna = User::where("level", "pengguna")->get();
        $transaksi = Transaksi::orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->where('id_user', $request->nama)->get();
        $poin = Poin::where('id_user', $request->nama)->where('status', 'aktif')->orderBy('id_poin', 'desc')->get();
        $sum = Poin::where('id_user', $request->nama)->where('status', 'aktif')->sum('jumlah');
        return view('poin.index', compact('poin', 'user', 'transaksi', 'pengguna', 'sum'));
    }
}
