<?php

namespace App\Support;

class Json
{
    /**
     * Json decode
     *
     * @param string
     * @return array
     */
    public static function decode(?string $json): array
    {
        return json_decode($json, true);
    }

    /**
     * Json encode
     *
     * @param array $data
     * @return array
     */
    public static function encode(?array $data): string
    {
        return json_encode($data);
    }
}