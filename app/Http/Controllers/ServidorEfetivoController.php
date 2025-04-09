<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;

class ServidorEfetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));

     */


    public function efetivosPorUnidade($unid_id)
    {
        $servidores = ServidorEfetivo::with(['pessoa', 'lotacao.unidade', 'pessoa.foto'])
            ->whereHas('lotacao', fn($q) => $q->where('unid_id', $unid_id))
            ->paginate(10);

        return response()->json($servidores);
    }
    public function index()
    {
        return ServidorEfetivo::with('pessoa')->paginate(10);
    }

    public function store(StoreServidorEfetivoRequest $request)
    {
        $servidor = ServidorEfetivo::create($request->validated());
        return response()->json($servidor, 201);
    }

    public function show($id)
    {
        return ServidorEfetivo::with('pessoa')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $servidor = ServidorEfetivo::findOrFail($id);
        $servidor->update($request->only(['se_matricula']));
        return response()->json($servidor);
    }

    public function destroy($id)
    {
        ServidorEfetivo::findOrFail($id)->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
