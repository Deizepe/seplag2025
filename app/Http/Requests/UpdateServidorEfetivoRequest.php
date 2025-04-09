<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdateServidorEfetivoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'se_matricula' => 'sometimes|string|max:20|unique:servidor_efetivos,se_matricula,' . $this->route('servidorefetivo'),
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
            'pessoa.endereco.cidade.cid_uf' => 'sometimes|string|size:2',
            'lotacao.unid_id' => 'sometimes|exists:unidades,unid_id',
            'lotacao.lot_data_lotacao' => 'nullable|date',
            'lotacao.lot_data_remocao' => 'nullable|date|after_or_equal:lot_data_lotacao',
            'lotacao.lot_portaria' => 'nullable|string|max:100'
        ];
    }
}
