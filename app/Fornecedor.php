<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'fornecedores';

    protected $fillable = [
        'empresa',
        'nome',
        'tipo_pessoa',
        'data_nascimento',
        'rg',
        'cpf_cnpj',
        'data_cadastro'
    ];

    public function empresa() 
    {
        return $this->belongsTo(Empresa::class, 'id');
    }
}
