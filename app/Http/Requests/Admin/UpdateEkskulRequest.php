<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEkskulRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ekstrakurikuler', 'nama')->ignore($this->route('id'))
            ],
            'pembina' => ['required', 'string', 'max:255'],
            'jadwal' => ['required', 'string', 'max:255'],
            'whatsapp_group' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'ketangkasan' => ['required', 'integer', 'between:1,5'],
            'intelektual' => ['required', 'integer', 'between:1,5'],
            'sosial' => ['required', 'integer', 'between:1,5'],
            'kreativitas' => ['required', 'integer', 'between:1,5'],
            'kedisiplinan' => ['required', 'integer', 'between:1,5'],
            'komunikasi' => ['required', 'integer', 'between:1,5'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Mohon maaf, nama ekstrakurikuler tersebut sudah digunakan oleh ekskul lain. Silakan periksa kembali daftar ekskul atau pilih nama lain.',
            'logo.image' => 'File yang diunggah harus berupa gambar ekstrakurikuler.',
            'logo.mimes' => 'Gambar ekstrakurikuler harus berformat JPG, JPEG, PNG, GIF, atau WebP.',
            'logo.max' => 'Ukuran gambar ekstrakurikuler maksimal 5 MB. Sistem akan mengompresnya otomatis menjadi WebP jika extension GD aktif.',
        ];
    }
}
