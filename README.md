phpcountry
==========

Get localized country names from ISO 3166-1 codes


## Deprecated

This package has been discontinued in favor of LocaleFacade. For corresponding
functionality use

    echo (new LocaleFacade('de'))->getDisplayCountries()['SE'];


## Usage

    $country = new \iio\phpcountry\Country;

    // only needed if you do not want phpcountry to use the
    // current locale setting
    $country->setLang('en');

    // outputs: Sweden
    echo $country->translate('se');
