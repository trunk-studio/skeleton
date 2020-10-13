<?php

namespace NotificationChannels\AwsSns;

use Aws\Sns\SnsClient as SnsService;
use Illuminate\Support\ServiceProvider;

class SNSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(SNSChannel::class)
            ->needs(SNSClient::class)
            ->give(function () {
                return new Sns($this->app->make(SnsService::class));
            }
        );
        
        $this->app->bind(SnsService::class, function () {
            return new SnsService($this->app['config']['services.sns']);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(\Aws\Laravel\AwsServiceProvider::class);
    }
}
