<?php

use Illuminate\Support\Facades\Route;
use Techouse\IntlDateTime\IntlDateTimeController;

/*
|--------------------------------------------------------------------------
| Field API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/js/validation_locales/{locale}.js', IntlDateTimeController::class . '@validationLocale')
     ->name('intl_date_time_validation_locales');