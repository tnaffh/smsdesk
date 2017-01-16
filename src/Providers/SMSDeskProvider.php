<?php

namespace Tnaffh\SMSDesk\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class EbayAPIProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/smsdesk.php' => config_path('smsdesk.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('smsdesk', function () {
            $client = new Client([
                'base_uri' => 'https://api.sandbox.ebay.com/',
                'headers' => [
                    'X-EBAY-SOA-SERVICE-NAME' => 'FindingService',
                    'X-EBAY-SOA-OPERATION-NAME' => 'findItemsAdvanced',
                    'X-EBAY-SOA-SERVICE-VERSION' => '1.0.0',
                    'X-EBAY-SOA-GLOBAL-ID' => 'EBAY-US',
                    'X-EBAY-SOA-SECURITY-APPNAME' => 'MyAppID',
                    'X-EBAY-SOA-REQUEST-DATA-FORMAT' => 'JSON',
                    'X-EBAY-SOA-MESSAGE-PROTOCOL' => 'SOAP12',
                ]
            ]);
            return new Ebay($client);
        });
    }
}
