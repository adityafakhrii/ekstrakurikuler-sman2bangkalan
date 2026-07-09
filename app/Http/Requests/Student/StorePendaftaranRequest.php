<?php

namespace App\Http\Requests\Student;

use App\Models\Pendaftaran;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSiswa() ?? false;
    }

    public function rules(): array
    {
        return [
            'catatan_siswa' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $siswa = $this->user()?->siswa;

            if (! $siswa) {
                $validator->errors()->add('nisn', 'Data siswa tidak ditemukan. Silakan hubungi admin.');
                return;
            }

            // Max 2 pendaftaran aktif (menunggu/disetujui)
            $activeCount = Pendaftaran::where('siswa_id', $siswa->id)
                ->whereIn('status', ['menunggu', 'disetujui'])
                ->count();

            if ($activeCount >= 2) {
                $validator->errors()->add('ekstrakurikuler', 'Siswa hanya dapat mendaftar maksimal 2 ekstrakurikuler.');
            }

            // Cek duplikat per ekskul
            $ekskulId = $this->route('id');
            $duplicate = Pendaftaran::where('siswa_id', $siswa->id)
                ->where('ekstrakurikuler_id', $ekskulId)
                ->exists();

            if ($duplicate) {
                $validator->errors()->add('ekstrakurikuler', 'Siswa sudah pernah mendaftar pada ekstrakurikuler ini.');
            }
        });
    }
}
