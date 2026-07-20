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
            'ketangkasan' => isset($aspekBobot['KETANGKASAN']) ? (int) round($aspekBobot['KETANGKASAN']) : 1,
            'intelektual' => isset($aspekBobot['INTELEKTUAL']) ? (int) round($aspekBobot['INTELEKTUAL']) : 1,
            'sosial'      => isset($aspekBobot['SOSIAL'])      ? (int) round($aspekBobot['SOSIAL'])      : 1,
            'kreativitas' => isset($aspekBobot['KREATIVITAS']) ? (int) round($aspekBobot['KREATIVITAS']) : 1,
            'kedisiplinan'=> isset($aspekBobot['KEDISIPLINAN']) ? (int) round($aspekBobot['KEDISIPLINAN']) : 1,
            'komunikasi'  => isset($aspekBobot['KOMUNIKASI'])  ? (int) round($aspekBobot['KOMUNIKASI'])  : 1,
        ];
    }
}
