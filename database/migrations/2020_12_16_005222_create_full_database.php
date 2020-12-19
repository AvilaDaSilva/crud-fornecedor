<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFullDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->integer('id', 1)->autoIncrement();
            $table->string('nome_fantasia');
            $table->string('cnpj', 18);
            $table->string('uf', 2);
            $table->timestamps();
        });
        
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->integer('id', 1)->autoIncrement();
            $table->integer('empresa');
            $table->foreign('empresa')->references('id')->on('empresas');
            $table->string('nome');
            $table->boolean('tipo_pessoa');
            $table->date('data_nascimento')->nullable();
            $table->string('rg', 50)->nullable();
            $table->string('cpf_cnpj', 18);
            $table->date('data_cadastro');
            $table->timestamps();
        });

        Schema::create('fornecedor_telefones', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->integer('fornecedor');
            $table->foreign('fornecedor')->references('id')->on('fornecedores');
            $table->string('telefone', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
        Schema::dropIfExists('fornecedor');
        Schema::dropIfExists('fornecedor_telefone');
    }
}
