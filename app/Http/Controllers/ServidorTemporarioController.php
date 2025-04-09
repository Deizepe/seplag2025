<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use App\Models\ServidorTemporario;
use App\Models\Pessoa;
use App\Models\Endereco;
use App\Models\Cidade;
use App\Models\Lotacao;
use App\Models\Unidade;
use App\Http\Requests\StoreServidorEfetivoRequest;
use App\Http\Requests\UpdateServidorEfetivoRequest;
use App\Http\Requests\StoreServidorTemporarioRequest;
use App\Http\Requests\UpdateServidorTemporarioRequest;
use App\Http\Requests\StoreLotacaoRequest;
use App\Http\Requests\UpdateLotacaoRequest;
use Illuminate\Http\Request;

class ServidorTemporarioController extends Controller
{
    public function index(Request $request)
    {
        return ServidorTemporario::with('pessoa')->paginate($request->get('per_page', 10));
    }

    public function store(StoreServidorTemporarioRequest $request)
    {
        $cidade = Cidade::firstOrCreate($request->input('pessoa.endereco.cidade'));

        $endereco = Endereco::create(array_merge(
            $request->input('pessoa.endereco'),
            ['cid_id' => $cidade->cid_id]
        ));

        $pessoa = Pessoa::create($request->input('pessoa'));
        $pessoa->enderecos()->attach($endereco->end_id);

        $servidor = ServidorTemporario::create([
            'pes_id' => $pessoa->pes_id,
            'st_data_admissao' => $request->input('st_data_admissao'),
            'st_data_demissao' => $request->input('st_data_demissao')
        ]);

        return response()->json($servidor, 201);
    }

    public function update(UpdateServidorTemporarioRequest $request, $id)
    {
        $servidor = ServidorTemporario::findOrFail($id);

        if ($request->has('st_data_admissao') || $request->has('st_data_demissao')) {
            $servidor->update($request->only(['st_data_admissao', 'st_data_demissao']));
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

        return response()->json($servidor);
    }

    public function show($id)
    {
        return ServidorTemporario::with('pessoa')->findOrFail($id);
    }

    public function destroy($id)
    {
        ServidorTemporario::findOrFail($id)->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
