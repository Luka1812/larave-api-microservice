<?php

namespace App\Enums;

use BenSampo\Enum\Enum as BaseEnum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use Illuminate\Support\Facades\Lang;

abstract class Enum extends BaseEnum implements LocalizedEnum
{
    /**
     * Get the description for an enum value
     *
     * @param mixed $value
     * @param array $replace
     *
     * @return string
     */
    public static function getDescription($value, array $replace = []): string
    {
        if ($replace && static::isLocalizable()) {
            $localizedStringKey = static::getLocalizationKey() . '.' . $value;

            if (Lang::has($localizedStringKey)) {
                return Lang::get($localizedStringKey, $replace);
            }
        }

        return parent::getDescription($value);
    }

    /**
     * Return the enum as an string.
     *
     * [mixed $value1, mixed $value2, mixed $value3]
     *
     * @return string
     */
    public static function toString(): string
    {
        return implode(', ', static::toArray());
    }
}
