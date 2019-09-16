<?php

namespace App\Mapper;

interface Mapper
{
    /**
     * Map data to array
     *
     * @return array
     */
    public function toArray() : array;
}