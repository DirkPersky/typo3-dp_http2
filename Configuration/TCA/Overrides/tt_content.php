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

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3_MODE') || die();

// Register Plugin and name SPaces
ExtensionUtility::registerPlugin(
    'DirkPersky.' . 'dp_http2',
    'HTTP2',
    'HTTP2'
);