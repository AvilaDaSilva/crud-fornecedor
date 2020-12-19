<?php

namespace App\Http\Controllers;

use App\Fornecedor;
use App\FornecedorTelefone;
use Illuminate\Http\Request;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Validator;

class FornecedorTelefonesController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new Service();
    }
    
    public function fetch($id = null)
    {
        $dadosView = [
            'fornecedores' => Fornecedor::orderBy('id', 'desc')->get()
        ];
        
        $dadosView['telefones'] = FornecedorTelefone::select('fornecedor_telefones.*', 'fornecedores.nome AS nome_fornecedor')
            ->join('fornecedores', 'fornecedores.id', '=', 'fornecedor_telefones.fornecedor')
            ->orderBy('fornecedores.nome', 'asc')->get();

        if ($id !== null) {
            $dadosView['telefoneEdit'] = FornecedorTelefone::find($id);
        }

        return view('fornecedor.telefone', $dadosView);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fornecedor' => 'required',
            'telefone' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('telefones-fornecedor')->withErrors($validator);
        }
        
        FornecedorTelefone::create([
            'fornecedor' => $request->fornecedor,
            'telefone' => $request->telefone
        ]);

        return redirect('telefones-fornecedor')->with('successes', 'Telefone cadastrada com sucesso!');
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'fornecedor' => 'required',
            'telefone' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('telefones-fornecedor')->withErrors($validator);
        }

        $telefone = FornecedorTelefone::find($id);
        
        $telefone->update([
            'fornecedor' => $request->fornecedor,
            'telefone' => $request->telefone
        ]);

        return redirect('telefones-fornecedor')->with('successes', 'Telefone atualizada com sucesso!');
    }

    public function delete($id)
    {
        $telefone = FornecedorTelefone::find($id)->delete();

        if (!$telefone) {
            return redirect('telefones-fornecedor')->withErrors(['Não foi possível remover o registro!']);
        }
        
        return redirect('telefones-fornecedor')->with('successes', 'Registro removido com sucesso!');
    }
}
