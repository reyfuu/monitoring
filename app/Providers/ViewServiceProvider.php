<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\notifikasi;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('dmn', function ($view) {
            $domen_id= session('domen_id');
            $data2= notifikasi::where('domen_id',$domen_id)->get();
            $data= [
                'notifications'=>$data2,
            ];
            $view->with($data);
        });
    }
}
