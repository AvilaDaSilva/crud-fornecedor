@extends('layouts.app')

@section('content')

    <div class="panel-body">

        <h4>Formulário de Cadastro de Empresa</h4>
        <hr>

        <form action="{{ isset($empresaEdit) ? route('alterar_empresa',  ['id' => $empresaEdit->id]) : route('cadastrar_empresa') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            {{ isset($empresaEdit) ? method_field('PUT') : method_field('POST') }}

            <div class="form-group row">

                <div class="col-sm-12 campo-formulario">
                    <label class="col-sm-12">Nome Fantasia</label>
                    <div class="col-sm-12">
                        <input type="text" name="nome_fantasia" id="nome_fantasia" class="form-control" value="{{ isset($empresaEdit) ? $empresaEdit->nome_fantasia : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-6 campo-formulario">
                    <label class="col-sm-12">CNPJ</label>
                    <div class="col-sm-12">
                        <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{ isset($empresaEdit) ? $empresaEdit->cnpj : '' }}">
                    </div>
                </div>
                
                <div class="col-sm-6 campo-formulario">
                    <label class="col-sm-12">UF</label>
                    <div class="col-sm-12">
                        <select name="uf" id="uf" class="form-control">
                            <option value="">Selecione um estado</option>
                            <option value="AC" {{ isset($empresaEdit) && $empresaEdit->uf == 'AC' ? 'selected="selected"' : '' }}>AC - Acre</option>
                            <option value="AL" {{ isset($empresaEdit) && $empresaEdit->uf == 'AL' ? 'selected="selected"' : '' }}>AL - Alagoas</option>
                            <option value="AP" {{ isset($empresaEdit) && $empresaEdit->uf == 'AP' ? 'selected="selected"' : '' }}>AP - Amapá</option>
                            <option value="AM" {{ isset($empresaEdit) && $empresaEdit->uf == 'AM' ? 'selected="selected"' : '' }}>AM - Amazonas</option>
                            <option value="BA" {{ isset($empresaEdit) && $empresaEdit->uf == 'BA' ? 'selected="selected"' : '' }}>BA - Bahia</option>
                            <option value="CE" {{ isset($empresaEdit) && $empresaEdit->uf == 'CE' ? 'selected="selected"' : '' }}>CE - Ceará</option>
                            <option value="ES" {{ isset($empresaEdit) && $empresaEdit->uf == 'ES' ? 'selected="selected"' : '' }}>ES - Espírito Santo</option>
                            <option value="GO" {{ isset($empresaEdit) && $empresaEdit->uf == 'GO' ? 'selected="selected"' : '' }}>GO - Goiás</option>
                            <option value="MA" {{ isset($empresaEdit) && $empresaEdit->uf == 'MA' ? 'selected="selected"' : '' }}>MA - Maranhão</option>
                            <option value="MT" {{ isset($empresaEdit) && $empresaEdit->uf == 'MT' ? 'selected="selected"' : '' }}>MT - Mato Grosso</option>
                            <option value="MS" {{ isset($empresaEdit) && $empresaEdit->uf == 'MS' ? 'selected="selected"' : '' }}>MS - Mato Grosso do Sul</option>
                            <option value="MG" {{ isset($empresaEdit) && $empresaEdit->uf == 'MG' ? 'selected="selected"' : '' }}>MG - Minas Gerais</option>
                            <option value="PA" {{ isset($empresaEdit) && $empresaEdit->uf == 'PA' ? 'selected="selected"' : '' }}>PA - Pará</option>
                            <option value="PB" {{ isset($empresaEdit) && $empresaEdit->uf == 'PB' ? 'selected="selected"' : '' }}>PB - Paraíba</option>
                            <option value="PR" {{ isset($empresaEdit) && $empresaEdit->uf == 'PR' ? 'selected="selected"' : '' }}>PR - Paraná</option>
                            <option value="PE" {{ isset($empresaEdit) && $empresaEdit->uf == 'PE' ? 'selected="selected"' : '' }}>PE - Pernambuco</option>
                            <option value="PI" {{ isset($empresaEdit) && $empresaEdit->uf == 'PI' ? 'selected="selected"' : '' }}>PI - Piauí</option>
                            <option value="RJ" {{ isset($empresaEdit) && $empresaEdit->uf == 'RJ' ? 'selected="selected"' : '' }}>RJ - Rio de Janeiro</option>
                            <option value="RN" {{ isset($empresaEdit) && $empresaEdit->uf == 'RN' ? 'selected="selected"' : '' }}>RN - Rio Grande do Norte</option>
                            <option value="RS" {{ isset($empresaEdit) && $empresaEdit->uf == 'RS' ? 'selected="selected"' : '' }}>RS - Rio Grande do Sul</option>
                            <option value="RO" {{ isset($empresaEdit) && $empresaEdit->uf == 'RO' ? 'selected="selected"' : '' }}>RO - Rondônia</option>
                            <option value="RR" {{ isset($empresaEdit) && $empresaEdit->uf == 'RR' ? 'selected="selected"' : '' }}>RR - Roraima</option>
                            <option value="SC" {{ isset($empresaEdit) && $empresaEdit->uf == 'SC' ? 'selected="selected"' : '' }}>SC - Santa Catarina</option>
                            <option value="SP" {{ isset($empresaEdit) && $empresaEdit->uf == 'SP' ? 'selected="selected"' : '' }}>SP - São Paulo</option>
                            <option value="SE" {{ isset($empresaEdit) && $empresaEdit->uf == 'SE' ? 'selected="selected"' : '' }}>SE - Sergipe</option>
                            <option value="TO" {{ isset($empresaEdit) && $empresaEdit->uf == 'TO' ? 'selected="selected"' : '' }}>TO - Tocantins</option>
                            <option value="DF" {{ isset($empresaEdit) && $empresaEdit->uf == 'DF' ? 'selected="selected"' : '' }}>DF - Distrito Federal</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row col-sm-12">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">{{ isset($empresaEdit) ? 'Atualizar' : 'Salvar' }}</button>
                </div>
            </div>
        </form>
    </div>

    <h4 style="margin-top: 30px">Lista de Empresa</h4>
    <hr>

    @if (count($empresas) > 0)

        <div class="panel panel-default">
            <div class="panel-heading">
                Empresas Cadastradas
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                        <th>#</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>UF</th>
                        <th class="action-button">&nbsp;</th>
                        <th class="action-button">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $empresa->id }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $empresa->nome_fantasia }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $empresa->cnpj }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $empresa->uf }}</div>
                                </td>
                                <td>
                                    <form action="{{ url('empresas/'.$empresa->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('GET') }}

                                        <button type="submit" class="btn btn-link">
                                            <i class="fa fa-trash"></i> Editar
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ url('empresas/'.$empresa->id) }}" method="POST">
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
            $('#cnpj').mask('99.999.999/9999-99');
        });
    </script>
@endsection