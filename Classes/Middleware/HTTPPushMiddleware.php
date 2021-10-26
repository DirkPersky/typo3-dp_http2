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

namespace DirkPersky\DpHttp2\Middleware;

use DirkPersky\DpHttp2\Service\ContentService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\NullResponse;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class CleanHtmlMiddleware
 * @package DirkPersky\DpHttp2\Middleware
 */
class CleanHtmlMiddleware implements MiddlewareInterface
{
    /**
     * @var ContentService
     */
    protected $contentService = null;

    /**
     * init middelware
     */
    public function __construct()
    {
        $this->contentService = GeneralUtility::makeInstance(ContentService::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        // check if response is exist
        if (!($response instanceof NullResponse) && $GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
            // process to Service and get preload HTML
            $processedHtml = $this->contentService->parse(
                $response->getBody()->__toString(),
                $GLOBALS['TSFE']->config['config']['dp_http2.'],
                $request
            );
            // Replace old body with $processedHtml
            $responseBody = new Stream('php://temp', 'rw');
            $responseBody->write($processedHtml);
            $response = $response->withBody($responseBody);
        }
        // return response
        return $response;
    }
}