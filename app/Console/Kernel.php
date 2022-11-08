<?php

namespace App\Console;

use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\KartuKeluarga;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Hash;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('queue:work --stop-when-empty')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->call(function () {
            $this->cekRemaja();
            $this->validationKeluarga();
        })->twiceDaily(0, 12);;
    }

    private function cekRemaja()
    {
        $remaja = AnggotaKeluarga::with('user')->where('status_hubungan_dalam_keluarga_id', 4)
            ->where('tanggal_lahir', '<=', Carbon::now()->subYears(10))
            ->where('tanggal_lahir', '>=', Carbon::now()->subYears(19))
            ->whereDoesntHave('user')
            ->get();

        foreach ($remaja as $r) {
            $user = User::create([
                'nik' => $r->nik,
                'password' => Hash::make('password'),
                'role' => 'keluarga',
                'is_remaja' => 1,
                'status' => 1,
            ]);

            $r->update([
                'user_id' => $user->id,
            ]);
        }
    }

    private function validationKeluarga()
    {
        $kartuKeluarga = KartuKeluarga::where('is_valid', 0)->get();

        foreach ($kartuKeluarga as $row) {
            $desa_kelurahan_domisili = $row->kepalaKeluarga->wilayahDomisili->desa_kelurahan_id;
            $bidan = Bidan::with('lokasiTugas')->whereHas('lokasiTugas', function ($q) use ($desa_kelurahan_domisili) {
                $q->where('desa_kelurahan_id', $desa_kelurahan_domisili);
            })->inRandomOrder()->first()->id;
            $row->update(['bidan_id' => $bidan, 'is_valid' => 1, 'tanggal_validasi' => Carbon::now()]);
            $row->kepalaKeluarga->update(['bidan_id' => $bidan, 'is_valid' => 1, 'tanggal_validasi' => Carbon::now()]);
        }

        $anggotaKeluarga = AnggotaKeluarga::where('is_valid', 0)->get();
        foreach ($anggotaKeluarga as $row) {
            $desa_kelurahan_domisili = $row->wilayahDomisili->desa_kelurahan_id;
            $bidan = Bidan::with('lokasiTugas')->whereHas('lokasiTugas', function ($q) use ($desa_kelurahan_domisili) {
                $q->where('desa_kelurahan_id', $desa_kelurahan_domisili);
            })->inRandomOrder()->first()->id;
            $row->update(['bidan_id' => $bidan, 'is_valid' => 1, 'tanggal_validasi' => Carbon::now()]);

            $remaja = AnggotaKeluarga::with('user')->where('status_hubungan_dalam_keluarga_id', 4)
                ->where('tanggal_lahir', '<=', Carbon::now()->subYears(10))
                ->where('tanggal_lahir', '>=', Carbon::now()->subYears(19))
                ->where('id', $row->id)
                ->whereDoesntHave('user')
                ->first();

            if ($remaja) {
                $user = User::create([
                    'nik' => $remaja->nik,
                    'password' => Hash::make('password'),
                    'role' => 'keluarga',
                    'is_remaja' => 1,
                    'status' => 1,
                ]);

                $remaja->user_id = $user->id;
                $remaja->save();
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
