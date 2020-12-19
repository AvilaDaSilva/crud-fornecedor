<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Fornecedor;
use App\Http\Services\Service;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FornecedoresController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new Service();
    }

    public function fetch(Request $request, $id = null)
    {
        if (count($request->request) > 0) {
            $dadosView['dadosConsulta'] = $request;
        }
        $whereConsulta = $this->genereteWhere($request);

        if (is_object($whereConsulta) && !is_bool($whereConsulta)) {
            return redirect('fornecedores')->withErrors($whereConsulta);
        }

        $dadosView['fornecedores'] = Fornecedor::select('fornecedores.*', 'empresas.nome_fantasia AS nome_empresa', DB::raw("DATE_FORMAT(fornecedores.data_cadastro, '%d/%m/%Y') AS data_cadastro"))
            ->join('empresas', 'empresas.id', '=', 'fornecedores.empresa')
            ->orderBy('empresas.nome_fantasia', 'asc')
            ->whereRaw($whereConsulta)->get();

        $dadosView['empresas'] = Empresa::orderBy('id', 'desc')->get();

        if ($id !== null) {
            $dadosView['fornecedorEdit'] = Fornecedor::find($id);
        }

        return view('fornecedor.fornecedor', $dadosView);
    }

    public function create(Request $request)
    {
        $retornoValidacao = $this->validateData($request);

        if (is_object($retornoValidacao) && !is_bool($retornoValidacao)) {
            return redirect('fornecedores')->withErrors($retornoValidacao);
        }

        if (!$this->validarRegraEstadoEmpresaIdade($request)) {
            return redirect('fornecedores')->withErrors(['Quando a empresa for do Paraná o usuário pessoa física deve ser maior de idade!']);
        }

        Fornecedor::create([
            'empresa' => $request->empresa,
            'nome' => $request->nome,
            'tipo_pessoa' => $request->tipo_pessoa,
            'data_nascimento' => implode('-', array_reverse(explode('/', ($request->data_nascimento)))),
            'rg' => $request->rg,
            'cpf_cnpj' => $request->tipo_pessoa == '1' ? $request->cnpj : $request->cpf,
            'data_cadastro' => date('Y-m-d H:m:s')
        ]);

        return redirect('fornecedores')->with('successes', 'Fornecedor cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $retornoValidacao = $this->validateData($request);

        if ($retornoValidacao instanceof Validator) {
            return redirect('fornecedor')->withErrors($retornoValidacao);
        }
        
        $fornecedor = Fornecedor::find($id);
        $fornecedor->update([
            'empresa' => $request->empresa,
            'nome' => $request->nome,
            'tipo_pessoa' => $request->tipo_pessoa,
            'data_nascimento' => implode('-', array_reverse(explode('/', ($request->data_nascimento)))),
            'rg' => $request->rg,
            'cpf_cnpj' => $request->tipo_pessoa == '1' ? $request->cnpj : $request->cpf,
            'data_cadastro' => date('Y-m-d H:m:s')
        ]);

        return redirect('fornecedores')->with('successes', 'Fornecedor atualizado com sucesso!');
    }

    public function delete($id)
    {
        $fornecedor = Fornecedor::find($id)->delete();

        if (!$fornecedor) {
            return redirect('fornecedores')->withErrors(['Não foi possível remover o registro!']);
        }
        
        return redirect('fornecedores')->with('successes', 'Registro removido com sucesso!');
    }

    private function validarRegraEstadoEmpresaIdade($dadosFornecedor)
    {
        $empresa = Empresa::find($dadosFornecedor->empresa);
        
        if ($empresa->uf == 'PR' && $dadosFornecedor->tipo_pessoa == 0) {

            $dataNascimento = implode('-', array_reverse(explode('/', ($dadosFornecedor->data_nascimento))));
            $objectDate = new DateTime($dataNascimento);
            $intervaloDatasHoje = $objectDate->diff(new DateTime(date('Y-m-d')));

            if ($intervaloDatasHoje->format('%Y') < '18') {
                
                return false;
            }
        }
                
        return true;
    }

    private function validateData(Request $request)
    {
        if ($request->tipo_pessoa == '1') {
        
            $validator = Validator::make($request->all(), [
                'empresa' => 'required',
                'nome' => 'required',
                'data_nascimento' => function ($attribute, $value, $fail) {
                    $arrayData = explode('/', $value);
                    if (!checkdate($arrayData[1], $arrayData[0], $arrayData[2])) {
                        $fail("Data de nascimento inválida!");
                    }
                },
                'tipo_pessoa' => function ($attribute, $value, $fail) {
                    if ($value == "") {
                        $fail("É necessário escolher o tipo de pessoa!");
                    }
                },
                'cnpj' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!$this->service->validarCnpj($value)) {
                            $fail("CNPJ inválido.");
                        }
                    }
                ]
            ]);

        } else {
        
            $validator = Validator::make($request->all(), [
                'empresa' => 'required',
                'nome' => 'required',
                'data_nascimento' => function ($attribute, $value, $fail) {
                    $arrayData = explode('/', $value);
                    if (!checkdate($arrayData[1], $arrayData[0], $arrayData[2])) {
                        $fail("Data de nascimento inválida!");
                    }
                },
                'tipo_pessoa' => function ($attribute, $value, $fail) {
                    if ($value == "") {
                        $fail("É necessário escolher o tipo de pessoa!");
                    }
                },
                'rg' => 'required',
                'cpf' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!$this->service->validarCpf($value)) {
                            $fail("CPF inválido.");
                        }
                    }
                ]
            ]);
        }

        if ($validator->fails()) {
            return $validator;
        }

        return true;
    }

    private function genereteWhere(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consulta_data_cadastro' => function ($attribute, $value, $fail) {
                $arrayData = explode('/', $value);
                if (!is_null($value) && !checkdate($arrayData[1], $arrayData[0], $arrayData[2])) {
                    $fail("Data de cadastro consultada é inválida!");
                }
            },
            'consulta_cpf_cnpj' => function ($attribute, $value, $fail) {
                if (!is_null($value) && !$this->service->validarCpf($value) && !$this->service->validarCnpj($value)) {
                    $fail("CPF/CNPJ consultado é inválido.");
                }
            }
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        $whereConsulta = "1 = 1";

        if (count($request->request) > 0) {
            if (isset($request->consulta_nome) && !is_null($request->consulta_nome)) {
                $whereConsulta .= " AND fornecedores.nome LIKE '%".$request->consulta_nome."%'";
            }
            if (isset($request->consulta_cpf_cnpj) && !is_null($request->consulta_cpf_cnpj)) {
                $whereConsulta .= " AND fornecedores.cpf_cnpj LIKE '".$request->consulta_cpf_cnpj."'";
            }
            if (isset($request->consulta_data_cadastro) && !is_null($request->consulta_data_cadastro)) {
                $dataFormatada = implode('-', array_reverse(explode('/', ($request->consulta_data_cadastro))));
                $whereConsulta .= " AND fornecedores.data_cadastro = '$dataFormatada'";
            }
        }

        return $whereConsulta;
    }
}
