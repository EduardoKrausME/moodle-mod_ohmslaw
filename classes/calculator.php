<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * calculator.php
 *
 * @package   mod_ohmslaw
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_ohmslaw;

use InvalidArgumentException;

/**
 * Class calculator.
 */
class calculator {
    /**
     * Solves V, I, R and P from exactly two known values.
     *
     * @param array $values Keys: voltage, current, resistance, power.
     * @return array
     */
    public static function solve(array $values): array {
        $known = array_filter($values, static fn($value) => $value !== null && $value !== "");
        if (count($known) !== 2) {
            throw new InvalidArgumentException("Exactly two values are required.");
        }

        foreach ($known as $value) {
            if (!is_numeric($value) || (float)$value <= 0) {
                throw new InvalidArgumentException("Values must be positive numbers.");
            }
        }

        $v = array_key_exists("voltage", $known) ? (float)$known["voltage"] : null;
        $i = array_key_exists("current", $known) ? (float)$known["current"] : null;
        $r = array_key_exists("resistance", $known) ? (float)$known["resistance"] : null;
        $p = array_key_exists("power", $known) ? (float)$known["power"] : null;

        if ($v !== null && $i !== null) {
            $r = $v / $i;
            $p = $v * $i;
        } else if ($v !== null && $r !== null) {
            $i = $v / $r;
            $p = ($v * $v) / $r;
        } else if ($v !== null && $p !== null) {
            $i = $p / $v;
            $r = ($v * $v) / $p;
        } else if ($i !== null && $r !== null) {
            $v = $i * $r;
            $p = ($i * $i) * $r;
        } else if ($i !== null && $p !== null) {
            $v = $p / $i;
            $r = $p / ($i * $i);
        } else if ($r !== null && $p !== null) {
            $i = sqrt($p / $r);
            $v = sqrt($p * $r);
        }

        return [
            "voltage" => $v,
            "current" => $i,
            "resistance" => $r,
            "power" => $p,
            "conductance" => 1 / $r,
        ];
    }
}
