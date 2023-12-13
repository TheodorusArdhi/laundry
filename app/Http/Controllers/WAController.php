<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\File;
Use Illuminate\Support\Facades\Hash;

class WAController extends Controller
{
    function invoice($id){
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id)->get();
        $data = ['transaksi' => $transaksi,
         'transaksiDetail' => $transaksiDetail];
        //$pdf = Pdf::loadView('transaksi.invoice', $data);
        $noTransaksi = Transaksi::where('id_transaksi', $id)->first()->no_transaksi;
        return Pdf::loadView('transaksi.invoice', $data)->save('D:/Tugas/SEMESTER 8/TA/laundry/storage/invoice/'.$noTransaksi.'.pdf');
        // $content = $pdf->download()->getOriginalContent();
        // Storage::put('storage/invoice/'.$noTransaksi.'.pdf',$content);
        //dd($content);
    }

    public function telepon($target){
      $curl = curl_init();

      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/validate',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
      'target' => $target,
      'countryCode' => '62'
      ),
      CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
      ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      // dd($response);      
      // echo $response;  
      return json_decode($response);
  }

    public function transaksi($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $nota = $transaksi->first()->no_transaksi;
        $tgl = $transaksi->first()->tgl_selesai -> translatedFormat('l, d F Y');
        $id_user = $transaksi->first()->id_user;
        $user = User::where('id_user',$id_user);
        $target = $user->first()->no_telp;
        $nama = $user->first()->nama;
        //$pdf = $this->invoice($id);
        //$file = 'D:/Tugas/SEMESTER 8/TA/laundry/storage/invoice/'.$nota.'.pdf';
        //$file = "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf";
        //$hash = Hash::make($id);
        $file = url('transaksiNota/'.$id);
        //dd($file);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => "Halo ".$nama."!

Cucian kamu sedang kami proses. Estimasi waktu untuk cucian kamu akan selesai pada
".$tgl."
Kami akan segera memberi tahu jika proses telah selesai!.
Berikut nota atas kunjungan anda di Sinar Laundry dengan nomor transaksi ".$nota."

".$file."

Terima Kasih Telah Menggunakan Layanan Kami!

Sinar Laundry",
        // 'url' => $file,

        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        //dd($response);
        echo $response;
    }

    function prosesSelesai($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $nota = $transaksi->first()->no_transaksi;
        $id_user = $transaksi->first()->id_user;
        $user = User::where('id_user',$id_user);
        $target = $user->first()->no_telp;
        $nama = $user->first()->nama;

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => "[LAUNDRY SELESAI]
Halo ".$nama."!

Cucian kamu dengan nomor transaksi ".$nota." telah selesai kami proses dan sudah siap untuk diambil. Kamu bisa ambil pada jam buka toko kami
jam...
Jangan sampai terlewat yaa!.

Terima Kasih Telah Menggunakan Layanan Kami!

Sinar Laundry",
        // 'url' => $file,

        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        //dd($response);
        echo $response;
    }

    function hampirBatas($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $nota = $transaksi->first()->no_transaksi;
        $tgl = $transaksi->first()->tgl_tenggat -> translatedFormat('l, d F Y');
        $id_user = $transaksi->first()->id_user;
        $user = User::where('id_user',$id_user);
        $target = $user->first()->no_telp;
        $nama = $user->first()->nama;

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => "[PENGINGAT BATAS PENGAMBILAN LAUNDRY]
Halo ".$nama."!

Cucian kamu dengan nomor transaksi ".$nota." dalam 7 hari lagi akan mencapai batas pengambilan pada hari
".$tgl."
Jika pengambilan melebihi tanggal tersebut, maka kami tidak akan bertanggung jawab atas apapun yang terjadi pada cucian kamu.
Kamu bisa ambil pada jam buka toko kami
jam...
Jangan sampai terlewat yaa!.

Terima Kasih Telah Menggunakan Layanan Kami!

Sinar Laundry",
        // 'url' => $file,

        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        //dd($response);
        echo $response;
    }

    function lebihBatas($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $nota = $transaksi->first()->no_transaksi;
        $tgl = $transaksi->first()->tgl_tenggat -> translatedFormat('l, d F Y');
        $id_user = $transaksi->first()->id_user;
        $user = User::where('id_user',$id_user);
        $target = $user->first()->no_telp;
        $nama = $user->first()->nama;

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => "[PENGAMBILAN LAUNDRY MELEWATI BATAS]
Halo ".$nama."!

Cucian kamu dengan nomor transaksi ".$nota." telah mencapai batas pengambilan pada hari
".$tgl."
Kami tidak akan bertanggung jawab atas apapun yang terjadi pada cucian kamu.
Kamu masih bisa ambil pada jam buka toko kami
jam...

Terima Kasih Telah Menggunakan Layanan Kami!

Sinar Laundry",
        // 'url' => $file,

        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        //dd($response);
        echo $response;
    }

    // reminder sudah lama tidak berkunjung
    // reminder menggunakan poin "kamu memiliki $ poin, gunakan poin tersebut sebagai potongan harga pada kunjunganmu berikutnya"
    // broadcast promosi
    // kapan "kamu dapat melihat perolehan poin kamu pada website kami"
}