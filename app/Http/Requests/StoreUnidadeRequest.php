<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unid_nome' => 'required|string|max:200',
            'unid_sigla' => 'nullable|string|max:20',
            'endereco.end_tipo_logradouro' => 'required|string|max:50',
            'endereco.end_logradouro' => 'required|string|max:255',
            'endereco.end_numero' => 'required|string|max:20',
            'endereco.end_bairro' => 'required|string|max:100',
            'endereco.cidade.cid_nome' => 'required|string|max:100',
            'endereco.cidade.cid_uf' => 'required|string|size:2'
        ];
    }
}