<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use App\Models\Poin;
use App\Models\Cabang;
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
          'Authorization: M@xN@_FMvK9qSdTShMhi'
      ),
      ));
      $response = curl_exec($curl);
      curl_close($curl); 
      return json_decode($response);
    }

    public function anggota($id){
      $user = User::where('id_user',$id);
      $target = $user->first()->no_telp;
      $nama = $user->first()->nama;
      $linkweb = 'link web';

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
Selamat datang kedalam loyalty program!.
Sebagai anggota Anda mendapatkan keuntungan berupa *POIN* yang akan Anda dapatkan pada setiap kunjungan Anda. Poin tersebut memiliki nilai rupiah yang dapat Anda manfaatkan sebagai potongan harga pada transaksi berikutnya.
Anda dapat kunjungi website kami untuk melihat riwayat poin Anda di
*.$linkweb.*

Terima kasih telah bergabung dan kami menantikan untuk melayani Anda
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      echo $response;
    }

    public function transaksi($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $no_transaksi = $transaksi->first()->no_transaksi;
        $tgl = $transaksi->first()->tgl_selesai -> translatedFormat('l, d F Y');
        $id_user = $transaksi->first()->id_user;
        $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
        $user = User::where('id_user',$id_user);
        $target = $user->first()->no_telp;
        $nama = $user->first()->nama;
        $file = url('transaksiNota/'.$id);

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
Cucian Anda dengan nomor transaksi *.$no_transaksi.* sedang kami proses. Estimasi waktu cucian Anda akan selesai pada *.$tgl.*.
Kami akan segera menginformasikan jika proses telah selesai!. Berikut nota atas kunjungan Anda di Sinar Laundry .$cabang.
*.$file.*

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: M@xN@_FMvK9qSdTShMhi'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    public function transaksiAnggota($id){
      $transaksi = Transaksi::where('id_transaksi',$id);
      $no_transaksi = $transaksi->first()->no_transaksi;
      $tgl = $transaksi->first()->tgl_selesai -> translatedFormat('l, d F Y');
      $id_user = $transaksi->first()->id_user;
      $poin = $transaksi->first()->poin_masuk;
      $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
      $user = User::where('id_user',$id_user);
      $target = $user->first()->no_telp;
      $nama = $user->first()->nama;
      $file = url('transaksiNota/'.$id);

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
      'message' => "Halo .$nama.!
Cucian Anda dengan nomor transaksi *.$no_transaksi.* sedang kami proses. Estimasi waktu cucian Anda akan selesai pada *.$tgl.*.
Kami akan segera menginformasikan jika proses telah selesai!. Anda mendapatkan poin sebanyak *.$poin.* yang dapat Anda manfaatkan untuk potongan harga pada transaksi berikutnya dengan masa berlaku hingga *3 bulan*. Berikut nota atas kunjungan Anda di Sinar Laundry .$cabang.
.$file.

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      echo $response;
    }

    public function prosesSelesai($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $no_transaksi = $transaksi->first()->no_transaksi;
        $id_user = $transaksi->first()->id_user;
        $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
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
        'message' => "[PROSES LAUNDRY SELESAI]

Halo .$nama.!
Cucian Anda dengan nomor transaksi *.$no_transaksi.* telah *SELESAI* kami proses dan sudah siap untuk diambil. Anda dapat ambil di Sinar Laundry .$cabang. pada pukul
jam...
Jangan sampai terlewat yaa!.

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: M@xN@_FMvK9qSdTShMhi'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    public function hampirBatas($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $no_transaksi = $transaksi->first()->no_transaksi;
        $tgl = $transaksi->first()->tgl_tenggat -> translatedFormat('l, d F Y');
        $id_user = $transaksi->first()->id_user;
        $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
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

Halo .$nama.!
Cucian Anda dengan nomor transaksi *.$no_transaksi.* dalam *7 HARI* lagi akan mencapai batas pengambilan pada *.$tgl.*.
Jika pengambilan melebihi tanggal tersebut, maka kami *TIDAK* akan bertanggung jawab atas apapun yang terjadi pada cucian Anda. Anda dapat ambil di Sinar Laundry .$cabang. pada pukul
jam...
Jangan sampai terlewat yaa!.

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: M@xN@_FMvK9qSdTShMhi'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    public function lebihBatas($id){
        $transaksi = Transaksi::where('id_transaksi',$id);
        $no_transaksi = $transaksi->first()->no_transaksi;
        $tgl = $transaksi->first()->tgl_tenggat -> translatedFormat('l, d F Y');
        $id_user = $transaksi->first()->id_user;
        $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
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

Halo .$nama.!
Cucian Anda dengan nomor transaksi *.$no_transaksi.* telah mencapai batas pengambilan pada *.$tgl.*.
Kami *TIDAK* akan bertanggung jawab atas apapun yang terjadi pada cucian Anda. Anda dapat mengambil di Sinar Laundry .$cabang. pada pukul
jam...

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: M@xN@_FMvK9qSdTShMhi'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
    }

    public function ambilUser($id){
      $transaksi = Transaksi::where('id_transaksi',$id);
      $no_transaksi = $transaksi->first()->no_transaksi;
      $id_user = $transaksi->first()->id_user;
      $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
      $user = User::where('id_user',$id_user);
      $target = $user->first()->no_telp;
      $nama = $user->first()->nama;
      $linkweb = 'link web';

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
Terima kasih telah memilih Sinar Laundry. Kami harap Anda puas dengan layanan kami.
Anda berkesempatan untuk bergabung menjadi *ANGGOTA* dalam loyalty program kami. Anda akan mendapatkan *POIN* setiap kali menggunakan layanan kami. Anda dapat ajukan menjadi anggota pada halaman profil Anda pada website kami di 
*.$linkweb.*
Kumpulkan poin sebanyak-banyaknya dan dapatkan potongan harga pada transaksi berikutnya.

Kami ingin mendengar tanggapan Anda mengenai sistem informasi Sinar Laundry melalui tautan berikut:
*https://forms.gle/nD8aJPne4o26Z6in6*
Kami menghargai pendapat Anda.

Kami menantikan untuk melayani Anda kembali. Jangan lupa untuk mengunjungi website kami untuk melihat data diri dan riwayat transaksi Anda!.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      echo $response;
    }

    public function ambilAnggota($id){
      $transaksi = Transaksi::where('id_transaksi',$id);
      $no_transaksi = $transaksi->first()->no_transaksi;
      $id_user = $transaksi->first()->id_user;
      $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
      $user = User::where('id_user',$id_user);
      $target = $user->first()->no_telp;
      $nama = $user->first()->nama;
      $linkweb = 'link web';

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

Terima kasih telah memilih Sinar Laundry. Kami harap Anda puas dengan layanan kami.

Kami ingin mendengar tanggapan Anda mengenai sistem informasi Sinar Laundry melalui tautan berikut:
*https://forms.gle/nD8aJPne4o26Z6in6*
Kami menghargai pendapat Anda.

Kami menantikan untuk melayani Anda kembali. Jangan lupa untuk mengunjungi website kami untuk melihat data diri dan riwayat transaksi Anda!.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      echo $response;
    }

    public function poinReminder($id){
      $poin = Poin::where('id_poin',$id);
      $id_user = $poin->first()->id_user;
      $user = User::where('id_user',$id_user);
      $target = $user->first()->no_telp;
      $nama = $user->first()->nama;
      $poinTotal = Poin::where('id_user',$id_user)->where('status', 'aktif')->sum('jumlah');
      $poinTenggat = $poin->first()->jumlah;
      $tgl = $poin->first()->tgl_tenggat-> translatedFormat('l, d F Y');

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

Anda memiliki poin yang dapat Anda gunakan sebanyak *".$poinTotal."*. Kami ingin menginformasikan bahwa dalam 2 minggu poin Anda sebanyak *".$poinTenggat."* akan segera melewati masa tenggat pada *".$tgl."*.
Jangan lewatkan kesempatan Anda menggunakan poin tersebut untuk potongan harga pada transaksi berikutnya. Kami ingin memastikan Anda dapat menikmati layanan yang kami berikan.

Kami menantikan untuk melayani Anda.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      echo $response;
    }    
    
    public function poinExpire($id){
      $poin = Poin::where('id_poin',$id);
      $id_user = $poin->first()->id_user;
      $user = User::where('id_user',$id_user);
      $target = $user->first()->no_telp;
      $nama = $user->first()->nama;
      $poinTotal = Poin::where('id_user',$id_user)->where('status', 'aktif')->sum('jumlah');
      $poinTenggat = $poin->first()->jumlah;
      $tgl = $poin->first()->tgl_tenggat-> translatedFormat('l, d F Y');

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

Kami ingin menginformasikan bahwa poin Anda sebanyak *".$poinTenggat."* telah melewati masa tenggat pada hari ini *".$tgl."*.
Jangan biarkan poin Anda hilang begitu saja. Anda dapat gunakan poin sebagai potongan harga pada transaksi Anda. Kami ingin memastikan Anda dapat menikmati layanan yang kami berikan.

Kami menantikan untuk melayani Anda.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      echo $response;
    }

    public function kunjunganReminder($id){
      $transaksi = Transaksi::where('id_transaksi',$id);
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
      'message' => "Halo ".$nama."!

Sudah beberapa waktu berlalu sejak terakhir kali kami melihat Anda mengunjungi kami. Kami memahami bahwa hidup telah semakin sibuk dan kami ingin membuat kunjungan Anda berikutnya dapat menjadi spesial dan nikmati keuntungan yang akan Anda dapatkan menjadi anggota loyalty program kami. 

Kami menantikan untuk melayani Anda.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      echo $response;
    }

    public function tanggal($id, $selesaiLama){
      $transaksi = Transaksi::where('id_transaksi',$id);
      $no_transaksi = $transaksi->first()->no_transaksi;
      $tglBaru = $transaksi->first()->tgl_selesai -> translatedFormat('l, d F Y');
      $id_user = $transaksi->first()->id_user;
      $cabang = Cabang::where('id_cabang', $transaksi->first()->id_cabang)->first()->nama;
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
      'message' => "Halo ".$nama."!

Cucian Anda dengan nomor transaksi *".$no_transaksi."* yang seharusnya dapat diambil pada *".$selesaiLama -> translatedFormat('l, d F Y')."* tidak dapat terselesaikan tepat waktu karena satu dan lain hal. Estimasi waktu cucian Anda akan selesai pada *".$tglBaru."*.
Kami akan segera menginformasikan jika proses telah selesai!. Mohon maaf atas ketidaknyamanannya.

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      echo $response;
    }

    public function broadcast($id, $pesan){
      $user = User::where('id_user',$id);
      $target = $user->first()->no_telp;
      $nama = $user->first()->nama;
      //dd($pesan);

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
".$pesan,
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: M@xN@_FMvK9qSdTShMhi' 
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      echo $response;
    }

}
