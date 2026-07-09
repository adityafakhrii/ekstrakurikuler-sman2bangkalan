<?php

namespace App\Http\Requests\Admin;

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

        return [
            'nama_siswa' => ['required', 'string', 'max:255'],
            'nisn'       => [
                'required',
                'string',
                'max:20',
                Rule::unique('siswa', 'nisn')->ignore($siswaId),
            ],
            'no_hp'      => ['required', 'string', 'max:20'],
        ];
    }
}
