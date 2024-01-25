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
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Selamat datang kedalam loyalty program!. Kami senang sekali memiliki anda sebagai anggota dalam loyalty program. 
Sebagai anggota anda mendapatkan keuntungan berupa POIN yang akan anda dapatkan pada setiap kunjungan anda. Poin tersebut memiliki nilai rupiah yang dapat anda manfaatkan sebagai potongan harga pada transaksi berikutnya.
Anda dapat kunjungi website kami untuk melihat riwayat poin anda.
.$linkweb.

Terima kasih telah bergabung dan kami menantikan untuk melayani anda
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Cucian anda dengan nomor transaksi ".$no_transaksi." sedang kami proses. Estimasi waktu cucian anda akan selesai pada
".$tgl.".
Kami akan segera menginformasikan jika proses telah selesai!. Berikut nota atas kunjungan anda di Sinar Laundry ".$cabang."
".$file."

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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
      'message' => "Halo ".$nama."!

Cucian anda dengan nomor transaksi ".$no_transaksi." sedang kami proses. Estimasi waktu cucian anda akan selesai pada
".$tgl.".
Kami akan segera menginformasikan jika proses telah selesai!. Anda mendapatkan poin sebanyak ".$poin." yang dapat anda manfaatkan untuk potongan harga pada transaksi berikutnya dengan masa berlaku hingga 3 bulan. Berikut nota atas kunjungan anda di Sinar Laundry ".$cabang."
".$file."

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Halo ".$nama."!

Cucian anda dengan nomor transaksi ".$no_transaksi." telah selesai kami proses dan sudah siap untuk diambil. 
Anda dapat ambil di Sinar Laundry ".$cabang." pada pukul
jam...
Jangan sampai terlewat yaa!.

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Halo ".$nama."!

Cucian anda dengan nomor transaksi ".$no_transaksi." dalam 7 hari lagi akan mencapai batas pengambilan pada
".$tgl.".
Jika pengambilan melebihi tanggal tersebut, maka kami tidak akan bertanggung jawab atas apapun yang terjadi pada cucian anda.
Anda dapat ambil di Sinar Laundry ".$cabang." pada pukul
jam...
Jangan sampai terlewat yaa!.

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Halo ".$nama."!

Cucian anda dengan nomor transaksi ".$no_transaksi." telah mencapai batas pengambilan pada
".$tgl.".
Kami tidak akan bertanggung jawab atas apapun yang terjadi pada cucian anda.
Anda dapat mengambil di Sinar Laundry ".$cabang." pada pukul
jam...

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
        ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Terima kasih telah memilih Sinar Laundry. Kami harap anda puas dengan layanan kami.
Anda berkesempatan untuk bergabung menjadi ANGGOTA dalam loyalty program kami. Anda akan mendapatkan POIN setiap kali menggunakan layanan kami. Anda dapat ajukan menjadi anggota pada halaman dashboard anda pada website kami di 
.$linkweb.
Kumpulkan poin sebanyak-banyaknya dan dapatkan potongan harga pada transaksi berikutnya.

Kami menantikan untuk melayani anda kembali. Jangan lupa untuk mengunjungi website kami untuk melihat data diri dan riwayat transaksi anda!.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Anda memiliki poin yang dapat anda gunakan sebanyak ".$poinTotal.". Kami ingin menginformasikan bahwa dalam 2 minggu poin anda sebanyak ".$poinTenggat." akan segera melewati masa tenggat pada
".$tgl.".
Jangan lewatkan kesempatan anda menggunakan poin tersebut untuk potongan harga pada transaksi berikutnya. Kami ingin memastikan anda dapat menikmati layanan yang kami berikan.

Kami menantikan untuk melayani anda.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Kami ingin menginformasikan bahwa poin anda sebanyak ".$poinTenggat." telah melewati masa tenggat pada hari ini
".$tgl.".
Jangan biarkan poin anda hilang begitu saja. Anda dapat gunakan poin sebagai potongan harga pada transaksi anda. Kami ingin memastikan anda dapat menikmati layanan yang kami berikan.

Kami menantikan untuk melayani anda.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Sudah beberapa waktu berlalu sejak terakhir kali kami melihat anda mengunjungi kami. Kami memahami bahwa hidup telah semakin sibuk dan kami ingin membuat kunjungan anda berikutnya dapat menjadi spesial dan nikmati keuntungan yang akan anda dapatkan menjadi anggota loyalty program kami. 

Kami menantikan untuk melayani anda.
Sinar Laundry",
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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

Cucian anda dengan nomor transaksi ".$no_transaksi." yang seharusnya dapat diambil pada ".$selesaiLama -> translatedFormat('l, d F Y')." tidak dapat terselesaikan tepat waktu karena satu dan lain hal. Estimasi waktu cucian anda akan selesai pada
".$tglBaru.".
Kami akan segera menginformasikan jika proses telah selesai!. Mohon maaf atas ketidaknyamanannya.

Terima kasih telah menggunakan layanan kami
Sinar Laundry ".$cabang,
      ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz'
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
          'Authorization: Jv-ZUx0YHVq#NEu5AJPz' 
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      echo $response;
    }

}
