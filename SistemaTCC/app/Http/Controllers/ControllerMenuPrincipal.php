<?php

namespace App\Http\Controllers;

use NumberFormatter;


use Illuminate\Http\Request;
use App\Models\{Usuario, Cliente, Fornecedor, Venda, Compra, ContaPagar, ContaReceber};

class ControllerMenuPrincipal extends Controller
{
    public function menu(Request $request)
    {

        header('Content-Type: text/html; charset=UTF-8');


        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $usuarios = Usuario::all();
        $clientes = Cliente::all();
        $fornecedores = Fornecedor::all();
        $vendas = Venda::all();
        $compras = Compra::all();
        $contas_receber = ContaReceber::all();
        $contas_pagar = ContaPagar::all();

        if ($request->mes != null) {
            $primeiroDia = date('Y-m-1', strtotime($request->mes));
            $ultimoDia = date('Y-m-t', strtotime($request->mes));
        } else {
            $primeiroDia = date('Y-m-1');
            $ultimoDia = date('Y-m-t');
        }

        $caixaReceber = ContaReceber::whereBetween('contr_data_rec', [$primeiroDia, $ultimoDia])
            ->orWhereBetween('contr_data_venc', [$primeiroDia, $ultimoDia])->get();
        $caixaPagar = ContaPagar::whereBetween('contp_data_venc', [$primeiroDia, $ultimoDia])
            ->orWhereBetween('contp_data_pag', [$primeiroDia, $ultimoDia])->get();

        return view('painel.menu', [
            "request" => $request,
            "usuarios" => $usuarios,
            "clientes" => $clientes,
            "fornecedores" => $fornecedores,
            "vendas" => $vendas,
            "compras" => $compras,
            "contas_receber" => $contas_receber,
            "contas_pagar" => $contas_pagar,
            "caixaReceber" => $caixaReceber,
            "caixaPagar" => $caixaPagar,
            "data" => $primeiroDia
        ]);
    }
}
