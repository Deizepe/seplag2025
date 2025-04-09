<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ServidorEfetivo extends Model
{
    protected $primaryKey = 'se_id';
    protected $fillable = ['pes_id', 'se_matricula'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }

    public function lotacao()
    {
        return $this->hasOne(Lotacao::class, 'pes_id', 'pes_id');
    }
} 
