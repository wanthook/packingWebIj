<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
//use App\Providers\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        Schema::defaultStringLength(191);
        Response::macro('attachment', function ($content) {
            $headers = [
                'Content-type'        => 'text/txt',
                'Content-Disposition' => 'attachment; filename="'.Carbon::now()->toDateTimeString().'.txt"',
            ];

            return \Response::make($content, 200, $headers);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
