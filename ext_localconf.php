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

defined('TYPO3_MODE') or die();

$boot = function () {
    // Register FE namespace
    ExtensionUtility::configurePlugin(
        'DirkPersky.' . 'dp_http2',
        'DpHttp2',
        []
    );

    // post processing hook to clear any existing cache files if the button in
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
        DirkPersky\DpHttp2\Hooks\ContentPostProcessor::class . '->accumulateResources';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] =
        DirkPersky\DpHttp2\Hooks\ContentPostProcessor::class . '->all';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] =
        DirkPersky\DpHttp2\Hooks\ContentPostProcessor::class . '->output';

};

$boot();
unset($boot);
