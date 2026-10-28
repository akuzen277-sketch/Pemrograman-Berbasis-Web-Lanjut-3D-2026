<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules() {
        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|min:3|max:150',
            'penulis' => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,2026',
        ];
    }

    public function attributes() {
        return ['kategori_id' => 'kategori', 'tahun_terbit' => 'tahun terbit'];
    }

    public function messages() {
        return [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'between' => ':attribute harus antara :min sampai :max.',
            'exists' => ':attribute yang dipilih tidak valid.'
        ];
    }
}