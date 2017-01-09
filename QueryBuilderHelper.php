<?php

namespace andmemasin\helpers;


class QueryBuilderHelper
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_DOUBLE = 'double';
    const TYPE_DATE = 'date';
    const TYPE_TIME = 'time';
    const TYPE_DATETIME = 'datetime';
    const TYPE_BOOLEAN = 'boolean';

    public static function getTypes(){
        return [
            self::TYPE_STRING => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_DOUBLE => 'Double',
            self::TYPE_DATE => 'Date',
            self::TYPE_DATETIME => 'datetime',
            self::TYPE_BOOLEAN => 'boolean',
        ];
    }

}