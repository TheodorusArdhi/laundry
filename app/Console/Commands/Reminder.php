<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Http\Controllers\WAController;
use App\Models\Poin;
use App\Models\Transaksi;
use App\Models\User;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:customerReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pengingat konsumen';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::parse(now()->format('Y-m-d'));

        $poin = Poin::where('status', 'aktif')->get();
        foreach ($poin as $value){
            $tgl_tenggat = Carbon::parse($value->tgl_tenggat)->subDays(14);
            $hari = $currentDate->diffInDays($tgl_tenggat, false);
            $notifikasi = User::where('id_user', $value->id_user)->first()->notifikasi;
            if($hari <= 0 && $notifikasi == "on"){
                $WA = new WAController;
                $WA->poinReminder($value->id_poin);
            }
        }

        $kunjungan = Transaksi::where('id_status_transaksi', 7)->get();
        foreach ($kunjungan as $value){
            $tgl_masuk = Carbon::parse($value->tgl_masuk)->addDays(30);
            $hari = $currentDate->diffInDays($tgl_masuk, false);
            $notifikasi = User::where('id_user', $value->id_user)->first()->notifikasi;
            if($hari <= 0 && $hari >= -7 && $notifikasi == "on"){
                $WA = new WAController;
                $WA->kunjunganReminder($value->id_transaksi);
            }
        }
    }
}
