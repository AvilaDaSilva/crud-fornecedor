<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    /**
     * Tabela relacionada a essa model
     * @var string
     */
    protected $table = 'empresas';

    protected $fillable = [
        'nome_fantasia',
        'cnpj',
        'uf'
    ];
}
