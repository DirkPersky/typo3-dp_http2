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
    'description' => 'This Plugin add HTTP2 Push header for preloads, scripts and css files',
    'category' => 'fe',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => 'typo3temp/dp_http2/',
    'clearcacheonload' => false,
    'author' => 'Dirk Persky',
    'author_email' => 'infoy@dp-wired.de',
    'version' => '10.5.7',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'scriptmerger' => '7.0.3-8.0.0'
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

