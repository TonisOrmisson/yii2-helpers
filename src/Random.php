<?php

namespace andmemasin\helpers;

use Ramsey\Uuid\Uuid;

class Random
{
    const DEFAULT_PASSWORD_LENGTH = 9;


    public static function generatePassword(int $length = 9, int $strength = 0): string {
        if ($length <= 0) {
            return '';
        }

        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[random_int(0, strlen($consonants) - 1)];
                $alt = 0;
            } else {
                $password .= $vowels[random_int(0, strlen($vowels) - 1)];
                $alt = 1;
            }
        }
        return $password;
    }

    /**
     * get an uuid V4
     * @return string
     */
    public static function getUuidV4(): string {
        $uuid = Uuid::uuid4();
        return $uuid->toString();
    }

}
