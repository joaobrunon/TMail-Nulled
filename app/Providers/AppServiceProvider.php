<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use App\Option;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(file_exists(storage_path('installed'))) {
            if(Schema::hasTable('options')) {
                $options = Option::get();
                foreach($options as $option) {
                    View::share($option->key, $option->value);
                }
            } else {
                $options = array("AD_SPACE_1", "AD_SPACE_2", "AD_SPACE_3", "CUSTOM_HEADER", "CUSTOM_CSS", "CUSTOM_JS");
                foreach($options as $option) {
                    View::share($option, "");
                }
            }
        } else {
            $options = array("AD_SPACE_1", "AD_SPACE_2", "AD_SPACE_3", "CUSTOM_HEADER", "CUSTOM_CSS", "CUSTOM_JS");
            foreach($options as $option) {
                View::share($option, "");
            }
        }
    }
}
