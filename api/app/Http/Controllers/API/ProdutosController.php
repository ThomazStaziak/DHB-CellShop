<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produto;
use Illuminate\Support\Facades\Validator;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();

        return response($produtos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'nome' => 'required',
            'valor' => 'required',
            'descricao' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->messages(), 401);
        }

        $produto = new Produto();
        $produto->nome = request('nome');
        $produto->descricao = request('descricao');
        $produto->valor = request('valor');

        if (!empty(request('url_imagem'))) {
            $caminhoAbsoluto = public_path() . '/storage/uploads';
            $nomeArquivo = time() . '.' . request('url_imagem')->extension();

            request('url_imagem')->move($caminhoAbsoluto, $nomeArquivo);

            $produto->url_imagem = url('storage/uploads/' . $nomeArquivo);
        }

        $produto->save();

        return response($produto, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            $erro = ['mensagem' => 'Produto não encontrado'];
            return response(json_encode($erro), 401);
        }

        return response($produto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            $erro = ['mensagem' => 'Produto não encontrado'];
            return response(json_encode($erro), 401);
        }

        $produto->nome = request('nome');
        $produto->valor = request('valor');

        if (!empty(request('url_imagem'))) {
            $caminhoAbsoluto = public_path() . '/storage/uploads';
            $nomeArquivo = time() . '.' . request('url_imagem')->extension();

            request('url_imagem')->move($caminhoAbsoluto, $nomeArquivo);

            $produto->url_imagem = url('storage/uploads/' . $nomeArquivo);
        }

        $produto->save();

        return response($produto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            $erro = ['mensagem' => 'Produto não encontrado'];
            return response(json_encode($erro), 401);
        }

        $produto->delete();

        return response($produto, 200);
    }
}
