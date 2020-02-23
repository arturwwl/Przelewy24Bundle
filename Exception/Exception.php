<?php
/*
 * This file is part of the ArturwwlPrzelewy24Bundle package.
 *
 * (c) Arturwwl <https://arturwwl.pl/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arturwwl\Przelewy24Bundle\Exception;


class Exception
{
    /**
     * @param $string
     * @throws \Exception
     */
    public static function getExceptionsFromString($string, $type)
    {
        $array = \explode('&', $string);
        if ($array[0] == 'error=0' || $string == "") {
            return;
        }

        throw new \Exception($type . ': ' . $string);
    }

}