<?php

namespace DirkPersky\DpHttp2\Utility;

class ResourceParser {

    public static function preloads($content){
        return static::parse('/<link[\/\s\w\-="]*rel="preload"[\/\s\w\-="]*\shref="(.*?)"/i', $content);
    }

    public static function stylesheat($content){
        return static::parse('/<link[\/\s\w\-="]*href="(.*?\.css)"/i', $content, 'style');
    }

    public static function javascript($content){
        return static::parse('/<script[\/\s\w\-="]*src="(.*?\.js)"/i', $content, 'script');
    }

    protected static function parse($regex, $content, $type = null){
        // parse
        preg_match_all($regex, $content, $matches);
        // holder
        $result = [];
        if(!empty($matches)){
            foreach ($matches[0] as $key => $match){
                $mimetype = $type;
                // if is null search for type
                if($mimetype == null) $mimetype = static::getMime($matches[1][$key]);
                // if type exist add
                if($mimetype){
                    // add to values
                    $result[] = [
                        'as' => $mimetype,
                        'link' => $matches[1][$key]
                    ];
                }

            }
        }
        // return set
        return $result;
    }

    protected static function getMime($file){
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