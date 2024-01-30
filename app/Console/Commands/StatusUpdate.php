<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\WAController;

class StatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:statusUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Status Update Everyday';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::parse(now()->format('Y-m-d'));

        $statusProses = Transaksi::where('id_status_transaksi', 3)->get();
        foreach ($statusProses as $value){
            $transaksiDate = Carbon::parse($value->tgl_selesai);
            $hari = $currentDate->diffInDays($transaksiDate, false);
            if($hari <= 0){
                Transaksi::where('id_transaksi', $value->id_transaksi)->update(['id_status_transaksi' => 4]);
                $notif = User::where('id_user', $value->id_user)->first()->notifikasi;
                if($notif == "on"){
                    $WA = new WAController;
                    $WA->prosesSelesai($value->id_transaksi);
                }
            }
            \Log::info($hari);
        }

        $statusProsesSelesai = Transaksi::where('id_status_transaksi', 4)->get();
        foreach ($statusProsesSelesai as $value){
            $date = Carbon::parse($value->tgl_selesai);
            $transaksiDate = Carbon::parse($date->addDays(14));
            $hari = $currentDate->diffInDays($transaksiDate, false);
            if($hari <= 0){
                Transaksi::where('id_transaksi', $value->id_transaksi)->update(['id_status_transaksi' => 5]);
                $notif = User::where('id_user', $value->id_user)->first()->notifikasi;
                if($notif == "on"){
                    $WA = new WAController;
                    $WA->hampirBatas($value->id_transaksi);
                }
            }
            \Log::info($hari);
        }

        $statusHampirBatas = Transaksi::where('id_status_transaksi', 5)->get();
        foreach ($statusHampirBatas as $value){
            $transaksiDate = Carbon::parse($value->tgl_tenggat);
            $hari = $currentDate->diffInDays($transaksiDate, false);
            if($hari <= 0){
                Transaksi::where('id_transaksi', $value->id_transaksi)->update(['id_status_transaksi' => 6]);
                $notif = User::where('id_user', $value->id_user)->first()->notifikasi;
                if($notif == "on"){
                    $WA = new WAController;
                    $WA->lebihBatas($value->id_transaksi);
                }
            }
            \Log::info($hari);
        }

        $poin = Poin::where('status', 'aktif')->get();
        foreach ($poin as $value){
            $tgl_tenggat = Carbon::parse($value->tgl_tenggat)->subDays(14);
            $hari = $currentDate->diffInDays($tgl_tenggat, false);
            $notif = User::where('id_user', $value->id_user)->first()->notifikasi;
            if($hari <= 0){
                if($notif == "on"){
                    $WA = new WAController;
                    $WA->poinReminder($value->id_poin);
                }
            }
        }
        
        $expire = Poin::where('status', 'aktif')->get();
        foreach ($expire as $value){
            $tgl_tenggat = Carbon::parse($value->tgl_tenggat);
            $hari = $currentDate->diffInDays($tgl_tenggat, false);
            $notif = User::where('id_user', $value->id_user)->first()->notifikasi;
            if($hari <= 0){
                Poin::where('id_poin', $value->id_poin)->update(['status' => 'tidak aktif']);
                if($notif == "on"){
                    $WA = new WAController;
                    $WA->poinExpire($value->id_poin);
                }
            }
        }
    }
}
