<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServidorTemporarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'st_data_admissao' => 'nullable|date',
            'st_data_demissao' => 'nullable|date|after_or_equal:st_data_admissao',
            'pessoa.pes_nome' => 'sometimes|string|max:200',
            'pessoa.pes_data_nascimento' => 'nullable|date',
            'pessoa.pes_sexo' => 'nullable|string|max:9',
            'pessoa.pes_mae' => 'nullable|string|max:200',
            'pessoa.pes_pai' => 'nullable|string|max:200',
            'pessoa.endereco.end_tipo_logradouro' => 'sometimes|string|max:50',
            'pessoa.endereco.end_logradouro' => 'sometimes|string|max:255',
            'pessoa.endereco.end_numero' => 'sometimes|string|max:20',
            'pessoa.endereco.end_bairro' => 'sometimes|string|max:100',
            'pessoa.endereco.cidade.cid_nome' => 'sometimes|string|max:100',
            'pessoa.endereco.cidade.cid_uf' => 'sometimes|string|size:2'
        ];
    }
}
