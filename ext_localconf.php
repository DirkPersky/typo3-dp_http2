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


defined('TYPO3_MODE') or die();

$boot = function () {
    // post processing hook to clear any existing cache files if the button in
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
        DirkPersky\DpHttp2\Hooks\ContentPostProcessor::class . '->accumulateResources';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] =
        DirkPersky\DpHttp2\Hooks\ContentPostProcessor::class . '->all';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] =
        DirkPersky\DpHttp2\Hooks\ContentPostProcessor::class . '->output';

    // the backend is clicked (contains an age check)
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] =
        DirkPersky\DpHttp2\Hooks\CacheClear::class . '->clearCachePostProc';
};

$boot();
unset($boot);
