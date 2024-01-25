<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Penyimpanan;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Auth;

class PenyimpananController extends Controller
{
    public function index(){  
        $title = 'Yakin Hapus Barang?';
        confirmDelete($title);

        $branch = 'Semua';
        $cabang = Cabang::all();
        if(Auth::user()->level == "pemilik"){
            $penyimpanan = Penyimpanan::orderBy('created_at', 'desc')->get();
        }else{
            $penyimpanan = Penyimpanan::orderBy('created_at', 'desc')->where('id_cabang', Auth::user()->id_cabang)->get();
        }
        return view('penyimpanan.index', compact('penyimpanan', 'branch', 'cabang'));
    }

    public function cabang(Request $request){  
        $title = 'Yakin Hapus Barang?';
        confirmDelete($title);
        if($request->cabang == "semua"){
            return redirect('admin/penyimpanan');          
        }
        $branch = Cabang::where('id_cabang', $request->cabang)->first()->nama;
        $cabang = Cabang::all();
        $penyimpanan = Penyimpanan::where('id_cabang', $request->cabang)->orderBy('created_at', 'desc')->get();
        return view('penyimpanan.index', compact('penyimpanan', 'branch', 'cabang'));
    }

    public function create(){  
        $cabang = Cabang::all();
        return view('penyimpanan.create', compact('cabang'));
    }

    public function store(Request $request){

        if(Auth::user()->level == "pemilik"){
            Session::flash('cabang', $request->cabang);
            $request->validate([
                'cabang'=>'required',
            ], [
                'cabang.required' => 'cabang wajib diisi',
            ]);
        }
        Session::flash('nama', $request->nama);
        Session::flash('merek', $request->merek);
        Session::flash('jumlah', $request->jumlah);
        Session::flash('harga', $request->harga);

        $request->validate([
            'nama'=>'required',
            'merek'=>'required',
            'jumlah'=>'required',
            'harga'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'merek.required' => 'merek wajib diisi',
            'jumlah.required' => 'jumlah wajib diisi',
            'harga.required' => 'harga wajib diisi',
        ]);

        if(Auth::user()->level == "pemilik"){
            $id_cabang = $request->cabang;
        }else{
            $id_cabang = Auth::user()->id_cabang;
        }
        $penyimpanan = new Penyimpanan([
            'id_cabang' => $id_cabang,
            'nama' => $request->nama,
            'merek' => $request->merek,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
        ]);
        $penyimpanan->save();
        return redirect('admin/penyimpanan')->with('success', 'Tambah Penyimpanan Sukses');
    }

    public function edit($id){  
        $penyimpanan = Penyimpanan::findorfail($id);
        $cabang = Cabang::all();
        return view('penyimpanan.edit', compact('penyimpanan', 'cabang'));
    }

    public function update(Request $request, $id){  
        $penyimpanan = Penyimpanan::findorfail($id);

        if(Auth::user()->level == "pemilik"){
            $request->validate([
                'cabang'=>'required',
            ], [
                'cabang.required' => 'cabang wajib diisi',
            ]);
        }

        $request->validate([
            'nama'=>'required',
            'merek'=>'required',
            'jumlah'=>'required',
            'harga'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'merek.required' => 'merek wajib diisi',
            'jumlah.required' => 'jumlah wajib diisi',
            'harga.required' => 'harga wajib diisi',
        ]);

        if(Auth::user()->level == "pemilik"){
            $id_cabang = $request->cabang;
        }else{
            $id_cabang = Auth::user()->id_cabang;
        }
        $penyimpanan->update($request->all());
        $penyimpanan->update([ 'id_cabang' =>$id_cabang]);
        return redirect('admin/penyimpanan')->with('success', 'Edit Penyimpanan Sukses');
    }

    public function delete($id){  
        Penyimpanan::find($id)->delete();
        return redirect('admin/penyimpanan')->with('success', 'Hapus Penyimpanan Sukses');
    }
}
