<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:setwebhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set telegram bot webhook';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $address = "https://api.telegram.org/bot{$botToken}/setWebhook?url=https://platotournament.ai1polaris.com/telegram/webhook&drop_pending_updates=True";
        $response = $client->request('POST', $address );
        $Response = json_decode($response->getBody(), true);
        if($Response['result'] == true){
            $this->info('Telegram webhook rebooted successfully');
        }else{
            $this->error('telegram bot doesnt rebooted , please try again later');
        }

    }
}
