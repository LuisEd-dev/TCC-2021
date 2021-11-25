<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ControllerFornecedores extends Controller
{

    public function listarFornecedor(Request $request)
    {
        return view('menu.fornecedores.listar', ["fornecedores" => Fornecedor::all(), "request" => $request]);
    }

    public function telaAdicionarFornecedor(Request $request)
    {
        return view('menu.fornecedores.adicionar', compact('request'));
    }

    public function adicionarFornecedor(Request $request)
    {

        DB::beginTransaction();
        $fornecedor = new Fornecedor;
        $fornecedor->for_nome = $request->nome;
        $fornecedor->for_tipo_pessoa = $request->tipoPessoa;
        $fornecedor->for_cpf_cnpj = preg_replace("/[^0-9]/", "", $request->cpfCnpj);
        $fornecedor->for_rg_ie = preg_replace("/[^0-9]/", "", $request->rgIE);
        $fornecedor->for_endereco = $request->endereco;
        $fornecedor->for_numero = $request->numero;
        $fornecedor->for_bairro = $request->bairro;
        $fornecedor->for_cidade = $request->cidade;
        $fornecedor->for_uf = $request->uf;
        $fornecedor->for_cep = preg_replace("/[^0-9]/", "", $request->cep);
        $fornecedor->for_complemento = $request->complemento;
        $fornecedor->for_celular = preg_replace("/[^0-9]/", "", $request->celular);
        $fornecedor->for_telefone = preg_replace("/[^0-9]/", "", $request->telefone);
        $fornecedor->for_email = $request->email;

        $fornecedor->save();
        DB::commit();

        return redirect()->route('menu-fornecedores')->with('success', 'Fornecedor adicionado com sucesso!');
    }

    public function removerFornecedor(Request $request)
    {
        DB::beginTransaction();

        $fornecedor = Fornecedor::find($request->for_id);

        if ($fornecedor->contasPagar()->count() == 0 && $fornecedor->compras()->count() == 0) {
            $fornecedor->delete();
            DB::commit();
            return redirect()->route('menu-fornecedores')->with('success', 'Fornecedor removido com sucesso!');
        } else {
            return redirect()->route('menu-fornecedores')->with('failed', 'Fornecedor não pode ser removido, existem compras e/ou contas a pagar relacionadas');
        }

        return redirect()->route('menu-fornecedores')->with('success', 'Fornecedor removido com sucesso!');
    }

    public function buscarFornecedor(Request $request)
    {

        $fornecedores = Fornecedor::where('for_nome', 'LIKE', '%' . $request->inputFiltro . '%')
            ->orWhere('for_email', 'LIKE', '%' . $request->inputFiltro . '%')
            ->orWhere('for_cpf_cnpj', '=', preg_replace("/[^0-9]/", "", $request->inputFiltro))
            ->orWhere('for_rg_ie', '=', preg_replace("/[^0-9]/", "", $request->inputFiltro))
            ->get();

        return view('menu.fornecedores.listar', ["fornecedores" => $fornecedores, "request" => $request]);
    }

    public function telaEditarFornecedor(Request $request)
    {

        return view('menu.fornecedores.editar', ["fornecedor" => Fornecedor::where('for_id', $request->for_id)->first(), "request" => $request]);
    }

    public function editarFornecedor(Request $request)
    {
        DB::beginTransaction();

        Fornecedor::where('for_id', '=', $request->for_id)
            ->update([
                'for_nome' => $request->nome,
                'for_tipo_pessoa' => $request->tipoPessoa,
                'for_cpf_cnpj' => preg_replace("/[^0-9]/", "", $request->cpfCnpj),
                'for_rg_ie' => preg_replace("/[^0-9]/", "", $request->rgIE),
                'for_endereco' => $request->endereco,
                'for_numero' => $request->numero,
                'for_bairro' => $request->bairro,
                'for_cidade' => $request->cidade,
                'for_uf' => $request->uf,
                'for_cep' => preg_replace("/[^0-9]/", "", $request->cep),
                'for_complemento' => $request->complemento,
                'for_celular' => preg_replace("/[^0-9]/", "", $request->celular),
                'for_telefone' => preg_replace("/[^0-9]/", "", $request->telefone),
                'for_email' => $request->email
            ]);

        DB::commit();

        return redirect()->route('menu-fornecedores')->with('success', 'Fornecedor alterado com sucesso!');
    }
}
