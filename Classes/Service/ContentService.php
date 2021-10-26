<?php declare(strict_types=1);
/*
 * Copyright (c) 2021.
 *
 * @category   TYPO3
 *
 * @copyright  2020 Dirk Persky (https://github.com/DirkPersky)
 * @author     Dirk Persky <dirk.persky@gmail.com>
 * @license    MIT
 */

namespace DirkPersky\DpHttp2\Service;


use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CleanHtmlService
 * @package DirkPersky\DpHttp2\Service
 */
class CleanHtmlService implements SingletonInterface
{
    const PUSH_MODE = 'http2push';
    const PRELOAD_MODE = 'preload';
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
     * @param string $html
     * @param array $config
     * @param mixed $request
     * @return string
     */
    public function parse($html, $config, $request)
    {
        die('TEST');

        return $html;
    }
}