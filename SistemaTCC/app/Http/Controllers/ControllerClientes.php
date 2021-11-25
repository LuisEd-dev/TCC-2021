<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ControllerClientes extends Controller
{
    public function listarCliente(Request $request)
    {
        return view('menu.clientes.listar', ["clientes" => Cliente::all(), "request" => $request]);
    }

    public function telaAdicionarCliente(Request $request)
    {

        return view('menu.clientes.adicionar', compact('request'));
    }

    public function adicionarCliente(Request $request)
    {

        DB::beginTransaction();
        $cliente = new Cliente;
        $cliente->cli_nome = $request->nome;
        $cliente->cli_tipo_pessoa = $request->tipoPessoa;
        $cliente->cli_cpf_cnpj = preg_replace("/[^0-9]/", "", $request->cpfCnpj);
        $cliente->cli_rg_ie = preg_replace("/[^0-9]/", "", $request->rgIE);
        $cliente->cli_endereco = $request->endereco;
        $cliente->cli_numero = $request->numero;
        $cliente->cli_bairro = $request->bairro;
        $cliente->cli_cidade = $request->cidade;
        $cliente->cli_uf = $request->uf;
        $cliente->cli_cep = preg_replace("/[^0-9]/", "", $request->cep);
        $cliente->cli_complemento = $request->complemento;
        $cliente->cli_celular = preg_replace("/[^0-9]/", "", $request->celular);
        $cliente->cli_telefone = preg_replace("/[^0-9]/", "", $request->telefone);
        $cliente->cli_email = $request->email;

        $cliente->save();
        DB::commit();

        return redirect()->route('menu-clientes')->with('success', 'Cliente adicionado com sucesso!');
    }

    public function removerCliente(Request $request)
    {
        DB::beginTransaction();

        $cliente = Cliente::find($request->cli_id);

        if ($cliente->contasReceber()->count() == 0 && $cliente->vendas()->count() == 0) {
            $cliente->delete();
            DB::commit();
            return redirect()->route('menu-clientes')->with('success', 'Cliente removido com sucesso!');
        } else {
            return redirect()->route('menu-clientes')->with('failed', 'Cliente não pode ser removido, existem vendas e/ou contas a receber relacionadas');
        }
    }

    public function buscarCliente(Request $request)
    {

        $clientes = Cliente::where('cli_nome', 'LIKE', '%' . $request->inputFiltro . '%')
            ->orWhere('cli_email', 'LIKE', '%' . $request->inputFiltro . '%')
            ->orWhere('cli_cpf_cnpj', '=', preg_replace("/[^0-9]/", "", $request->inputFiltro))
            ->orWhere('cli_rg_ie', '=', preg_replace("/[^0-9]/", "", $request->inputFiltro))
            ->get();

        return view('menu.clientes.listar', ["clientes" => $clientes, "request" => $request]);
    }

    public function telaEditarCliente(Request $request)
    {

        return view('menu.clientes.editar', ["cliente" => Cliente::where('cli_id', $request->cli_id)->first(), "request" => $request]);
    }

    public function editarCliente(Request $request)
    {
        DB::beginTransaction();

        Cliente::where('cli_id', '=', $request->cli_id)
            ->update([
                'cli_nome' => $request->nome,
                'cli_tipo_pessoa' => $request->tipoPessoa,
                'cli_cpf_cnpj' => preg_replace("/[^0-9]/", "", $request->cpfCnpj),
                'cli_rg_ie' => preg_replace("/[^0-9]/", "", $request->rgIE),
                'cli_endereco' => $request->endereco,
                'cli_numero' => $request->numero,
                'cli_bairro' => $request->bairro,
                'cli_cidade' => $request->cidade,
                'cli_uf' => $request->uf,
                'cli_cep' => preg_replace("/[^0-9]/", "", $request->cep),
                'cli_complemento' => $request->complemento,
                'cli_celular' => preg_replace("/[^0-9]/", "", $request->celular),
                'cli_telefone' =>  preg_replace("/[^0-9]/", "", $request->telefone),
                'cli_email' => $request->email
            ]);

        DB::commit();

        return redirect()->route('menu-clientes')->with('success', 'Cliente alterado com sucesso!');
    }
}
