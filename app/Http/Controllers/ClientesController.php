<?php

namespace App\Http\Controllers;

use App\Clientes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

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

        //validação dos dados
        $validator = $this->validarDados($dados, "store");
        if ($validator['STATUS']) {

            $retorno = array(
                'status' => false,
                'errors' => $validator['msgError'],
            );
            return response()->json($retorno);
        }

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
        //validação dos dados
        $validator = $this->validarDados($dados, "update");
        if ($validator['STATUS']) {

            $retorno = array(
                'status' => false,
                'errors' => $validator['msgError'],
            );
            return response()->json($retorno);
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

    public function validarDados($data, $op)
    {
        switch ($op) {
            case 'store':

                //validar dados cliente create
                $validator = \Validator::make($data, [
                    'nome' => 'required|unique:clientes',
                    'nome_fantasia' => 'required|unique:clientes',
                    'seguimento' => 'required',
                    'cpf/cnpj' => 'required|string|min:11|max:14|unique:clientes',
                    'email' => 'required|email|unique:clientes',
                    'telefone' => 'required |string|min:9|max:14',
                ], [
                    "required" => "O campo :attribute não pode está vazio",
                    "unique" => "O :attribute :input já existe no banco de dados",
                    "email" => "O email  :input não é válido",
                    "cpf/cnpj.max" => "O campo :attribute não pode conter mais de 14 caracteres",
                    "cpf/cnpj.min" => "O campo :attribute não pode conter menos de 11 caracteres",
                    "telefone.max" => "O campo :attribute não pode conter mais de 14 caracteres",
                    "telefone.min" => "O campo :attribute não pode conter menos de 11 caracteres",

                ]
                );
                if ($validator->fails()) {
                    $retorno = [
                        "STATUS" => $validator->fails(),
                        'msgError' => $validator->errors()->all(),
                    ];
                    return $retorno;
                }
                break;

            case 'update':

                //validar dados cliente update
                $validator = \Validator::make($data, [
                    'nome' => 'unique:clientes',
                    'nome_fantasia' => 'unique:clientes',
                    'cpf/cnpj' => 'unique:clientes|string|min:11|max:14',
                    'email' => 'unique:clientes|email',
                    'telefone' => 'string|min:9|max:14',
                ], [
                    "unique" => "O :attribute :input já existe no banco de dados",
                    "email" => "O email  :input não é válido",
                    "cpf/cnpj.max" => "O campo :attribute não pode conter mais de 14 caracteres",
                    "cpf/cnpj.min" => "O campo :attribute não pode conter menos de 11 caracteres",
                    "telefone.max" => "O campo :attribute não pode conter mais de 14 caracteres",
                    "telefone.min" => "O campo :attribute não pode conter menos de 11 caracteres",

                ]
                );
                if ($validator->fails()) {
                    $retorno = [
                        "STATUS" => $validator->fails(),
                        'msgError' => $validator->errors()->all(),
                    ];
                    return $retorno;
                }
                break;
        }

    }
}
