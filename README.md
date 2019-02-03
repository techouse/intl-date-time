# International DateTime

[![Latest Version on Packagist](https://img.shields.io/packagist/v/techouse/intl-date-time.svg?style=flat-square)](https://packagist.org/packages/techouse/intl-date-time)
[![Total Downloads](https://img.shields.io/packagist/dt/techouse/intl-date-time.svg?style=flat-square)](https://packagist.org/packages/techouse/intl-date-time)

##### International datepicker for Laravel Nova

Apply localisation to Laravel Nova's default `DateTime` field that currently doesn't support localisation out of the box.

![International DateTime](./screenshot.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require techouse/intl-date-time
```

## Usage

The API is adapted from [Nova's default `DateTime` Field](https://nova.laravel.com/docs/1.0/resources/fields.html#datetime-field).

The module itself offers 3 optional configurations:
* __locale__ - _OPTIONAL_ -  With this you can define the module's locale. If you do not it will automatically use your app's `config('app.locale')`. If you manually define an unsupported locale it will throw an Exception!
* __dateFormat__ - _OPTIONAL_ - With this you can define a date format. If you do not provide it the module will automatically use the appropriate locale's date format. The format must be [MomentJS compatible](https://momentjs.com/docs/#/displaying/format/)!
* __timeFormat__ - _OPTIONAL_ - With this you can define a time format. If you do not provide it the module will automatically use `HH:mm:ss`. The format must be [MomentJS compatible](https://momentjs.com/docs/#/displaying/format/)!

Simply use `IntlDateTime` class instead of `DateTime` directly or alias it like the example below so you won't have to refactor too much existing code.

```php
<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class User extends Resource
{
    /**
     *  This is how you use and configure this module
     */
    public function fields(Request $request)
    {
        return [
            DateTime::make(__('Updated at'), 'updated_at')
                    /**
                     * The module automatically uses your app's locale 
                     * from config('app.locale'), however you can manually
                     * override this by setting it like this.
                     * 
                     * IMPORTANT: Check the list of supported locales below in this readme!
                     * 
                     * NOTE: If the automatic locale is not supported by MomentJS 
                     * the module defaults to 'en-gb' (British English).
                     */
                    ->locale('sl'),
                    
            DateTime::make(__('Created at'), 'created_at')
                    /**
                      * You can optionally set a custom DATE format.
                      * 
                      * It has to be compatible with MomentJS!!!
                      * https://momentjs.com/docs/#/displaying/format/
                      */
                    ->dateFormat('d.m.Y'),   
                    
            DateTime::make(__('Deleted at'), 'deleted_at')
                    /**
                      * You can optionally set a custom TIME format
                      * 
                      * It has to be compatible with MomentJS!!!
                      * https://momentjs.com/docs/#/displaying/format/
                      */
                    ->timeFormat('HH:mm'),
        ];
    }

    /**
     * The rest of the Resource ... bla bla bla :)
     */
}

```

## List of supported locales

Only module supports only locales that are __SUPPORTED BY BOTH__ [MomentJS](https://github.com/tqc/moment/tree/develop/src/locale) __AND__ [Flatpickr](https://github.com/flatpickr/flatpickr/tree/master/src/l10n)!

Here is a convenient list of these locales:

* Albanian: `sq`
* Arabic: `ar`
* Bangla: `bn`
* Belarusian: `be`
* Bulgarian: `bg`
* Burmese: `my`
* Catalan: `ca`
* Chinese (China): `zh-cn`
* Chinese (Hong Kong): `zh-hk`
* Chinese (Taiwan): `zh-tw`
* Croatian: `hr` 
* Czech: `cs`
* Danish: `da`
* Dutch: `nl`
* English (Australia): `en-au`
* English (Canada): `en-ca`
* English (Ireland): `en-ie`
* English (New Zealand): `en-nz`
* English (United Kingdom): `en-gb`
* English: `en`
* Esperanto: `eo`
* Estonian: `et`
* Finnish: `fi`
* French (Canada): `fr-ca`
* French (Switzerland): `fr-ch`
* French: `fr`
* German (Austria): `de-at`
* German (Switzerland): `de-ch`
* German: `de`
* Greek: `el`
* Hebrew: `he`
* Hindi: `hi`
* Hungarian: `hu`
* Indonesian: `id`
* Italian: `it`
* Japanese: `ja`
* Kazakh: `kk`
* Khmer: `km`
* Korean: `ko`
* Latvian: `lv`
* Lithuanian: `lt`
* Macedonian: `mk`
* Malaysian: `ms`
* Norwegian: `nb`
* Persian: `fa`
* Polish: `pl`
* Portuguese: `pt`
* Punjabi: `pa-in`
* Romanian: `ro`
* Russian: `ru`
* Serbian: `sr`
* Sinhala: `si`
* Slovak: `sk`
* Slovenian: `sl`
* Spanish (Dominican Republic): `es-do`
* Spanish(United States): `es-us`
* Spanish: `es`
* Swedish: `sv`
* Thai: `th`
* Turkish: `tr`
* Ukrainian: `uk`
* Vietnamese: `vi`
* Welsh: `cy`

##### NOTE
This an evolution of my original [Slovenian DateTime](https://github.com/techouse/slovenian-date-time)