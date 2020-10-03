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

/**
 * Class ResourceParser
 * @package DirkPersky\DpHttp2\Utility
 */
class ResourceParser
{

    /**
     * @param $content
     * @return array
     */
    public static function preloads($content)
    {
        return static::parse('/<link[\/\s\w\-="]*rel="preload"[\/\s\w\-="]*\shref="(.*?)"/i', $content);
    }

    /**
     * @param $content
     * @return array
     */
    public static function stylesheat($content)
    {
       return static::parse('/<link[\/\s\w\-="]*href="(.*?\.css)"(.*?)>/i', $content, 'style');
    }

    /**
     * @param $content
     * @return array
     */
    public static function javascript($content)
    {
        return static::parse('/<script[\/\s\w\-="]*src="(.*?\.js)"(.*?)>/i', $content, 'script');
    }

    /**
     * @param $regex
     * @param $content
     * @param null $type
     * @return array
     */
    protected static function parse($regex, $content, $type = null)
    {
        // parse
        preg_match_all($regex, $content, $matches);
        // holder
        $result = [];
        if (!empty($matches)) {
            foreach ($matches[0] as $key => $match) {
                $mimetype = $type;
                // if is null search for type
                if ($mimetype == null) $mimetype = static::getMime($matches[1][$key]);
                // if type exist add
                if ($mimetype) {
                    // parse aditional options for preloading
                    preg_match_all('/(integrity|crossorigin)="(.*?)"/i', $match, $temp);
                    $attributes = [];
                    // if results exist build set
                    if (!empty($temp)) {
                        foreach ($temp as $index => $var) {
                            if (!empty($temp[1][$index])) $attributes[$temp[1][$index]] = $temp[2][$index];
                        }
                    }
                    // add to values
                    $result[] = [
                        'as' => $mimetype,
                        'link' => $matches[1][$key],
                        'attributes' => $attributes
                    ];
                }

            }
        }
        // return set
        return $result;
    }

    /**
     * @param $file
     * @return string
     */
    protected static function getMime($file)
    {
        $file = parse_url($file, PHP_URL_PATH);
        $data = pathinfo($file);
        switch ($data['extension']) {
            case "css":
                return 'style';
            case "js":
                return 'script';
            case "png":
            case "jpg":
            case "webp":
                return 'image';
            case "woff2":
            case "woff":
            case "ttf":
                return 'font';
        }
    }
}