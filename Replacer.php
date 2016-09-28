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
        return preg_replace_callback('/{([^}]+)}/', function ($m) use ($allParams) {
            // skip if is not set
            if(isset($allParams[$m[1]])){
                return $allParams[$m[1]];
            }
            return false;
            }, $text);
    }
}
