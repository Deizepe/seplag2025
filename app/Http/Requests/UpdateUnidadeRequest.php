<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unid_nome' => 'sometimes|string|max:200',
            'unid_sigla' => 'nullable|string|max:20',
            'endereco.end_tipo_logradouro' => 'sometimes|string|max:50',
            'endereco.end_logradouro' => 'sometimes|string|max:255',
            'endereco.end_numero' => 'sometimes|string|max:20',
            'endereco.end_bairro' => 'sometimes|string|max:100',
            'endereco.cidade.cid_nome' => 'sometimes|string|max:100',
            'endereco.cidade.cid_uf' => 'sometimes|string|size:2'
        ];
    }
}