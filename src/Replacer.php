<?php

namespace andmemasin\helpers;

use yii\base\InvalidArgumentException;

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
     * @param array $params
     * @return string
     */
    public static function replace($text, $params = []) {
        if ($text === null) {
            return null;
        }

        if (!is_string($text)) {
            throw new InvalidArgumentException('Text must be string or null in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        if ($params === null) {
            $params = [];
        }

        if (!is_array($params)) {
            throw new InvalidArgumentException('Params must be array or null in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        $result = preg_replace_callback('/{([^}]+)}/', function ($m) use ($params) {
            // skip if is not set
            if (array_key_exists($m[1], $params)) {
                return (string) $params[$m[1]];
            }
            \Yii::error('Failed to replace field: '.$m[1], __METHOD__);
            return "{".$m[1]."}";
        }, $text);

        if ($result === null) {
            throw new \RuntimeException('Failed to perform replacements in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        return $result;
    }

    /**
     * get the items in {} as array
     * @param $text
     * @return mixed
     */
    public static function getParams($text) {
        if ($text === null || $text === '') {
            return [];
        }
        if (!is_string($text)) {
            throw new InvalidArgumentException('Text must be string or null in ' . __CLASS__ . '::' . __FUNCTION__);
        }
        preg_match_all('/{(.*?)}/', $text, $matches);
        return $matches[0];

    }
}
