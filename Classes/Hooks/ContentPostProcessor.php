<?php declare(strict_types=1);
/*
 * Copyright (c) 2020.
 *
 * @category   TYPO3
 *
 * @copyright  2020 Dirk Persky (https://github.com/DirkPersky)
 * @author     Dirk Persky <dirk.persky@gmail.com>
 * @license    MIT
 */

namespace DirkPersky\DpHttp2\Hooks;

use DirkPersky\DpHttp2\Utility\ResourceParser;
use DirkPersky\DpHttp2\Utility\ResponsePreload;
use DirkPersky\DpHttp2\Utility\ResponsePusher;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use function file_exists;
use function file_get_contents;
use function is_array;
use function is_dir;

/**
 * Class ContentPostProcessor
 * @package DirkPersky\DpHttp2\Hooks
 */
class ContentPostProcessor
{
    const PUSH_MODE = 'http2push';
    const PRELOAD_MODE = 'preload';
    /**
     * @var ConfigurationManager
     */
    protected $typoScript;
    /**
     * dir for json files
     *
     * @var array
     */
    protected $tempDir = '';

    /**
     * ContentPostProcessor constructor.
     */
    public function __construct()
    {
        // get public path
        $pathSite = Environment::getPublicPath() . '/';
        // define save folder
        $this->tempDir = $pathSite . 'typo3temp/dp_http2/';
        // create dir if not exists
        if (!is_dir($this->tempDir)) GeneralUtility::mkdir($this->tempDir);
    }

    /**
     * @param array $params
     */
    public function accumulateResources(array $params)
    {
    }

    /**
     * @param array $params
     * @param TypoScriptFrontendController $typoScriptFrontendController
     */
    public function all(array $params, TypoScriptFrontendController $typoScriptFrontendController)
    {
    }

    /**
     * @param array $params
     * @param TypoScriptFrontendController $typoScriptFrontendController
     */
    public function output(array $params, TypoScriptFrontendController $typoScriptFrontendController)
    {
        // skip the processing if the current request contains INT scripts and has therefore uncached
        if ($GLOBALS['TSFE']->isINTincScript()) return;
        // site config
        if (method_exists($typoScriptFrontendController, 'getSite')) {
            $siteKey = $typoScriptFrontendController->getSite()->getIdentifier();
        } else {
            $siteKey = $GLOBALS['TYPO3_REQUEST']->getAttribute('site')->getIdentifier();
        }
        // paceholder values
        $maxFiles = null;
        $modus = null;
        $dataSet = [];
        // if is Enables parse content
        if ($this->isEnabled()) {
            $modus = $this->getConfig('plugin.dp_http2.settings.modus');
            $maxFiles = $this->getConfig('plugin.dp_http2.settings.maxFiles');
            // get Preloads from DOM
            $preloads = ResourceParser::preloads($typoScriptFrontendController->content);
            // get Stylesheats from DOM
            $styles = ResourceParser::stylesheat($typoScriptFrontendController->content);
            // get JS from DOM
            $js = ResourceParser::javascript($typoScriptFrontendController->content);
            // dataset
            $dataSet = array_merge($styles, $js, $preloads);
            // create Json temp File
            $jsonString = json_encode(['maxFiles' => (empty($maxFiles) ? null : (int)$maxFiles), 'modus' => $modus, 'dataset' => $dataSet]);
            // create backupfile
            $this->writeFile($siteKey, $jsonString);
        } else {
            // check if cache file exist
            $content = $this->getFile($siteKey);
            // if content exists
            if (!empty($content)) {
                // path to values
                $dataSet = $content['dataset'];
                $maxFiles = $content['maxFiles'];
                $modus = $content['modus'];
            }
        }
        // if dataset eixst go one
        if (!empty($dataSet)) {
            // preload Header
            if ($modus == static::PRELOAD_MODE) {
                // get Preload tags
                $preloadContent = GeneralUtility::makeInstance(ResponsePreload::class)->preloadAll($dataSet, $maxFiles);
                // add preload header tags
                $typoScriptFrontendController->content = preg_replace(
                    '/<\/title>/', '</title>' . $preloadContent, $typoScriptFrontendController->content, 1
                );
            }
            // push header
            if ($modus == static::PUSH_MODE) GeneralUtility::makeInstance(ResponsePusher::class)->pushAll($dataSet, $maxFiles);
        }

    }

    /**
     * @return bool
     */
    protected function isEnabled()
    {
        // return is active
        return ($this->getConfig('plugin.dp_http2.settings.enabled') == 'true');
    }

    /**
     * @param $keys
     * @return ConfigurationManager|mixed|null
     */
    protected function getConfig($keys)
    {
        // if not defined get get TypoScript
        if (!$this->typoScript) {
            // get ConfigManager
            $settings = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
            // Das komplette TypoScript holen
            $this->typoScript = $settings->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        }
        // value holder
        $value = $this->typoScript;
        // explode
        $loops = explode('.', $keys);
        // get config
        foreach ($loops as $index => $key) {
            // get correct key
            if (($index + 1) < count($loops)) $key .= '.';
            // loop data
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                $value = null;
            }
        }
        // return set
        return $value;
    }

    /**
     * Writes $content to the file $file
     *
     * @param string $file file path to write to
     * @param string $content Content to write
     * @return boolean TRUE if the file was successfully opened and written to.
     */
    protected function writeFile($file, $content)
    {
        // create file
        $result = GeneralUtility::writeFile($this->tempDir . $file . '.json', $content);
        // hook here for other file system operations like syncing to other servers etc.
        $hooks = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['dp_http2']['writeFilePostHook'];
        if (is_array($hooks)) {
            foreach ($hooks as $classReference) {
                $hookObject = GeneralUtility::makeInstance($classReference);
                $hookObject->writeFilePostHook($file, $content, $this);
            }
        }
        // return status
        return $result;
    }

    /**
     * @param $file
     * @return mixed
     */
    protected function getFile($file)
    {
        $filepath = $this->tempDir . $file . '.json';
        // file exists
        $fileExists = file_exists($filepath);
        if ($fileExists) {
            // get content
            $content = file_get_contents($filepath);
            // return content
            return json_decode($content, true);
        }
    }
}