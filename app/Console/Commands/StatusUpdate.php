<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;

class StatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaksi:statusUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaksi Status Update';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = now()->format('Y-m-d');

        $statusProses = Transaksi::where('id_status_transaksi', 3)->get();
        foreach ($statusProses as $proses){
            $transaksiDate = Carbon::parse($proses->tgl_selesai);
            $day = $transaksiDate->diffInDays($currentDate);
            if($day == 0){
                Transaksi::where('id_transaksi', $proses->id_transaksi)->update(['id_status_transaksi' => 4]);
            }
            \Log::info($day);
        }

        $statusProsesSelesai = Transaksi::where('id_status_transaksi', 4)->get();
        foreach ($statusProsesSelesai as $prosesSelesai){
            $date = Carbon::createFromFormat('Y-m-d', $prosesSelesai->tgl_selesai);
            $transaksiDate = Carbon::parse($date->addDays(14));
            $day = $transaksiDate->diffInDays($currentDate);
            if($day == 0){
                Transaksi::where('id_transaksi', $prosesSelesai->id_transaksi)->update(['id_status_transaksi' => 5]);
            }
            \Log::info($day);
        }

        $statusHampirBatas = Transaksi::where('id_status_transaksi', 5)->get();
        foreach ($statusHampirBatas as $hampirBatas){
            $transaksiDate = Carbon::parse($hampirBatas->tgl_tenggat);
            $day = $transaksiDate->diffInDays($currentDate);
            if($day == 0){
                Transaksi::where('id_transaksi', $hampirBatas->id_transaksi)->update(['id_status_transaksi' => 6]);
            }
            \Log::info($day);
        }

    }
}
