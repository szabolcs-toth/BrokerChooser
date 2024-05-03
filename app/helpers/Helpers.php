<?php

namespace App\helpers;

use Carbon\Carbon;

class Helpers
{
    /**
     * @return string
     */
    public static function getNow(): string
    {
        return Carbon::now()->format('Y-m-d H:i:s');
    }

    /**
     * @param array $weightedValues
     * @return int|null
     */
    public static function getRandomWeightedElement(array $weightedValues): ?int
    {
        $rand = mt_rand(1, (int)array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }
}
