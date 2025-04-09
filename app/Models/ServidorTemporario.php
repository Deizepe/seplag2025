<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServidorTemporario extends Model
{
    protected $primaryKey = 'st_id';
    protected $fillable = ['pes_id', 'st_data_admissao', 'st_data_demissao'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }
} 