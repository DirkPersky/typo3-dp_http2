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

$EM_CONF[$_EXTKEY] = [
    'title' => 'HTTP2 Push',
    'description' => 'This Plugin add HTTP2 Push header or preloads, scripts and css files',
    'category' => 'fe',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => 'typo3temp/dp_http2/',
    'clearcacheonload' => false,
    'author' => 'Dirk Persky',
    'author_email' => 'infoy@dp-wired.de',
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99'
        ],
        'conflicts' => [],
        'suggests' => [
            'setup' => '',
        ],
    ],

    'autoload' => [
        'psr-4' => [
            'DirkPersky\\DpHttp2\\' => 'Classes'
        ],
    ],
];

