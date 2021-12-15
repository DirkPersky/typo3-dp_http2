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
    // the backend is clicked (contains an age check)
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] =
        DirkPersky\DpHttp2\Hooks\CacheClear::class . '->clearCachePostProc';
};

$boot();
unset($boot);
