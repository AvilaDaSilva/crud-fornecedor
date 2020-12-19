<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Validator;

class EmpresasController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new Service();
    }
    
    public function fetch($id = null)
    {
        $dadosView = [
            'empresas' => Empresa::orderBy('id', 'desc')->get()
        ];

        if ($id !== null) {
            $dadosView['empresaEdit'] = Empresa::find($id);
        }

        return view('empresa.empresa', $dadosView);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome_fantasia' => 'required',
            'uf' => function ($attribute, $value, $fail) {
                if ($value == "") {
                    $fail("É necessário escolher ao menos um estado!");
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

        if ($validator->fails()) {
            return redirect('empresas')->withErrors($validator);
        }
        
        Empresa::create([
            'nome_fantasia' => $request->nome_fantasia,
            'cnpj' => $request->cnpj,
            'uf' => $request->uf
        ]);

        return redirect('empresas')->with('successes', 'Empresa cadastrada com sucesso!');
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nome_fantasia' => 'required',
            'uf' => function ($attribute, $value, $fail) {
                if ($value == "") {
                    $fail("É necessário escolher ao menos um estado!");
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

        if ($validator->fails()) {
            return redirect('empresas')->withErrors($validator);
        }

        $empresa = Empresa::find($id);
        
        $empresa->update([
            'nome_fantasia' => $request->nome_fantasia,
            'cnpj' => $request->cnpj,
            'uf' => $request->uf
        ]);

        return redirect('empresas')->with('successes', 'Empresa atualizada com sucesso!');
    }

    public function delete($id)
    {
        $empresa = Empresa::find($id)->delete();

        if (!$empresa) {
            return redirect('empresas')->withErrors(['Não foi possível remover o registro!']);
        }
        
        return redirect('empresas')->with('successes', 'Registro removido com sucesso!');
    }
}
