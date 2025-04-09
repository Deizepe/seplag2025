<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreServidorEfetivoRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'pes_id' => 'required|exists:pessoa,pes_id',
            'se_matricula' => 'required|string|unique:servidor_efetivos,se_matricula|max:20',
        ];
    }
}