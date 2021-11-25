<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Venda, Produto, Cliente, ProdutoVenda};

class ControllerVendas extends Controller
{
    public function listarVenda(Request $request)
    {
        return view('menu.vendas.listar', ["vendas" => Venda::all(), "request" => $request]);
    }

    public function telaAdicionarVenda(Request $request)
    {
        return view('menu.vendas.adicionar', ["produtos" => Produto::all(), "clientes" => Cliente::all(), "request" => $request]);
    }

    public function adicionarVenda(Request $request)
    {

        date_default_timezone_set('America/Sao_Paulo');

        DB::beginTransaction();

        $venda = new Venda;
        $venda->tb_clientes_cli_id = $request->cliente;
        $venda->ven_data = date('Y-m-d H:i:s');
        $venda->ven_observacao = $request->observacao;
        $venda->save();

        DB::commit();

        return redirect(asset("painel/vendas/editar/$venda->ven_id"))->with('success', 'Venda adicionada com sucesso!');
    }

    public function removerVenda(Request $request)
    {
        DB::beginTransaction();

        $venda = Venda::find($request->ven_id);
        if ($venda->contasReceber->count() == 0) {
            foreach ($venda->produtos_venda as $produtoVenda) {
                foreach ($produtoVenda->insumosVenda as $insumosVenda) {
                    $insumo = $insumosVenda->insumo;
                    $insumo->ins_estoque = $insumo->ins_estoque + ($insumosVenda->insven_consumo * $produtoVenda->iven_quantidade);
                    $insumo->save();

                    $insumosVenda->delete();
                }
                $produtoVenda->delete();
            }

            $venda->delete();

            DB::commit();
            return redirect()->route('menu-vendas')->with('success', 'Venda removida com sucesso!');
        } else {
            return redirect()->route('menu-vendas')->with('failed', 'Venda não pode ser removida, existem contas a receber relacionadas');
        }
    }

    public function buscarVenda(Request $request)
    {
        $cliente = null;
        $venda = null;

        if ($request->inputFiltro != null && $request->inputFiltro != '') {
            $cliente = Cliente::where('cli_nome', 'LIKE', '%' . $request->inputFiltro . '%')->first();
            $venda = Venda::where('ven_id', '=', $request->inputFiltro)
                ->orWhere('ven_observacao', 'LIKE', '%' . $request->inputFiltro . '%');
            if ($cliente != null) {
                $venda = $venda->orWhere('tb_clientes_cli_id', '=', $cliente->cli_id);
            }
        } else {
            $venda = Venda::where('ven_id', '!=', null);
        }

        if ($request->filtroDataInicio != null && $request->filtroDataFim != null) {
            $from = date('Y-m-d 00:00:00', strtotime($request->filtroDataInicio));
            $to = date('Y-m-d 23:59:59', strtotime($request->filtroDataFim));

            $venda = $venda->whereBetween('ven_data', [$from, $to]);
        }

        $venda = $venda->get();

        return view('menu.vendas.listar', ["vendas" => $venda, "filtroDataInicio" => $request->filtroDataInicio, "filtroDataFim" => $request->filtroDataFim, "request" => $request]);
    }

    public function telaEditarVenda(Request $request)
    {
        $venda = Venda::find($request->ven_id);
        return view('menu.vendas.editar', [
            "venda" => $venda,
            "cliente" => Cliente::find($venda->tb_clientes_cli_id),
            "produtos" => Produto::all(),
            "produtos_venda" => collect(ProdutoVenda::where('tb_vendas_ven_id', '=', $request->ven_id)->get())->groupBy('tb_produtos_prod_id'),
            "request" => $request
        ]);
    }

    public function editarVenda(Request $request)
    {

        DB::beginTransaction();

        Venda::where('ven_id', '=', $request->ven_id)
            ->update([
                'ven_observacao' => $request->observacao
            ]);

        DB::commit();

        return redirect()->back()->with('success', 'Venda alterada com sucesso!');
    }
}
