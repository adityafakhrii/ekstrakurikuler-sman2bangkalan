<?php

namespace App\Http\Requests\Student;

use App\Models\Pendaftaran;
use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSiswa() ?? false;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'kelas_jurusan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($userId)],
            'no_whatsapp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:255'],
            'catatan_siswa' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Maaf, alamat email tersebut sudah terdaftar di sistem untuk siswa lain. Silakan gunakan alamat email yang berbeda.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $siswa = $this->user()?->siswa;

            if (! $siswa) {
                $validator->errors()->add('nis', 'Data siswa tidak ditemukan. Silakan hubungi admin.');

                return;
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
