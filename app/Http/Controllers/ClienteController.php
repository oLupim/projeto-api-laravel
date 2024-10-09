<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function listar()
    {
        $customers = Cliente::all();
        return ApiResponse::success('Listado com sucesso!', $customers);
    }


    public function listarPeloId(int $id)
    {
        $customer = Cliente::findOrFail($id);
        return ApiResponse::success('Listado pelo ID!', $customer);
    }

    public function deletar(Request $request, int $id)
    {
        $customer = Cliente::findOrFail($id);
        $customer->delete();
        
        return ApiResponse::success('Deletado com sucesso!');

    }

    public function salvar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clientes|max:200',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Erro de validação', 
            $validator->errors());

        }

        $customer = Cliente::create($request->all());
        return ApiResponse::success('Salvo com sucesso!', 
        $customer);
    }

    public function editar(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:200',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Erro de validação', 
            $validator->errors());

        }

        $customer = Cliente::findOrFail($id);
        $customer->update($request->all());
        return ApiResponse::success('Salvo com sucesso!', 
        $customer);

        
    }




}
