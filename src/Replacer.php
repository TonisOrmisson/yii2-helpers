<?php

namespace andmemasin\helpers;

/**
 * Replacement values helper
 *
 * @package app\models\helpers
 * @author Tonis Ormisson <tonis@andmemasin.eu>
 */
class Replacer {
    /**
     * Replace the {values} by $params[] values in $text
     * @param string $text
     * @param array[] $params
     * @return string
     */
    public static function replace($text, $params = []) {
        $allParams = $params;
        return preg_replace_callback('/{([^}]+)}/', function($m) use ($allParams) {
            // skip if is not set
            if (isset($allParams[$m[1]])) {
                return $allParams[$m[1]];
            }
            \Yii::error('Failed to replace field: '.$m[1], __METHOD__);
            return "{".$m[1]."}";
        }, $text);
    }

    /**
     * get the items in {} as array
     * @param $text
     * @return mixed
     */
    public static function getParams($text) {
        preg_match_all('/{(.*?)}/', $text, $matches);
        if (is_array($matches)) {
            return $matches[0];
        }

    }
}
