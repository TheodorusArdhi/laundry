<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;
use App\Http\Controllers\WAController;

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
        $currentDate = Carbon::parse(now()->format('Y-m-d'));

        $statusProses = Transaksi::where('id_status_transaksi', 3)->get();
        foreach ($statusProses as $proses){
            $transaksiDate = Carbon::parse($proses->tgl_selesai);
            $day = $currentDate->diffInDays($transaksiDate, false);
            if($day <= 0){
                $transaksi = Transaksi::where('id_transaksi', $proses->id_transaksi)->update(['id_status_transaksi' => 4]);
                $WA = new WAController;
                $WA->prosesSelesai($proses->id_transaksi);
            }
            \Log::info($day);
        }

        $statusProsesSelesai = Transaksi::where('id_status_transaksi', 4)->get();
        foreach ($statusProsesSelesai as $prosesSelesai){
            $date = Carbon::parse($prosesSelesai->tgl_selesai);
            $transaksiDate = Carbon::parse($date->addDays(14));
            $day = $currentDate->diffInDays($transaksiDate, false);
            if($day <= 0){
                Transaksi::where('id_transaksi', $prosesSelesai->id_transaksi)->update(['id_status_transaksi' => 5]);
                $WA = new WAController;
                $WA->hampirBatas($prosesSelesai->id_transaksi);
            }
            \Log::info($day);
        }

        $statusHampirBatas = Transaksi::where('id_status_transaksi', 5)->get();
        foreach ($statusHampirBatas as $hampirBatas){
            $transaksiDate = Carbon::parse($hampirBatas->tgl_tenggat);
            $day = $currentDate->diffInDays($transaksiDate, false);
            if($day <= 0){
                Transaksi::where('id_transaksi', $hampirBatas->id_transaksi)->update(['id_status_transaksi' => 6]);
                $WA = new WAController;
                $WA->lebihBatas($hampirBatas->id_transaksi);
            }
            \Log::info($day);
        }

    }
}
