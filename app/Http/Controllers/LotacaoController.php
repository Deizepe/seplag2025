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

class LotacaoController extends Controller
{
    public function index(Request $request)
    {
        return Lotacao::with(['pessoa', 'unidade.enderecos.cidade'])
            ->paginate($request->get('per_page', 10));
    }

    public function store(StoreLotacaoRequest $request)
    {
        $lotacao = Lotacao::create($request->validated());
        return response()->json($lotacao, 201);
    }

    public function show($id)
    {
        return Lotacao::with(['pessoa', 'unidade.enderecos.cidade'])->findOrFail($id);
    }

    public function update(UpdateLotacaoRequest $request, $id)
    {
        $lotacao = Lotacao::findOrFail($id);
        $lotacao->update($request->validated());
        return response()->json($lotacao);
    }

    public function destroy($id)
    {
        Lotacao::findOrFail($id)->delete();
        return response()->json(['message' => 'Lotação deletada com sucesso']);
    }
}