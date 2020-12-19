<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FornecedorTelefone extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'fornecedor_telefones';

    protected $fillable = [
        'fornecedor',
        'telefone'
    ];

    public function fornecedor() 
    {
        return $this->hasOne(Fornecedor::class, 'id');
    }
}
