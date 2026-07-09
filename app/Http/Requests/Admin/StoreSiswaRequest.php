<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'nisn'       => ['required', 'string', 'max:20', 'unique:siswa,nisn', 'unique:users,nisn'],
            'no_hp'      => ['required', 'string', 'max:20'],
        ];
    }
}
