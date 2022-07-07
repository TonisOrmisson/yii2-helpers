<?php

namespace andmemasin\helpers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Random
{
    const DEFAULT_PASSWORD_LENGTH = 9;


    public static function generatePassword($length = 9, $strength = 0) {
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
                $password .= $consonants[(random_int(0,strlen($consonants)) % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(random_int(0, strlen($vowels)) % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    /**
     * get an uuid V4
     * @return string
     */
    public static function getUuidV4() {
        $uuid = Uuid::uuid4();
        return $uuid->toString();
    }

}