<?php

namespace Kumarrahul\salaryslipuploader;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Controller;
    
class SalarySlipProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'salaryslipuploader');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/kumarrahul/salaryslipuploader'),
        ], 'salaryslipuploader');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       
    }
}