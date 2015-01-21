> **NOTE:** This package is deprecated and will not be updated. Please use the symfony
> [Intl](http://symfony.com/doc/current/components/intl.html#country-names) component instead.

PHP Country
===========

Get localized country names from ISO 3166-1 codes

Usage
-----
```php
$country = new \iio\phpcountry\Country;

// only needed if you do not want phpcountry to use the
// current locale setting
$country->setLang('en');

// outputs: Sweden
echo $country->translate('se');
```
