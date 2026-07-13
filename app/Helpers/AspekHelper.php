<?php

namespace App\Helpers;

class AspekHelper
{
    /**
     * Konversi bobot aspek dari database (skala 0-100) ke nilai input form (skala 1-5).
     *
     * @param  array<string, float|int>  $aspekBobot
     * @return array<string, int>
     */
    public static function convertBobotToInput(array $aspekBobot): array
    {
        return [
            'fisik' => isset($aspekBobot['FISIK']) ? (int) round($aspekBobot['FISIK'] / 20) : 1,
            'intelektual' => isset($aspekBobot['AKADEMIK']) ? (int) round($aspekBobot['AKADEMIK'] / 20) : 1,
            'kreativitas' => isset($aspekBobot['SENI']) ? (int) round($aspekBobot['SENI'] / 20) : 1,
            'sosial' => isset($aspekBobot['SOSIAL']) ? (int) round($aspekBobot['SOSIAL'] / 20) : 1,
            'mental' => isset($aspekBobot['SOSIAL_HUMANIORA']) ? (int) round($aspekBobot['SOSIAL_HUMANIORA'] / 20) : 1,
            'komunikasi' => isset($aspekBobot['BAHASA']) ? (int) round($aspekBobot['BAHASA'] / 20) : 1,
        ];
    }
}
