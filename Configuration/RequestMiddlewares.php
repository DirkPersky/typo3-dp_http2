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

use DirkPersky\DpHttp2\Middleware\HTTPPushMiddleware;

return [
    'frontend' => [
        'html/dphttp2/push-html' => [
            'target' => HTTPPushMiddleware::class,
            'after' => [
                'typo3/cms-frontend/maintenance-mode',
            ],
        ]
    ]
];