<?php

namespace App\Console;

use App\Models\Currencies;
use App\Models\HistoryCurrencies;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $client = new Client();
            $currencies = json_decode($client->request('GET', 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5')->getBody(), JSON_OBJECT_AS_ARRAY);
            foreach ($currencies as $currency) {
                $currenciesModel = Currencies::where('currency', $currency['ccy'])->get()->first();
                if (!$currenciesModel) {
                    DB::table('currencies')->insert(['currency' => $currency['ccy'], 'buy' => $currency['buy'], 'sell' => $currency['sale']]);
                } else {
                    $currenciesModel->historyCurrencies()
                        ->create([
                            'buy' => $currenciesModel->buy,
                            'sell' => $currenciesModel->sell
                        ]);
                    $currenciesModel->update(['buy' => $currency['buy'], 'sell' => $currency['sale']]);
                }
            }
        });
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
