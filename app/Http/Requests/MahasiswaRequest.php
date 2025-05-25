<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
                'nama' => 'bail|required|unique:mahasiswa|max:250',
                'nim' => 'required|unique:mahasiswa|max:10',
                'email' => 'required|unique:mahasiswa|max:100'
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'nama' => 'sometimes|required|unique:mahasiswa|max:250',
                'nim' => 'sometimes|required|unique:mahasiswa|max:10',
                'email' => 'sometimes|required|unique:mahasiswa|max:100'
            ];
        }
        return [];
    }
}
