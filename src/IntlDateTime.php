<?php

namespace Techouse\IntlDateTime;

use Carbon\Carbon;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

class IntlDateTime extends DateTime
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'intl-date-time';

    /**
     * @var string
     */
    protected $locale = 'en-gb';

    /**
     * @var array
     */
    private static $momentjsSupportedLocales = [
        'hr', 'th', 'tr', 'ar', 'be', 'bg', 'bn', 'ca', 'cs', 'cy', 'da', 'de', 'de-at', 'de-ch', 'en', 'en-ca',
        'en-au', 'en-gb', 'en-ie', 'en-nz', 'eo', 'es', 'es-do', 'es-us', 'et', 'fa', 'fi', 'fr', 'fr-ca', 'fr-ch',
        'el', 'he', 'hi', 'hu', 'id', 'it', 'ja', 'ko', 'km', 'kk', 'lt', 'lv', 'mk', 'ms', 'my', 'nl', 'nb', 'pa-in',
        'pl', 'pt', 'pt-br', 'ro', 'ru', 'si', 'sk', 'sl', 'sq', 'sr', 'sv', 'uk', 'vi', 'zh-cn', 'zh-hk', 'zh-tw',
    ];

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $appLocale = strtolower(trim(config('app.locale')));
        if (in_array($appLocale, self::$momentjsSupportedLocales, true)) {
            $this->locale = $appLocale;
        }

        $this->withMeta(['locale' => $this->locale]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param  string                                  $requestAttribute
     * @param  object                                  $model
     * @param  string                                  $attribute
     * @return void
     * @throws \Exception
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = $request[$requestAttribute] ? Carbon::parse($request[$requestAttribute]) : null;
        }
    }

    /**
     * @param $format
     * @return mixed
     */
    public function dateFormat($format)
    {
        if ($format) {
            return $this->withMeta([__FUNCTION__ => $format]);
        }
    }

    /**
     * @param $format
     * @return mixed
     * @throws \Techouse\IntlDateTime\TimeFormatNotSupportedException
     */
    public function timeFormat($format)
    {
        if ($format) {
            if (preg_match('/^[Hh]{1,2}:[m]{1,2}(:[s]{1,2})?$/', $format)) {
                return $this->withMeta([__FUNCTION__ => $format]);
            }

            throw new TimeFormatNotSupportedException("Time format {$format} is not supported by MomentJS! Please refer to the module documentation.");
        }
    }

    /**
     * @param $placeholder
     * @return mixed
     */
    public function placeholder($placeholder = null)
    {
        return $this->withMeta([__FUNCTION__ => $placeholder]);
    }

    /**
     * @param $locale
     * @return mixed
     * @throws \Techouse\IntlDateTime\LocaleNotSupportedException
     */
    public function locale($locale)
    {
        if ($locale) {
            $locale = strtolower(trim($locale));

            if (!in_array($locale, self::$momentjsSupportedLocales, true)) {
                throw new LocaleNotSupportedException("Locale {$locale} is not supported by MomentJS. Please consult the module documentation.");
            }

            if ($locale === 'en') {
                $locale = 'en-gb';
            }

            return $this->withMeta([__FUNCTION__ => $locale]);
        }
    }
}
