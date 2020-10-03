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
        $content = [];
        // loop files
        foreach (array_values($resources) as $key => $file) {
            // skip if maxValues is set
            if ($maxFiles && $key > $maxFiles) return;
            // only excepted types
            if (in_array($file['as'], ['style', 'script'])) {
                // add to handler
                $content[] = $this->addPreloadHeader($file['link'], $file['as'], $file['attributes']);
            }
        }
        // create html string
        return implode('', $content);
    }

    /**
     * add preload tag
     *
     * @param string $uri
     * @param string $type ="{style/script/image/font}"
     * @return string
     */
    protected function addPreloadHeader(string $uri, string $as, array $attributes)
    {
        // fetch URL
        $file = parse_url($uri, PHP_URL_PATH);
        // get File info
        $data = pathinfo($file);
        // build preload
        return sprintf('<link rel="preload" href="%1$s" as="%2$s" %3$s/>', $uri, $as, $this->getAttributes($attributes));
    }

    /**
     * @param $attributes
     * @return string
     */
    protected function getAttributes($attributes)
    {
        $string = [];
        foreach ($attributes as $key => $value) {
            $string[] = sprintf('%1$s="%2$s"', $key, $value);
        }
        return implode(' ', $string);
    }

}