<?php
namespace iio\phpcountry;

define(
    'SOURCE_DIR',
    dirname(dirname(__DIR__)) . "/vendor/umpirsky/country-list/country"
);

class CountryTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetBackend()
    {
        $c = new Country;
        $this->assertEquals('icu', $c->getBackend());
        $c->setCldr();
        $this->assertEquals('cldr', $c->getBackend());
        $c->setIcu();
        $this->assertEquals('icu', $c->getBackend());
    }

    /**
     * @expectedException \iio\phpcountry\Exception
     */
    public function testSetDataSourceDirExcception()
    {
         $c = new Country;
         $c->setDataSourceDir('not/a/vaid/dir');
    }

    public function testSetGetDataSourceDir()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $this->assertEquals(SOURCE_DIR, $c->getDataSourceDir());
    }

    /**
     * @expectedException \iio\phpcountry\Exception
     */
    public function testSetUknownLangException()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('WWW');
    }

    public function testSetGetLanguage()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('en');
        $this->assertEquals('en', $c->getLang());
    }

    public function testSetLangFromLocale()
    {
        setlocale(LC_ALL, 'en_GB.UTF-8', 'en_US.UTF-8', 'en_GB', 'en_US', 'en');
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->getLang();
    }

    /**
     * @expectedException \iio\phpcountry\Exception
     */
    public function testTranslateNoMapError()
    {
        $c = new Country;
        $c->translate('se');
    }

    public function testTranslateAutoMap()
    {
        setlocale(LC_ALL, 'en_GB.UTF-8', 'en_US.UTF-8', 'en_GB', 'en_US', 'en');
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->translate('se');
    }

    /**
     * @expectedException \iio\phpcountry\TranslationException
     */
    public function testTranslateError()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('en');
        $c->translate('sese');
    }

    public function testTranslate()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('en');
        $this->assertEquals('Sweden', $c->translate('se'));
    }
}
