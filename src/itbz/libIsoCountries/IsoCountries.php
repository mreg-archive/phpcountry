<?php
/**
 * This file is part of the libIsoCountries package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 *
 * @package libIsoCountries
 */
namespace itbz\libIsoCountries;


/**
 * Get localized country names from ISO 3166-1 codes
 * 
 * @package libIsoCountries
 */
class IsoCountries
{

    /**
     * Array mapping ISO 3166-1 codes to country names
     *
     * @var array
     */
    private $_isoMap;


    /**
     * Name of current language used
     *
     * @var string
     */
    private $_lang = '';


    /**
     * Full path to the data source directory tree
     *
     * @var string
     */
    private $_dataSourceDir = '';


    /**
     * Backend used when reading from country-list
     *
     * @var string
     */
    private $_dataBackend = 'icu';

    /**
     * Set ICU as data backend
     *
     * @return void
     */
    public function setIcu()
    {
        $this->_dataBackend = 'icu';
    }


    /**
     * Set CLDR as data backend
     *
     * @return void
     */
    public function setCldr()
    {
        $this->_dataBackend = 'cldr';
    }

 
    /**
     * Get name of data backend used
     *
     * @return string
     */
    public function getBackend()
    {
        return $this->_dataBackend;
    }


    /**
     * Set path to data source directory tree
     *
     * @param string $dataSourceDir
     *
     * @return void
     *
     * @throws Exception if $dataSourceDir is not a valid directory
     */
    public function setDataSourceDir($dataSourceDir)
    {
        assert(is_string($dataSourceDir));
        if (!is_dir($dataSourceDir)) {
            $msg = "Not a valid directory ($dataSourceDir).";
            throw new Exception($msg);
        }
        $this->_dataSourceDir = $dataSourceDir;
    }


    /**
     * Get path to data source directory tree
     *
     * @return string
     */
    public function getDataSourceDir()
    {
        // Try to calculate data source directory from composer vendor dir
        // @codeCoverageIgnoreStart
        if (empty($this->_dataSourceDir)) {
            $vendorDir = dirname(dirname(__DIR__));
            $dataSourceDir = '';
            if (file_exists($vendorDir . '/autoload.php')) {
                $dataSourceDir = implode(
                    DIRECTORY_SEPARATOR,
                    array(
                        $vendorDir,
                        'itbz',
                        'country-list',
                        'country'
                    )
                );
            }
            $this->setDataSourceDir($dataSourceDir);
        }
        // @codeCoverageIgnoreEnd

        return $this->_dataSourceDir;
    }


    /**
     * Set current language
     *
     * The supported list of languages depends on if CLDR or ICU is used as
     * data backend. For a list of supported languages check the
     * country-list/country directory.
     *
     * Note that the language code is case sensitive.
     *
     * @param string $lang Code for language to use.
     *
     * @return void
     *
     * @throws Exception if language is unknown or unvalid
     */
    public function setLang($lang)
    {
        assert(is_string($lang));
        
        $fname = implode(
            DIRECTORY_SEPARATOR,
            array(
                $this->getDataSourceDir(),
                $this->getBackend(),
                $lang,
                'country.php'
            )
        );

        if (!is_readable($fname)) {
            $msg = "Unable to set language, datamap not readable ($fname).";
            throw new Exception($msg);
        }

        $isoMap = include $fname;

        // @codeCoverageIgnoreStart
        if (!is_array($isoMap)) {
            $msg = "Unable to set language, datamap not an array ($fname).";
            throw new Exception($msg);
        }
        // @codeCoverageIgnoreEnd

        $this->_isoMap = $isoMap;
        $this->_lang = $lang;
    }


    /**
     * Try to set language from current locale
     *
     * @return void
     */
    public function setLangFromLocale()
    {
        try {
            // Try using the portion of the locale prior to .
            list($locale) = explode('.', setlocale(LC_ALL, ''));
            $this->setLang($locale);
        } catch (Exception $e) {
            try {
                // Try removing trailing _ from locale
                list($locale) = explode('_', $locale);
                $this->setLang($locale);
            } catch (Exception $e) {
            }
        }
    }


    /**
     * Get current language
     *
     * @return string
     */
    public function getLang()
    {
        if (empty($this->_lang)) {
            $this->setLangFromLocale();
        }

        return $this->_lang;
    }


    /**
     * Translate a ISO 3166-1 code to country name
     *
     * @param string $isoCode
     *
     * @return string
     *
     * @throws Exception if no language is specified
     *
     * @throws TranslationException if no translation exists
     */
    public function translate($isoCode)
    {
        assert(is_string($isoCode));

        // Try to set language from locale if we have no map
        if (!isset($this->_isoMap)) {
            $this->setLangFromLocale();

            // Still no map? This is an error.
            if (!isset($this->_isoMap)) {
                $msg = "Unable to translate, no language specified.";
                throw new Exception($msg);
            }
        }

        $isoCode = strtoupper($isoCode);

        if (!isset($this->_isoMap[$isoCode])) {
            $msg = "Unable to translate '$isoCode'.";
            throw new TranslationException($msg);
        }

        return $this->_isoMap[$isoCode];
    }

}