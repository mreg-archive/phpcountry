lib-iso-countries
=================

Get localized country names from ISO 3166-1 codes

Uses a clone of *umpirsky/country-list* to translate ISO 3166-1 country codes
to country names using various languages.

lib-iso-countries needs to know the path tp countru-lists's data collection. If
you install using *composer* this problem is mitigated.

    $iso3166 = new \itbz\libIsoCountries\IsoCountries;

    // only needed if you installed country-list to a costum location
    // (eg. did not use composer)
    $iso3166->setDataSourceDir('path/to/country-list/country');

    // only needed if you do not want lib-iso-countries to use the
    // current locale settings
    $iso3166->setLang('en');

    // outputs: Sweden
    echo $iso3166->translate('se');

For more in-depth documentation visit
http://itbz.github.com/classes/itbz.libIsoCountries.IsoCountries.html