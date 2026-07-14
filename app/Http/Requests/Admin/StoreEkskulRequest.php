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
            'name' => ['required', 'string', 'max:255'],
            'pembina' => ['required', 'string', 'max:255'],
            'jadwal' => ['required', 'string', 'max:255'],
            'whatsapp_group' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'fisik' => ['required', 'integer', 'between:1,5'],
            'estetika' => ['required', 'integer', 'between:1,5'],
            'komunikasi' => ['required', 'integer', 'between:1,5'],
            'kreativitas' => ['required', 'integer', 'between:1,5'],
            'disiplin' => ['required', 'integer', 'between:1,5'],
            'kekompakan' => ['required', 'integer', 'between:1,5'],
        ];
    }
}
