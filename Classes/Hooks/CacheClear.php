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

use TYPO3\CMS\Core\Core\Environment;

class CacheClear
{

    /**
     * dir for json files
     *
     * @var array
     */
    protected $tempDir = '';

    /**
     * CacheClear constructor.
     */
    public function __construct()
    {
        // get public path
        $pathSite = Environment::getPublicPath() . '/';
        // define save folder
        $this->tempDir = $pathSite . 'typo3temp/dp_http2/';
    }

    /**
     * Clear cache processor
     * This method deletes all temporary files
     *
     * @param $params
     */
    public function clearCachePostProc(&$params)
    {
        if (isset($params['cacheCmd']) && $params['cacheCmd'] !== 'all') {
            return;
        }
        // abort if no dir exists
        if (!is_dir($this->tempDir)) return;
        // read dir
        $handle = opendir($this->tempDir);
        while (FALSE !== ($file = readdir($handle))) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            //if is file
            if (is_file($this->tempDir . $file)) {
                // remove file
                unlink($this->tempDir . $file);
            }
        }

    }
}