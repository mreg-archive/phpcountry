phpcountry
==========

Get localized country names from ISO 3166-1 codes

Uses *umpirsky/country-list* to translate ISO 3166-1 country codes
to country names using various languages.

phpcountry needs to know the path to country-lists's data collection. If
you install using *composer* this problem is mitigated.

    $iso3166 = new \iio\phpcountry\Country;

    // only needed if you installed country-list to a costum location
    // (eg. did not use composer)
    $iso3166->setDataSourceDir('path/to/country-list/country');

    // only needed if you do not want phpcountry to use the
    // current locale setting
    $iso3166->setLang('en');

    // outputs: Sweden
    echo $iso3166->translate('se');
