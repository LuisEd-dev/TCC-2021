<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\ContaPagar;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerContasPagar extends Controller
{
    public function listarContaPagar(Request $request)
    {
        return view('menu.pagar.listar', ["contasPorCompra" => ContaPagar::all()->whereNull('contp_data_pag')->groupBy('tb_compras_cmp_id'), "request" => $request]);
    }

    public function telaAdicionarContaPagar(Request $request)
    {
        $compra = Compra::find($request->cmp_id);
        $fornecedor = Fornecedor::find($compra->tb_fornecedores_for_id);
        return view('menu.pagar.adicionar', ["compra" => $compra, "fornecedor" => $fornecedor, "request" => $request]);
    }

    public function adicionarContaPagar(Request $request)
    {

        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        DB::beginTransaction();

        $compra = Compra::find($request->compra);
        $compra->cmp_conta_lancada = date('Y-m-d H:i:s');
        $compra->save();

        $total = $compra->insumos_compra->reduce(function ($carry, $item) {
            return $carry + ($item->icmp_preco * $item->icmp_quantidade);
        }, 0);

        for ($i = 1; $i <= $request->parcelas; $i++) {
            $contaPagar = new ContaPagar();
            $contaPagar->tb_fornecedores_for_id = $request->fornecedor;
            $contaPagar->tb_compras_cmp_id = $request->compra;
            $contaPagar->contp_data = date('Y-m-d H:i:s');
            $contaPagar->contp_data_venc = $i == 1 ? $request->cobranca : date('Y-m-d H:i:s', strtotime(date($request->cobranca) . " + " . ($i - 1) . " months"));
            $contaPagar->contp_valor = ($total / $request->parcelas);
            $contaPagar->contp_descricao = $request->observacao;
            $contaPagar->contp_num_parcela = $i;
            $contaPagar->contp_total_parcelas = $request->parcelas;

            $contaPagar->save();
        }

        DB::commit();

        return redirect()->route('menu-contas-pagar');
    }

    public function telaEditarContaPagar(Request $request)
    {
        return view('menu.pagar.editar', ["conta" => ContaPagar::find($request->contp_id), "request" => $request]);
    }

    public function editarContaPagar(Request $request)
    {
        DB::beginTransaction();
        $conta = ContaPagar::find($request->contp_id);
        $conta->contp_descricao = $request->observacao;
        $conta->contp_data_pag = $request->dataPagamento;
        $conta->save();
        DB::commit();

        return redirect(asset("painel/contas_pagar/editar/$conta->contp_id"))->with('success', 'Conta alterada com sucesso!');
    }

    public function removerContaPagar(Request $request)
    {
        DB::beginTransaction();
        $contas = ContaPagar::where('tb_compras_cmp_id', '=', $request->cmp_id)->get();
        foreach ($contas as $conta) {
            $conta->delete();
        }
        Compra::find($request->cmp_id)->update(['cmp_conta_lancada' => null]);
        DB::commit();
        return redirect(asset("painel/compras/editar/$request->cmp_id"))->with('success', 'Conta removida com sucesso!');
    }

    public function buscarContaPagar(Request $request)
    {

        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $contas = ContaPagar::all();

        if ($request->filtroDataInicio != null && $request->filtroDataFim != null) {
            $from = date('Y-m-d 00:00:00', strtotime($request->filtroDataInicio));
            $to = date('Y-m-d 23:59:59', strtotime($request->filtroDataFim));

            $contas = $contas->whereBetween('contp_data_venc', [$from, $to]);
        }

        if (!empty($request->inputFiltro)) {

            $fornecedor = Fornecedor::where('for_nome', 'LIKE', '%' . $request->inputFiltro . '%')->first();
            if ($fornecedor != null) {
                $contas = $contas->filter(function ($conta) use ($fornecedor, $request) {
                    return $conta->tb_fornecedores_for_id == $fornecedor->for_id || $conta->tb_compras_cmp_id == $request->inputFiltro;
                });
            } else {
                $contas = $contas->where('tb_compras_cmp_id', '=', $request->inputFiltro);
            }
        }

        if ($request->checkPagos == null) {
            $contas = $contas->whereNull('contp_data_pag');
        }

        $contas = $contas->groupBy('tb_compras_cmp_id');

        return view('menu.pagar.listar', ["contasPorCompra" => $contas, "check" => $request->checkPagos, "filtroDataInicio" => $request->filtroDataInicio, "filtroDataFim" => $request->filtroDataFim, "request" => $request]);
    }

    public function quitarContaPagar(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        DB::beginTransaction();
        $contaPagar = ContaPagar::find($request->contp_id);
        $contaPagar->contp_data_pag = date('Y-m-d H:i:s');
        $contaPagar->save();
        DB::commit();

        return redirect()->route('menu-contas-pagar')->with('success', 'Conta marcada como paga em ' . date('Y/m/d H:i:s'));
    }
}
