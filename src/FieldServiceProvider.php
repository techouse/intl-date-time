<?php

namespace Techouse\IntlDateTime;

use DirectoryIterator;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('intl-date-time', __DIR__ . '/../dist/js/field.js');
            Nova::style('intl-date-time', __DIR__ . '/../dist/css/field.css');

            $validationLocales = new DirectoryIterator(__DIR__ . '/../dist/js/validation_locales/');
            foreach ($validationLocales as $fileInfo) {
                if (!$fileInfo->isDot() && !$fileInfo->isDir()) {
                    Nova::script('validation_locales_' . str_replace('.' . $fileInfo->getExtension(), '', $fileInfo->getFilename()),
                                 __DIR__ . '/../dist/js/validation_locales/' . $fileInfo->getFilename());
                }
            }
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
