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
use App\Http\Requests\StoreUnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function index(Request $request)
    {
        return Unidade::with('enderecos.cidade')->paginate($request->get('per_page', 10));
    }

    public function store(StoreUnidadeRequest $request)
    {
        $cidade = Cidade::firstOrCreate($request->input('endereco.cidade'));

        $endereco = Endereco::create(array_merge(
            $request->input('endereco'),
            ['cid_id' => $cidade->cid_id]
        ));

        $unidade = Unidade::create($request->only(['unid_nome', 'unid_sigla']));
        $unidade->enderecos()->attach($endereco->end_id);

        return response()->json($unidade, 201);
    }

    public function update(UpdateUnidadeRequest $request, $id)
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->update($request->only(['unid_nome', 'unid_sigla']));

        if ($request->has('endereco')) {
            $cidade = Cidade::firstOrCreate($request->input('endereco.cidade'));

            $endereco = $unidade->enderecos->first();
            $endereco->update(array_merge(
                $request->input('endereco'),
                ['cid_id' => $cidade->cid_id]
            ));
        }

        return response()->json($unidade);
    }

    public function show($id)
    {
        return Unidade::with('enderecos.cidade')->findOrFail($id);
    }

    public function destroy($id)
    {
        Unidade::findOrFail($id)->delete();
        return response()->json(['message' => 'Unidade deletada com sucesso']);
    }
}