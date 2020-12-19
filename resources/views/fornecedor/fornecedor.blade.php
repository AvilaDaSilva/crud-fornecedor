@extends('layouts.app')

@section('content')

    <div class="panel-body">

        <h4>Formulário de Cadastro de Fornecedor</h4>
        <hr>

        <form action="{{ isset($fornecedorEdit) ? route('alterar_fornecedor',  ['id' => $fornecedorEdit->id]) : route('cadastrar_fornecedor') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            {{ isset($fornecedorEdit) ? method_field('PUT') : method_field('POST') }}

            <div class="form-group row">

                <div class="col-sm-12 campo-formulario">
                    <label class="col-sm-12">Empresa</label>
                    <div class="col-sm-12">
                        <select name="empresa" id="empresa" class="form-control">
                            <option value="">Selecione uma empresa</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id }}" {{ isset($fornecedorEdit) && $fornecedorEdit->empresa == $empresa->id ? 'selected="selected"' : '' }}>{{ $empresa->nome_fantasia }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-9 campo-formulario">
                    <label class="col-sm-12">Nome</label>
                    <div class="col-sm-12">
                        <input type="text" name="nome" id="nome" class="form-control" value="{{ isset($fornecedorEdit) ? $fornecedorEdit->nome : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-3 campo-formulario">
                    <label class="col-sm-12">Data de Nascimento</label>
                    <div class="col-sm-12">
                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" value="{{ isset($fornecedorEdit) ? $fornecedorEdit->data_nascimento : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-4 campo-formulario">
                    <label class="col-sm-12">Tipo Pessoa</label>
                    <div class="col-sm-12">
                        <select name="tipo_pessoa" id="tipo_pessoa" class="form-control">
                            <option value="">Selecione um tipo de pessoa</option>
                            <option value="0" {{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == '0' ? 'selected="selected"' : '' }}>Pessoa Física</option>
                            <option value="1" {{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == '1' ? 'selected="selected"' : '' }}>Pessoa Juridica</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-4 campo-formulario" id="campo_rg">
                    <label class="col-sm-12">RG</label>
                    <div class="col-sm-12">
                        <input type="text" name="rg" id="rg" class="form-control" value="{{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == 0 ? $fornecedorEdit->rg : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-4 campo-formulario" id="campo_cpf">
                    <label class="col-sm-12">CPF</label>
                    <div class="col-sm-12">
                        <input type="text" name="cpf" id="cpf" class="form-control" value="{{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == 0 ? $fornecedorEdit->cpf_cnpj : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-8 campo-formulario" id="campo_cnpj">
                    <label class="col-sm-12">CNPJ</label>
                    <div class="col-sm-12">
                        <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == 1 ? $fornecedorEdit->cpf_cnpj : '' }}">
                    </div>
                </div>
            </div>

            <div class="row col-sm-12">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">{{ isset($fornecedorEdit) ? 'Atualizar' : 'Salvar' }}</button>
                </div>
            </div>
        </form>
    </div>

    <h4 style="margin-top: 30px">Lista de Fornecedores</h4>
    <hr>

    <div class="panel-body row">
        <form id="consultar_fornecedor" action="{{ route('cadastrar_fornecedor') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            {{ method_field('GET') }}

            <div class="form-group row">

                <div class="col-sm-4">
                    <label class="col-sm-12">Nome</label>
                    <div class="col-sm-12">
                        <input type="text" name="consulta_nome" id="consulta_nome" class="form-control" value="{{ isset($dadosConsulta) ? $dadosConsulta->consulta_nome : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <label class="col-sm-12">CPF/CNPJ</label>
                    <div class="col-sm-12">
                        <input type="text" name="consulta_cpf_cnpj" id="consulta_cpf_cnpj" class="form-control" value="{{ isset($dadosConsulta) ? $dadosConsulta->consulta_cpf_cnpj : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <label class="col-sm-12">Data de Cadastro</label>
                    <div class="col-sm-12">
                        <input type="text" name="consulta_data_cadastro" id="consulta_data_cadastro" class="form-control" value="{{ isset($dadosConsulta) ? $dadosConsulta->consulta_data_cadastro : '' }}">
                    </div>
                </div>
            </div>

            <div class="row col-sm-12">
                <div class="col-sm-12">
                    <button id="consultar" type="submit" class="btn btn-info">Consultar</button>
                    <button onclick="limparFormulario()" type="button" class="btn btn-light">Limpar Consulta</button>
                </div>
            </div>

        </form>
    </div>

    @if (count($fornecedores) > 0)

        <div class="panel panel-default">
            <div class="panel-heading">
                Fornecedores Cadastrados
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                        <th>#</th>
                        <th>Empresa</th>
                        <th>Nome</th>
                        <th>Tipo Pessoa</th>
                        <th>CNPJ/CPF</th>
                        <th>Data Cadastro</th>
                        <th class="action-button">&nbsp;</th>
                        <th class="action-button">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($fornecedores as $fornecedor)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $fornecedor->id }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $fornecedor->nome_empresa }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $fornecedor->nome }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $fornecedor->tipo_pessoa == '1' ? 'Pessoa Jurídica' : 'Pessoa Física' }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $fornecedor->cpf_cnpj }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $fornecedor->data_cadastro }}</div>
                                </td>
                                <td>
                                    <form action="{{ url('fornecedores/'.$fornecedor->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('GET') }}

                                        <button type="submit" class="btn btn-link">
                                            <i class="fa fa-trash"></i> Editar
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ url('fornecedores/'.$fornecedor->id) }}" method="POST">
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
    @if (count($fornecedores) == 0)
        <h4>Nenhum resultado encontrado!</h4>
    @endif

    <script>
        $('document').ready(function() {
            //formulario de cadastro
            $('#campo_rg').toggle({{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == 0 ? 'true' : 'false' }});
            $('#campo_cpf').toggle({{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == 0 ? 'true' : 'false' }});
            $('#campo_cnpj').toggle({{ isset($fornecedorEdit) && $fornecedorEdit->tipo_pessoa == 1 ? 'true' : 'false' }});
            $('#cpf').mask('999.999.999-99');
            $('#cnpj').mask('99.999.999/9999-99');
            $('#data_nascimento').mask('99/99/9999');

            //formulario de consulta
            $('#consulta_data_cadastro').mask('99/99/9999');
            $("#consulta_cpf_cnpj").keydown(function(){
                try {
                    $("#consulta_cpf_cnpj").unmask();
                } catch (e) {}

                var tamanho = $("#consulta_cpf_cnpj").val().length;

                if (tamanho < 11) {
                    $("#consulta_cpf_cnpj").mask("999.999.999-99");
                } else {
                    $("#consulta_cpf_cnpj").mask("99.999.999/9999-99");
                }

                // ajustando foco
                var elem = this;
                setTimeout(function() {
                    // mudo a posição do seletor
                    elem.selectionStart = elem.selectionEnd = 10000;
                }, 0);
                // reaplico o valor para mudar o foco
                var currentValue = $(this).val();
                $(this).val('');
                $(this).val(currentValue);
            });

        });

        $('#tipo_pessoa').on('change', function() {

            if ($('#tipo_pessoa').val() == '1') {
                $('#campo_rg').toggle(false);
                $('#campo_cpf').toggle(false);
                $('#campo_cnpj').toggle(true);

            } else if ($('#tipo_pessoa').val() == '0') {
                $('#campo_rg').toggle(true);
                $('#campo_cpf').toggle(true);
                $('#campo_cnpj').toggle(false);

            } else {
                $('#campo_rg').toggle(false);
                $('#campo_cpf').toggle(false);
                $('#campo_cnpj').toggle(false);
            }
        });

        function limparFormulario() {
            
            $("#consulta_nome").val("");
            $("#consulta_cpf_cnpj").val("");
            $("#consulta_data_cadastro").val("");
            $("#consultar").click();
        }
    </script>
@endsection