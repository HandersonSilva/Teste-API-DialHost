<?php

namespace App\Http\Controllers;

use App\Clientes;
use Exception;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { //listando todos os clientes
        try {
            $cliente = Clientes::all()->toArray();
            if (empty($cliente)) {
                return response()->json(['message' => 'Não existe clientes cadastrados no sistema', 'status' => true], 201);
            }
            if ($cliente) {

                return response()->json(['status' => true, 'data' => $cliente], 201);
            } else {
                return response()->json(['message' => 'Não foi possivel retornar os clientes', 'status' => false], 400);
            }
        } catch (Exception $e) {

            return response()->json(['message' => 'Não foi possivel retornar os clientes error = ' . $e->getMessage(), 'status' => false], 400);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { //cadastrando cliente
        $dados = $request->all();

        try {

            $cliente = Clientes::create($dados);

            if ($cliente) {
                return response()->json(['data' => $cliente, 'status' => true], 201);
            } else {
                return response()->json(['message' => 'Não foi possivel cadastrar o cliente' . $dados['nome'], 'status' => false], 400);
            }

        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possivel cadastrar o cliente ' . $dados['nome'] . ' error = ' . $e->getMessage(), 'status' => false], 400);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { //busca por cliente id
        if ($id > 0) {
            try {
                $cliente = Clientes::find($id);

                if ($cliente) {
                    return response()->json(['data' => $cliente, 'status' => true], 201);
                } else {
                    return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id, 'status' => false], 400);
                }
            } catch (Exception $e) {

                return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id . 'error = ' . $e->getMessage(), 'status' => false], 400);

            }
        } else {
            return response()->json(['message' => 'Por favor informe um id válido', 'status' => false], 404);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { //Editando o cliente

        $dados = $request->all();

        if (!$dados) {
            return response()->json(['message' => 'Nenhum dado enviado para a edição', 'status' => false], 404);

        }

        if ($id > 0) {
            try {
                $cliente = Clientes::find($id);

                if ($cliente) {
                    try {
                        $cliente->update($dados);

                        return response()->json(['data' => $cliente, 'status' => true], 201);

                    } catch (Exception $e) {

                        return response()->json(['message' => 'Não foi possivel editar o cliente ID = ' . $id . 'error = ' . $e->getMessage(), 'status' => false], 400);
                    }

                } else {
                    return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id, 'status' => false], 400);
                }
            } catch (Exception $e) {

                return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id . 'error = ' . $e->getMessage(), 'status' => false], 400);

            }
        } else {
            return response()->json(['message' => 'Por favor informe um id válido', 'status' => false], 404);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { //Excluido registro

        if ($id > 0) {
            try {
                $cliente = Clientes::find($id);

                if ($cliente) {
                    try {
                        $cliente->delete();

                        return response()->json(['data' => "Cliente excluido com sucesso", 'status' => true], 201);

                    } catch (Exception $e) {

                        return response()->json(['message' => 'Não foi possivel excluir o cliente ID = ' . $id . 'error = ' . $e->getMessage(), 'status' => false], 400);
                    }

                } else {
                    return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id, 'status' => false], 400);
                }
            } catch (Exception $e) {

                return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id . 'error = ' . $e->getMessage(), 'status' => false], 400);

            }
        } else {
            return response()->json(['message' => 'Por favor informe um id válido', 'status' => false], 404);

        }

    }
}
