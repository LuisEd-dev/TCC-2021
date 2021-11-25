<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\ContaReceber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerContasReceber extends Controller
{
    public function listarContaReceber(Request $request)
    {
        return view('menu.receber.listar', ["contasPorVenda" => ContaReceber::all()->whereNull('contr_data_rec')->groupBy('tb_vendas_ven_id'), "request" => $request]);
    }

    public function telaAdicionarContaReceber(Request $request)
    {
        $venda = Venda::find($request->ven_id);
        $cliente = Cliente::find($venda->tb_clientes_cli_id);
        return view('menu.receber.adicionar', ["venda" => $venda, "cliente" => $cliente, "request" => $request]);
    }

    public function adicionarContaReceber(Request $request)
    {

        date_default_timezone_set('America/Sao_Paulo');

        DB::beginTransaction();

        $venda = Venda::find($request->venda);
        $venda->ven_conta_lancada = date('Y-m-d H:i:s');
        $venda->save();

        $total = $venda->produtos_venda->reduce(function ($carry, $item) {
            return $carry + ($item->iven_venda * $item->iven_quantidade);
        }, 0);

        for ($i = 1; $i <= $request->parcelas; $i++) {
            $contaReceber = new ContaReceber();
            $contaReceber->tb_clientes_cli_id = $request->cliente;
            $contaReceber->tb_vendas_ven_id = $request->venda;
            $contaReceber->contr_data = date('Y-m-d H:i:s');
            $contaReceber->contr_data_venc = $i == 1 ? $request->cobranca : date('Y-m-d H:i:s', strtotime(date($request->cobranca) . " + " . ($i - 1) . " months"));
            $contaReceber->contr_valor = ($total / $request->parcelas);
            $contaReceber->contr_descricao = $request->observacao;
            $contaReceber->contr_num_parcela = $i;
            $contaReceber->contr_total_parcelas = $request->parcelas;

            $contaReceber->save();
        }

        DB::commit();

        return redirect()->route('menu-contas-receber');
    }

    public function telaEditarContaReceber(Request $request)
    {
        return view('menu.receber.editar', ["conta" => ContaReceber::find($request->contr_id), "request" => $request]);
    }

    public function editarContaReceber(Request $request)
    {
        DB::beginTransaction();
        $conta = ContaReceber::find($request->contr_id);
        $conta->contr_descricao = $request->observacao;
        $conta->contr_data_rec = $request->dataPagamento;
        $conta->save();
        DB::commit();

        return redirect(asset("painel/contas_receber/editar/$conta->contr_id"))->with('success', 'Conta alterada com sucesso!');
    }

    public function removerContaReceber(Request $request)
    {
        DB::beginTransaction();
        $contas = ContaReceber::where('tb_vendas_ven_id', '=', $request->ven_id)->get();
        foreach ($contas as $conta) {
            $conta->delete();
        }
        Venda::find($request->ven_id)->update(['ven_conta_lancada' => null]);
        DB::commit();
        return redirect(asset("painel/vendas/editar/$request->ven_id"))->with('success', 'Conta removida com sucesso!');
    }

    public function buscarContaReceber(Request $request)
    {

        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $contas = ContaReceber::all();

        if ($request->filtroDataInicio != null && $request->filtroDataFim != null) {
            $from = date('Y-m-d 00:00:00', strtotime($request->filtroDataInicio));
            $to = date('Y-m-d 23:59:59', strtotime($request->filtroDataFim));

            $contas = $contas->whereBetween('contr_data_venc', [$from, $to]);
        }

        if (!empty($request->inputFiltro)) {

            $cliente = Cliente::where('cli_nome', 'LIKE', '%' . $request->inputFiltro . '%')->first();
            if ($cliente != null) {
                $contas = $contas->filter(function ($conta) use ($cliente, $request) {
                    return $conta->tb_clientes_cli_id == $cliente->cli_id || $conta->tb_vendas_ven_id == $request->inputFiltro;
                });
            } else {
                $contas = $contas->where('tb_vendas_ven_id', '=', $request->inputFiltro);
            }
        }

        if ($request->checkPagos == null) {
            $contas = $contas->whereNull('contr_data_rec');
        }

        $contas = $contas->groupBy('tb_vendas_ven_id');

        return view('menu.receber.listar', ["contasPorVenda" => $contas, "check" => $request->checkPagos, "filtroDataInicio" => $request->filtroDataInicio, "filtroDataFim" => $request->filtroDataFim, "request" => $request]);
    }

    public function quitarContaReceber(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        DB::beginTransaction();
        $contaReceber = ContaReceber::find($request->contr_id);
        $contaReceber->contr_data_rec = date('Y-m-d H:i:s');
        $contaReceber->save();
        DB::commit();

        return redirect()->route('menu-contas-receber')->with('success', 'Conta marcada como paga em ' . date('Y/m/d H:i:s'));
    }
}
