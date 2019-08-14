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
     * @var string
     */
    protected $errorLocale = 'en';

    /**
     * @var array
     */
    private static $momentjsSupportedLocales = [
        'ar',
        'az',
        'be',
        'bg',
        'bn',
        'bs',
        'ca',
        'cs',
        'cy',
        'da',
        'de',
        'de-at',
        'de-ch',
        'el',
        'en',
        'en-au',
        'en-ca',
        'en-gb',
        'en-ie',
        'en-nz',
        'eo',
        'es',
        'es-do',
        'es-us',
        'et',
        'fa',
        'fi',
        'fo',
        'fr',
        'fr-ca',
        'fr-ch',
        'ga',
        'he',
        'hi',
        'hr',
        'hu',
        'id',
        'is',
        'it',
        'ja',
        'ka',
        'kk',
        'km',
        'ko',
        'lt',
        'lv',
        'mk',
        'mn',
        'ms',
        'my',
        'nb',
        'nl',
        'pa-in',
        'pl',
        'pt',
        'pt-br',
        'ro',
        'ru',
        'si',
        'sk',
        'sl',
        'sq',
        'sr',
        'sr-cyrl',
        'sv',
        'th',
        'tr',
        'uk',
        'vi',
        'zh-cn',
        'zh-hk',
        'zh-tw',
    ];

    private static $errorSupportedLocales = [
        'ar',
        'az',
        'bg',
        'ca',
        'cs',
        'da',
        'de',
        'el',
        'en',
        'es',
        'et',
        'eu',
        'fa',
        'fi',
        'fr',
        'he',
        'hi',
        'hr',
        'hu',
        'id',
        'it',
        'ja',
        'ka',
        'ko',
        'lt',
        'lv',
        'mn',
        'ms_MY',
        'nb_NO',
        'ne',
        'nl',
        'nn_NO',
        'pl',
        'pt_BR',
        'pt_PT',
        'ro',
        'ru',
        'sk',
        'sl',
        'sq',
        'sr',
        'sr_Latin',
        'sv',
        'th',
        'tr',
        'uk',
        'vi',
        'zh_CN',
        'zh_TW',
    ];

    private static $translatedMomentJSLocalesToErrorLocales = [
        'ar'      => 'ar',
        'az'      => 'az',
        'be'      => null,
        'bg'      => 'bg',
        'bn'      => null,
        'bs'      => 'sr_Latin', // manually set to Serbian Latin
        'ca'      => 'ca',
        'cs'      => 'cs',
        'cy'      => null,
        'da'      => 'da',
        'de'      => 'de',
        'de-at'   => 'de',
        'de-ch'   => 'de',
        'el'      => 'el',
        'en'      => 'en',
        'en-au'   => 'en',
        'en-ca'   => 'en',
        'en-gb'   => 'en',
        'en-ie'   => 'en',
        'en-nz'   => 'en',
        'eo'      => null,
        'es'      => 'es',
        'es-do'   => 'es',
        'es-us'   => 'es',
        'et'      => 'et',
        'fa'      => 'fa',
        'fo'      => null,
        'fi'      => 'fi',
        'fr'      => 'fr',
        'ga'      => null,
        'fr-ca'   => 'fr',
        'fr-ch'   => 'fr',
        'he'      => 'he',
        'hi'      => 'hi',
        'hr'      => 'hr',
        'hu'      => 'hu',
        'id'      => 'id',
        'is'      => null,
        'it'      => 'it',
        'ja'      => 'ja',
        'ka'      => 'ka',
        'kk'      => null,
        'km'      => 'km',
        'ko'      => 'ko',
        'lt'      => 'lt',
        'lv'      => 'lv',
        'mk'      => null,
        'mn'      => 'mn',
        'ms'      => 'ms_MY',
        'my'      => null,
        'nb'      => 'nb_NO',
        'nl'      => 'nl',
        'pa-in'   => null,
        'pl'      => 'pl',
        'pt'      => 'pt_PT',
        'pt-br'   => 'pt_BR',
        'ro'      => 'ro',
        'ru'      => 'ru',
        'si'      => 'si',
        'sk'      => 'sk',
        'sl'      => 'sl',
        'sq'      => 'sq',
        'sr'      => 'sr_Latin',
        'sr-cyrl' => 'sr',
        'sv'      => 'sv',
        'th'      => 'th',
        'tr'      => 'tr',
        'uk'      => 'uk',
        'vi'      => 'vi',
        'zh-cn'   => 'zh_CN',
        'zh-hk'   => 'zh_CN',
        'zh-tw'   => 'zh_TW',
    ];

    /**
     * Create a new field.
     *
     * @param string      $name
     * @param string|null $attribute
     * @param mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $locale = strtolower(trim(config('app.locale')));
        if (in_array($locale, self::$momentjsSupportedLocales, true)) {
            $this->locale = $locale;
            if (array_key_exists($locale, self::$translatedMomentJSLocalesToErrorLocales) && self::$translatedMomentJSLocalesToErrorLocales[$locale]) {
                $this->errorLocale = self::$translatedMomentJSLocalesToErrorLocales[$locale];
            }
        }

        $this->withMeta(['locale'             => $this->locale,
                         'errorMessageLocale' => $this->errorLocale]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param string                                  $requestAttribute
     * @param object                                  $model
     * @param string                                  $attribute
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
     * @param $value
     * @return mixed
     */
    public function dateFormat($value)
    {
        if ($value) {
            return $this->withMeta([__FUNCTION__ => $value]);
        }
    }

    /**
     * @param $value
     * @return mixed
     * @throws \Techouse\IntlDateTime\TimeFormatNotSupportedException
     */
    public function timeFormat($value)
    {
        if ($value) {
            if (preg_match('/^[Hh]{1,2}:[m]{1,2}(:[s]{1,2})?$/', $value)) {
                return $this->withMeta([__FUNCTION__ => $value]);
            }

            throw new TimeFormatNotSupportedException("Time format {$value} is not supported by MomentJS! Please refer to the module documentation.");
        }
    }

    /**
     * @param \DateTime|null $value
     * @return mixed
     */
    public function minDate(?\DateTime $value = null)
    {
        return $this->withMeta([__FUNCTION__ => $value ? $value->format('Y-m-d') : null]);
    }

    /**
     * @param \DateTime|null $value
     * @return mixed
     */
    public function maxDate(?\DateTime $value = null)
    {
        return $this->withMeta([__FUNCTION__ => $value ? $value->format('Y-m-d') : null]);
    }

    /**
     * @param $placeholder
     * @return mixed
     */
    public function placeholder($value = null)
    {
        return $this->withMeta([__FUNCTION__ => $value]);
    }

    /**
     * @param $value
     * @return mixed
     * @throws \Techouse\IntlDateTime\LocaleNotSupportedException
     */
    public function locale($value)
    {
        if ($value) {
            $value = strtolower(trim($value));

            if (!in_array($value, self::$momentjsSupportedLocales, true)) {
                throw new LocaleNotSupportedException("Locale {$value} is not supported by MomentJS. Please consult the module documentation.");
            } else {
                $this->locale = $value;
            }

            if (array_key_exists($value, self::$translatedMomentJSLocalesToErrorLocales) && self::$translatedMomentJSLocalesToErrorLocales[$value]) {
                $this->errorLocale = self::$translatedMomentJSLocalesToErrorLocales[$value];
            }

            if ($this->locale === 'en') {
                $this->locale = 'en-gb';
            }

            return $this->withMeta([__FUNCTION__         => $this->locale,
                                    'errorMessageLocale' => $this->errorLocale]);
        }
    }

    /**
     * @param $value
     * @return mixed
     */
    public function errorMessage($value)
    {
        if ($value) {
            return $this->withMeta([__FUNCTION__ => $value]);
        }
    }

    /**
     * Has to be one of these https://github.com/baianat/vee-validate/tree/master/locale
     *
     * @param $value
     * @return mixed
     * @throws \Techouse\IntlDateTime\LocaleNotSupportedException
     */
    public function errorMessageLocale($value)
    {
        if ($value) {
            if (!in_array($value, self::$errorSupportedLocales, true)) {
                throw new LocaleNotSupportedException("Locale {$value} is not supported by VeeValidate. Please consult the module documentation.");
            } else {
                $this->errorLocale = $value;
            }

            return $this->withMeta([__FUNCTION__ => $this->errorLocale]);
        }
    }
}
