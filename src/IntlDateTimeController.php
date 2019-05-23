<?php

namespace Techouse\IntlDateTime;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laravel\Nova\Http\Requests\NovaRequest;

class IntlDateTimeController extends Controller
{
    use ValidatesRequests;

    /**
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function validationLocale(NovaRequest $request, $locale)
    {
        if (file_exists(__DIR__ . "/../dist/js/validation_locales/{$locale}.js")) {
            return response(file_get_contents(__DIR__ . "/../dist/js/validation_locales/{$locale}.js"))
                ->header('Content-Type', 'application/javascript');
        }
        abort(404);
    }
}