<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use App\Models\Pessoa;
use App\Models\Endereco;
use App\Models\Cidade;
use App\Models\Lotacao;
use App\Models\Unidade;
use App\Http\Requests\StoreServidorEfetivoRequest;
use App\Http\Requests\UpdateServidorEfetivoRequest;
use Illuminate\Http\Request;

class ServidorEfetivoController extends Controller
{
    public function index(Request $request)
    {
        return ServidorEfetivo::with('pessoa.foto', 'lotacao.unidade')->paginate($request->get('per_page', 10));
    }

    public function store(StoreServidorEfetivoRequest $request)
    {
        // Salvar cidade
        $cidade = Cidade::firstOrCreate($request->input('pessoa.endereco.cidade'));

        // Salvar endereco
        $endereco = Endereco::create(array_merge(
            $request->input('pessoa.endereco'),
            ['cid_id' => $cidade->cid_id]
        ));

        // Salvar pessoa
        $pessoa = Pessoa::create($request->input('pessoa'));
        $pessoa->enderecos()->attach($endereco->end_id);

        // Salvar servidor efetivo
        $servidor = ServidorEfetivo::create([
            'pes_id' => $pessoa->pes_id,
            'se_matricula' => $request->input('se_matricula')
        ]);

        // Salvar lotacao
        $lotacaoData = $request->input('lotacao');
        $lotacaoData['pes_id'] = $pessoa->pes_id;
        Lotacao::create($lotacaoData);

        return response()->json($servidor, 201);
    }

    public function update(UpdateServidorEfetivoRequest $request, $id)
    {
        $servidor = ServidorEfetivo::findOrFail($id);

        if ($request->has('se_matricula')) {
            $servidor->update(['se_matricula' => $request->se_matricula]);
        }

        if ($request->has('pessoa')) {
            $pessoa = $servidor->pessoa;
            $pessoa->update($request->input('pessoa'));

            if ($request->has('pessoa.endereco')) {
                $cidade = Cidade::firstOrCreate($request->input('pessoa.endereco.cidade'));

                $endereco = $pessoa->enderecos->first();
                $endereco->update(array_merge(
                    $request->input('pessoa.endereco'),
                    ['cid_id' => $cidade->cid_id]
                ));
            }
        }

        if ($request->has('lotacao')) {
            $lotacao = $servidor->lotacao;
            $lotacao->update($request->lotacao);
        }

        return response()->json($servidor);
    }

    public function show($id)
    {
        return ServidorEfetivo::with('pessoa.foto', 'lotacao.unidade')->findOrFail($id);
    }

    public function destroy($id)
    {
        ServidorEfetivo::findOrFail($id)->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
