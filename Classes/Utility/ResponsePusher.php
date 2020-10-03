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
class ResponsePusher
{
    /**
     * Push all Files to HTTP2 Header
     *
     * @param array $resources
     * @param null $maxFiles
     */
    public function pushAll(array $resources, $maxFiles = null)
    {
        // loop files
        foreach (array_values($resources) as $key => $file) {
            // skip if maxValues is set
            if ($maxFiles && $key > $maxFiles) return;
            // add to handler
            $this->addPushHeader($file['link'], $file['as'], $file['attributes']);
        }
        return;
    }

    /**
     * add PHP Header
     *
     * @param string $uri
     * @param string $type ="{style/script/image/font}"
     */
    protected function addPushHeader(string $uri, string $as, array $attributes)
    {
        header(sprintf('Link: <%1$s>; rel=preload; as=%2$s%3$s', htmlspecialchars(PathUtility::getAbsoluteWebPath($uri)), $as, $this->getAttributes(($attributes))), false);
    }

    /**
     * @param $attributes
     * @return string
     */
    protected function getAttributes($attributes)
    {
        $string = [];
        foreach ($attributes as $key => $value) {
            $string[] = sprintf('%1$s=%2$s', $key, $value);
        }
        if (!empty($string)) {
            return '; ' . implode('; ', $string);

        }
    }
}