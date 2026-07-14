<?php

namespace App\Helpers;

class AspekHelper
{
    /**
     * Konversi bobot aspek dari database (skala 1-5) ke nilai input form.
     *
     * @param  array<string, float|int>  $aspekBobot  key = kode aspek (FISIK, ESTETIKA, ...)
     * @return array<string, int>
     */
    public static function convertBobotToInput(array $aspekBobot): array
    {
        return [
            'fisik'       => isset($aspekBobot['FISIK'])       ? (int) round($aspekBobot['FISIK'])       : 1,
            'estetika'    => isset($aspekBobot['ESTETIKA'])    ? (int) round($aspekBobot['ESTETIKA'])    : 1,
            'komunikasi'  => isset($aspekBobot['KOMUNIKASI'])  ? (int) round($aspekBobot['KOMUNIKASI'])  : 1,
            'kreativitas' => isset($aspekBobot['KREATIVITAS']) ? (int) round($aspekBobot['KREATIVITAS']) : 1,
            'disiplin'    => isset($aspekBobot['DISIPLIN'])    ? (int) round($aspekBobot['DISIPLIN'])    : 1,
            'kekompakan'  => isset($aspekBobot['KEKOMPAKAN'])  ? (int) round($aspekBobot['KEKOMPAKAN'])  : 1,
        ];
    }
}
