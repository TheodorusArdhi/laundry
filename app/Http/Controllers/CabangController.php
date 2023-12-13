<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class CabangController extends Controller
{
    public function index(){  
        $cabang = Cabang::all();
        $title = 'Yakin Hapus Cabang?';
        confirmDelete($title);
        return view('cabang.index', compact('cabang'));
    }

    public function create(){  
        return view('cabang.create');
    }

    public function store(Request $request){
        Session::flash('nama', $request->nama);
        Session::flash('alamat', $request->alamat);
        Session::flash('no_telp', $request->no_telp);

        $request->validate([
            'nama'=>'required',
            'alamat'=>'required',
            'no_telp'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'alamat.required' => 'alamat wajib diisi',
            'no_telp.required' => 'no_telp wajib diisi',
        ]);

        $no_telp = $request->no_telp;
        $valid = new WAController;
        $valid = $valid->telepon($no_telp);
        if ($valid->not_registered != null ){
            return redirect('admin/cabang/create')->with('error', 'Nomor tidak terdaftar pada Whatsapp');
        }

        if(substr(trim($no_telp), 0, 2)=="62"){
            $no_telp = "62".substr(trim($no_telp), 2);
        }
        elseif(substr(trim($no_telp), 0, 1)=="0"){
            $no_telp = "62".substr(trim($no_telp), 1);
        }

        $cabang = new Cabang([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' =>$no_telp,
        ]);
        $cabang->save();
        return redirect('admin/cabang')->with('success', 'Tambah Cabang Sukses');
    }

    public function edit($id){  
        $cabang = Cabang::findorfail($id);
        return view('cabang.edit', compact('cabang'));
    }

    public function update(Request $request, $id){  
        $cabang = Cabang::findorfail($id);
        //dd($request);
        $request->validate([
            'nama'=>'required',
            'alamat'=>'required',
            'no_telp'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'alamat.required' => 'alamat wajib diisi',
            'no_telp.required' => 'no_telp wajib diisi',
        ]);

        $no_telp = $request->no_telp;
        $valid = new WAController;
        $valid = $valid->telepon($no_telp);
        if ($valid->not_registered != null ){
            return redirect('admin/cabang/'.$id.'/edit')->with('error', 'Nomor tidak terdaftar pada Whatsapp');
        }

        if(substr(trim($no_telp), 0, 2)=="62"){
            $no_telp = "62".substr(trim($no_telp), 2);
        }
        elseif(substr(trim($no_telp), 0, 1)=="0"){
            $no_telp = "62".substr(trim($no_telp), 1);
        }

        $cabang->update($request->all());
        $cabang->update(['no_telp' => $no_telp]);
        return redirect('admin/cabang')->with('success', 'Edit Cabang Sukses');
    }

    public function delete( $id){  
        $cabang = Cabang::findorfail($id)->delete();
        return redirect('admin/cabang')->with('success', 'Hapus Cabang Sukses');
    }
}
