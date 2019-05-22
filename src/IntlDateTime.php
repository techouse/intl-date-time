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
        'hr', 'th', 'tr', 'ar', 'be', 'bg', 'bn', 'ca', 'cs', 'cy', 'da', 'de', 'de-at', 'de-ch', 'en', 'en-ca',
        'en-au', 'en-gb', 'en-ie', 'en-nz', 'eo', 'es', 'es-do', 'es-us', 'et', 'fa', 'fi', 'fr', 'fr-ca', 'fr-ch',
        'el', 'he', 'hi', 'hu', 'id', 'it', 'ja', 'ko', 'km', 'kk', 'lt', 'lv', 'mk', 'ms', 'my', 'nl', 'nb', 'pa-in',
        'pl', 'pt', 'pt-br', 'ro', 'ru', 'si', 'sk', 'sl', 'sq', 'sr', 'sv', 'uk', 'vi', 'zh-cn', 'zh-hk', 'zh-tw',
    ];

    private static $errorSupportedLocales = [
        'ar', 'az', 'bg', 'ca', 'cs', 'da', 'de', 'el', 'en', 'es', 'et', 'eu', 'fa', 'fi', 'fr', 'he', 'hi',
        'hr', 'hu', 'id', 'it', 'ja', 'ka', 'ko', 'lt', 'lv', 'mn', 'ms_MY', 'nb_NO', 'ne', 'nl', 'nn_NO', 'pl',
        'pt_BR', 'pt_PT', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr', 'sr_Latin', 'sv', 'th', 'tr', 'uk', 'vi', 'zh_CN', 'zh_TW',
    ];

    private static $translatedMomentJSLocalesToErrorLocales = [
        'hr'    => 'hr', 'th' => 'th', 'tr' => 'tr', 'ar' => 'ar', 'be' => 'be', 'bg' => 'bg', 'bn' => null, 'ca' => 'ca',
        'cs'    => 'cs', 'cy' => null, 'da' => 'da', 'de' => 'de', 'de-at' => 'de', 'de-ch' => 'de', 'en' => 'en',
        'en-ca' => 'en', 'en-au' => 'en', 'en-gb' => 'en', 'en-ie' => 'en', 'en-nz' => 'en', 'eo' => null, 'es' => 'es',
        'es-do' => 'es', 'es-us' => 'es', 'et' => 'et', 'fa' => 'fa', 'fi' => 'fi', 'fr' => 'fr', 'fr-ca' => 'fr',
        'fr-ch' => 'fr', 'el' => 'el', 'he' => 'he', 'hi' => 'hi', 'hu' => 'hu', 'id' => 'id', 'it' => 'it', 'ja' => 'ja',
        'ko'    => 'ko', 'km' => 'km', 'kk' => null, 'lt' => 'lt', 'lv' => 'lv', 'mk' => null, 'ms' => 'ms_MY', 'my' => null,
        'nl'    => 'nl', 'nb' => 'nb_NO', 'pa-in' => null, 'pl' => 'pl', 'pt' => 'pt_PT', 'pt-br' => 'pt_BR', 'ro' => 'ro',
        'ru'    => 'ru', 'si' => 'si', 'sk' => 'sk', 'sl' => 'sl', 'sq' => 'sq', 'sr' => 'sr', 'sv' => 'sv', 'uk' => 'uk',
        'vi'    => 'vi', 'zh-cn' => 'zh_CN', 'zh-hk' => 'zh_CN', 'zh-tw' => 'zh_TW',
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
            } else {
                $this->locale = $locale;
            }

            if (array_key_exists($locale, self::$translatedMomentJSLocalesToErrorLocales) && self::$translatedMomentJSLocalesToErrorLocales[$locale]) {
                $this->errorLocale = self::$translatedMomentJSLocalesToErrorLocales[$locale];
            }

            if ($this->locale === 'en') {
                $this->locale = 'en-gb';
            }

            return $this->withMeta([__FUNCTION__         => $this->locale,
                                    'errorMessageLocale' => $this->errorLocale]);
        }
    }

    /**
     * @param $message
     * @return mixed
     */
    public function errorMessage($message)
    {
        if ($message) {
            return $this->withMeta([__FUNCTION__ => $message]);
        }
    }

    /**
     * Has to be one of these https://github.com/baianat/vee-validate/tree/master/locale
     *
     * @param $locale
     * @return mixed
     * @throws \Techouse\IntlDateTime\LocaleNotSupportedException
     */
    public function errorMessageLocale($locale)
    {
        if ($locale) {
            if (!in_array($locale, self::$errorSupportedLocales, true)) {
                throw new LocaleNotSupportedException("Locale {$locale} is not supported by VeeValidate. Please consult the module documentation.");
            } else {
                $this->errorLocale = $locale;
            }

            return $this->withMeta([__FUNCTION__ => $this->errorLocale]);
        }
    }
}
