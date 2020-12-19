@extends('layouts.app')

@section('content')

    <div class="panel-body">

        <h4>Formulário de Cadastro de Fornecedor</h4>
        <hr>

        <form action="{{ isset($telefoneEdit) ? route('alterar_telefone',  ['id' => $telefoneEdit->id]) : route('cadastrar_telefone') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            {{ isset($telefoneEdit) ? method_field('PUT') : method_field('POST') }}

            <div class="form-group row">

                <div class="col-sm-6 campo-formulario">
                    <label class="col-sm-12">Fornecedor</label>
                    <div class="col-sm-12">
                        <select name="fornecedor" id="fornecedor" class="form-control">
                            <option value="">Selecione um Fornecedor</option>
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}" {{ isset($telefoneEdit) && $telefoneEdit->fornecedor == $fornecedor->id ? 'selected="selected"' : '' }}>{{ $fornecedor->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-6 campo-formulario">
                    <label class="col-sm-12">Telefone</label>
                    <div class="col-sm-12">
                        <input type="text" name="telefone" id="telefone" class="form-control" value="{{ isset($telefoneEdit) ? $telefoneEdit->telefone : '' }}">
                    </div>
                </div>

            </div>

            <div class="row col-sm-12">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">{{ isset($telefoneEdit) ? 'Atualizar' : 'Salvar' }}</button>
                </div>
            </div>
        </form>
    </div>

    <h4 style="margin-top: 30px">Lista de Telefones dos Fornecedores</h4>
    <hr>

    @if (count($telefones) > 0)

        <div class="panel panel-default">
            <div class="panel-heading">
                Telefones dos Fornecedores Cadastrados
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                        <th>#</th>
                        <th>Fornecedor</th>
                        <th>Telefone</th>
                        <th class="action-button">&nbsp;</th>
                        <th class="action-button">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($telefones as $telefone)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $telefone->id }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $telefone->nome_fornecedor }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $telefone->telefone }}</div>
                                </td>
                                <td>
                                    <form action="{{ url('telefones-fornecedor/'.$telefone->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('GET') }}

                                        <button type="submit" class="btn btn-link">
                                            <i class="fa fa-trash"></i> Editar
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ url('telefones-fornecedor/'.$telefone->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-link">
                                            <i class="fa fa-trash"></i> Remover
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @if (count($telefones) == 0)
        <h4>Nenhum resultado encontrado!</h4>
    @endif

    <script>
        $('document').ready(function() {
            $('#telefone').mask("(99) 9999-99999");
        });
    </script>
@endsection