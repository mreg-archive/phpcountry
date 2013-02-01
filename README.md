phpcountry
==========

Get localized country names from ISO 3166-1 codes

Uses *umpirsky/country-list* to translate ISO 3166-1 country codes
to country names.

phpcountry needs to know the path to country-lists's data collection. If
you install using *composer* this problem is mitigated.

    $country = new \iio\phpcountry\Country;

    // only needed if you installed country-list to a costum location
    // (eg. did not use composer)
    $country->setDataSourceDir('path/to/country-list/country');

    // only needed if you do not want phpcountry to use the
    // current locale setting
    $country->setLang('en');

    // outputs: Sweden
    echo $country->translate('se');


## Running the unit tests

To run the tests you must first install the dependencies.

    > curl -s https://getcomposer.org/installer | php
    > php composer.phar install

And then from the *tests* directory

    > phpunit

### Using phing

You may also run tests and code analysis using Phing. To install phing type

    > sudo pear config-set preferred_state alpha
    > sudo pear install --alldeps phing/phing
    > sudo pear config-set preferred_state stable

Then from the project root directory

    > phing

This will run the tests and a number of other code analysis tools. Point your
browser to *build/index.html* to view the results.
