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
    {
        try {
            $cliente = Clientes::all();

            if ($cliente) {
                return response()->json(['status' => 'sucesso', 'data' => $cliente], 201);
            } else {
                return response()->json(['message' => 'Não foi possivel retornar os clientes', 'status' => 'error'], 400);
            }
        } catch (Exception $e) {

            return response()->json(['message' => 'Não foi possivel retornar os clientes error = ' . $e->getMessage(), 'status' => 'error'], 400);

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
    {
        $dados = $request->all();

        try {

            $cliente = Clientes::create($dados);

            if ($cliente) {
                return response()->json(['data' => $cliente, 'status' => 'sucesso'], 201);
            } else {
                return response()->json(['message' => 'Não foi possivel cadastrar o cliente' . $dados['nome']], 400);
            }

        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possivel cadastrar o cliente ' . $dados['nome'] . ' error = ' . $e->getMessage(), 'status' => 'error'], 400);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if ($id > 0) {
            try {
                $cliente = Clientes::find($id);

                if ($cliente) {
                    return response()->json(['data' => $cliente, 'status' => 'sucesso'], 201);
                } else {
                    return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id, 'status' => 'error'], 400);
                }
            } catch (Exception $e) {

                return response()->json(['message' => 'Não foi possivel encontrar o cliente ID = ' . $id . 'error = ' . $e->getMessage(), 'status' => 'error'], 400);

            }
        } else {
            return response()->json(['message' => 'Por favor informe o id válido', 'status' => 'error'], 404);

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
