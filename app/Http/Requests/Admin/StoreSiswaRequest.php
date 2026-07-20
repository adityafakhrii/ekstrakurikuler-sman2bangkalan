<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_siswa' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:20', 'unique:siswa,nis'],
            'no_hp' => ['required', 'string', 'max:20'],
            'kelas' => ['required', 'in:X,XI,XII'],
            'jurusan' => ['required', 'string', 'max:50'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tahun_masuk' => ['required', 'integer', 'min:2000', 'max:2100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nis.unique' => 'Mohon maaf, nomor NIS tersebut sudah terdaftar untuk siswa lain di sistem. Silakan periksa kembali nomor NIS yang dimasukkan.',
        ];
    }
}
