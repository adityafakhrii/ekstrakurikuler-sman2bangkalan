<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Kompres gambar ke format WebP dan kembalikan statistik kompresi.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $quality
     * @return array{path: string, original_size_formatted: string, compressed_size_formatted: string, percentage: float}
     */
    public static function convertToWebp(UploadedFile $file, string $directory, int $quality = 80): array
    {
        $originalSize = $file->getSize(); // dalam bytes
        $tempPath = $file->getRealPath();
        
        // Dapatkan gambar GD berdasarkan tipe mime
        $image = match ($file->getClientMimeType()) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($tempPath),
            'image/png' => imagecreatefrompng($tempPath),
            'image/gif' => imagecreatefromgif($tempPath),
            'image/webp' => imagecreatefromwebp($tempPath),
            default => throw new \InvalidArgumentException('Format gambar tidak didukung. Harap unggah format JPEG, PNG, GIF, atau WebP.'),
        };

        if (!$image) {
            throw new \Exception('Gagal membaca data gambar.');
        }

        // Jika PNG atau GIF, pertahankan transparansi
        if ($file->getClientMimeType() === 'image/png' || $file->getClientMimeType() === 'image/gif') {
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        // Buat nama file dari nama asli dengan ekstensi .webp
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // Sanitize nama file: hilangkan karakter non-alphanumeric kecuali dash/underscore
        $sanitized = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $originalName);
        $sanitized = trim($sanitized, '_');
        // Tambahkan suffix acak pendek untuk menghindari nama duplikat
        $filename = $sanitized . '_' . Str::random(8) . '.webp';
        
        // Dapatkan path penyimpanan lokal sementara
        $tempOutPath = tempnam(sys_get_temp_dir(), 'webp_');
        
        // Simpan sebagai WebP ke path sementara
        if (!imagewebp($image, $tempOutPath, $quality)) {
            imagedestroy($image);
            throw new \Exception('Gagal melakukan kompresi gambar ke WebP.');
        }
        
        imagedestroy($image);

        // Baca file hasil kompresi
        $compressedSize = filesize($tempOutPath);
        
        // Simpan ke storage disk public
        $storedPath = Storage::disk('public')->putFileAs($directory, new \Illuminate\Http\File($tempOutPath), $filename);
        
        // Hapus file sementara
        @unlink($tempOutPath);

        // Format ukuran file
        $origFormatted = self::formatSize($originalSize);
        $compFormatted = self::formatSize($compressedSize);
        
        // Hitung persentase pengurangan
        $reductionPercentage = $originalSize > 0 
            ? round((($originalSize - $compressedSize) / $originalSize) * 100, 1)
            : 0;

        return [
            'path' => $storedPath,
            'original_size_formatted' => $origFormatted,
            'compressed_size_formatted' => $compFormatted,
            'percentage' => $reductionPercentage,
        ];
    }

    /**
     * Format ukuran file ke format yang mudah dibaca (MB/KB).
     */
    private static function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }
        return round($bytes / 1024, 2) . ' KB';
    }
}
