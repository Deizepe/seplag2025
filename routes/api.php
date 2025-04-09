<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ServidorEfetivoController,
    ServidorTemporarioController,
    UnidadeController,
    LotacaoController,
    FotoPessoaController
};

// Health check
Route::get('/ping', fn () => ['pong' => true]);

// Token refresh
Route::middleware('auth:sanctum')->post('/refresh-token', [AuthController::class, 'refresh']);

Route::middleware(['auth:sanctum', 'token.expire'])->group(function () {
    // CRUDs principais
    Route::apiResource('servidores', ServidorEfetivoController::class);
    Route::apiResource('temporarios', ServidorTemporarioController::class);
    Route::apiResource('unidades', UnidadeController::class);
    Route::apiResource('lotacoes', LotacaoController::class);

    // Endpoints especiais
    Route::get('servidores-por-unidade/{unid_id}', [ServidorEfetivoController::class, 'efetivosPorUnidade']);
    Route::get('endereco-funcional', [ServidorEfetivoController::class, 'enderecoFuncional']);
    Route::post('fotos', [FotoPessoaController::class, 'upload']);
});
