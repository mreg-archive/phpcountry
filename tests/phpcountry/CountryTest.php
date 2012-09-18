<?php
namespace itbz\phpcountry;

define(
    'SOURCE_DIR',
    dirname(dirname(__DIR__)) . "/vendor/itbz/country-list/country"
);

class CountryTest extends \PHPUnit_Framework_TestCase
{

    function testSetGetBackend()
    {
        $c = new Country;
        $this->assertEquals('icu', $c->getBackend());
        $c->setCldr();
        $this->assertEquals('cldr', $c->getBackend());
        $c->setIcu();
        $this->assertEquals('icu', $c->getBackend());
    }


    /**
     * @expectedException \itbz\phpcountry\Exception
     */
    function testSetDataSourceDirExcception()
    {
         $c = new Country;
         $c->setDataSourceDir('not/a/vaid/dir');
    }


    function testSetGetDataSourceDir()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $this->assertEquals(SOURCE_DIR, $c->getDataSourceDir());
    }


    /**
     * @expectedException \itbz\phpcountry\Exception
     */
    function testSetUknownLangException()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('WWW');
    }


    function testSetGetLanguage()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('en');
        $this->assertEquals('en', $c->getLang());        
    }


    function testSetLangFromLocale()
    {
        setlocale(LC_ALL, 'en_GB.UTF-8', 'en_US.UTF-8', 'en_GB', 'en_US', 'en');
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->getLang();
    }


    /**
     * @expectedException \itbz\phpcountry\Exception
     */
    function testTranslateNoMapError()
    {
        $c = new Country;
        $c->translate('se');
    }


    function testTranslateAutoMap()
    {
        setlocale(LC_ALL, 'en_GB.UTF-8', 'en_US.UTF-8', 'en_GB', 'en_US', 'en');
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->translate('se');
    }


    /**
     * @expectedException \itbz\phpcountry\TranslationException
     */
    function testTranslateError()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('en');
        $c->translate('sese');
    }


    function testTranslate()
    {
        $c = new Country;
        $c->setDataSourceDir(SOURCE_DIR);
        $c->setLang('en');
        $this->assertEquals('Sweden', $c->translate('se'));
    }

}