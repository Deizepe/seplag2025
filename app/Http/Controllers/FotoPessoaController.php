<?php

namespace App\Http\Controllers;


use App\Models\ServidorEfetivo;
use App\Models\ServidorTemporario;
use App\Models\Pessoa;
use App\Models\Endereco;
use App\Models\Cidade;
use App\Models\Lotacao;
use App\Models\Unidade;
use App\Models\FotoPessoa;
use App\Http\Requests\StoreServidorEfetivoRequest;
use App\Http\Requests\UpdateServidorEfetivoRequest;
use App\Http\Requests\StoreServidorTemporarioRequest;
use App\Http\Requests\UpdateServidorTemporarioRequest;
use App\Http\Requests\StoreLotacaoRequest;
use App\Http\Requests\UpdateLotacaoRequest;
use App\Http\Requests\StoreUnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FotoPessoaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'foto.*' => 'required|image|max:2048'
        ]);

        $urls = [];

        foreach ($request->file('foto') as $arquivo) {
            $path = $arquivo->store('fotos', 's3');

            FotoPessoa::create([
                'pes_id' => $request->pes_id,
                'fp_data' => now(),
                'fp_bucket' => $path,
                'fp_hash' => md5_file($arquivo),
            ]);

            $urls[] = Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));
        }

        return response()->json(['fotos' => $urls]);
    }
}