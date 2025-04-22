<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/laminas-mime-double.
 *
 * @link     https://github.com/huangdijia/laminas-mime-double
 * @document https://github.com/huangdijia/laminas-mime-double/blob/main/README.md
 * @contact  Huang Dijia <huangdijia@gmail.com>
 */

namespace Laminas\Mime;

use RuntimeException;

class Decode
{
    /**
     * split a header field like content type in its different parts.
     *
     * @param string $field header field
     * @param string $wantedPart the wanted part, else an array with all parts is returned
     * @param string $firstName key name for the first part
     * @return string|array wanted part or all parts as array($firstName => firstPart, partname => value)
     * @throws RuntimeException
     */
    public static function splitHeaderField($field, $wantedPart = null, $firstName = '0')
    {
        $wantedPart = strtolower($wantedPart ?? '');
        $firstName = strtolower($firstName);

        // special case - a bit optimized
        if ($firstName === $wantedPart) {
            $field = strtok($field, ';');
            return $field[0] === '"' ? substr($field, 1, -1) : $field;
        }

        $field = $firstName . '=' . $field;
        if (! preg_match_all('%([^=\s]+)\s*=\s*("[^"]+"|[^;]+)(;\s*|$)%', $field, $matches)) {
            throw new RuntimeException('not a valid header field');
        }

        if ($wantedPart) {
            foreach ($matches[1] as $key => $name) {
                if (strcasecmp($name, $wantedPart)) {
                    continue;
                }
                if ($matches[2][$key][0] !== '"') {
                    return $matches[2][$key];
                }
                return substr($matches[2][$key], 1, -1);
            }
            return;
        }

        $split = [];
        foreach ($matches[1] as $key => $name) {
            $name = strtolower($name);
            if ($matches[2][$key][0] === '"') {
                $split[$name] = substr($matches[2][$key], 1, -1);
            } else {
                $split[$name] = $matches[2][$key];
            }
        }

        return $split;
    }
}
