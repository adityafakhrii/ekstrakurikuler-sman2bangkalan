<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEkskulRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:ekstrakurikuler,nama'],
            'pembina' => ['required', 'string', 'max:255'],
            'jadwal' => ['required', 'string', 'max:255'],
            'whatsapp_group' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
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
            'name.unique' => 'Mohon maaf, ekstrakurikuler dengan nama tersebut sudah terdaftar di sistem. Silakan periksa kembali daftar ekskul atau gunakan nama lain yang berbeda.',
            'logo.image' => 'File yang diunggah harus berupa gambar ekstrakurikuler.',
            'logo.mimes' => 'Gambar ekstrakurikuler harus berformat JPG, JPEG, PNG, GIF, atau WebP.',
            'logo.max' => 'Ukuran gambar ekstrakurikuler maksimal 10 MB. Sistem akan mengompresnya otomatis menjadi WebP setelah diunggah.',
        ];
    }
}
