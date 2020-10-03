<?php
/*
 * Copyright (c) 2020.
 *
 * @category   TYPO3
 *
 * @copyright  2020 Dirk Persky (https://github.com/DirkPersky)
 * @author     Dirk Persky <dirk.persky@gmail.com>
 * @license    MIT
 */

namespace DirkPersky\DpHttp2\Utility;

use TYPO3\CMS\Core\Utility\PathUtility;


/**
 * Class RespsonsePusher
 * @package DirkPersky\DpHttp2\Utility
 */
class ResponsePreload
{
    /**
     * Push all Files to HTTP2 Header
     *
     * @param array $resources
     * @param null $maxFiles
     */
    public function preloadAll(array $resources, $maxFiles = null)
    {

    }
}