<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//* importare la paginazione per poter visualizzare 10 elementi per ongi pagina
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      //* importo bootstrap per la paginazione che verrà utilizzata in index.blade.php
      Paginator::useBootstrap();
    }
}
