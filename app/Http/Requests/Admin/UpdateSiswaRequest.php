<?php

namespace App\Http\Requests\Admin;

use App\Models\Siswa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $siswaId = $this->route('id');
        $siswa = Siswa::find($siswaId);
        $userId = $siswa ? $siswa->user_id : null;

        return [
            'nama_siswa' => ['required', 'string', 'max:255'],
            'nis' => [
                'required',
                'string',
                'max:20',
                Rule::unique('siswa', 'nis')->ignore($siswaId),
            ],
            'nisn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('siswa', 'nisn')->ignore($siswaId),
            ],
            'no_hp' => ['required', 'string', 'max:20'],
            'kelas' => ['required', 'in:X,XI,XII'],
            'rombel' => ['required', 'string', 'max:50'],
            'jurusan' => ['required', 'string', 'max:50'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tahun_masuk' => ['required', 'integer', 'min:2000', 'max:2100'],
        ];
    }
}
