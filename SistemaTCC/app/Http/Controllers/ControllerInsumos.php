<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Insumo, InsumoProduto, Produto};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ControllerInsumos extends Controller
{
    public function listarInsumo(Request $request)
    {
        return view('menu.insumos.listar', ["insumos" => Insumo::all(), "request" => $request]);
    }

    public function telaAdicionarInsumo(Request $request)
    {
        return view('menu.insumos.adicionar', ["produtos" => Produto::all(), "request" => $request]);
    }

    public function adicionarInsumo(Request $request)
    {
        DB::beginTransaction();
        $insumo = new Insumo;
        $insumo->ins_nome = $request->nome;
        $insumo->ins_descricao = $request->descricao;
        $insumo->ins_preco = number_format(str_replace(',', '.', str_replace('.', '', $request->preco)), 2, '.', '');
        $insumo->ins_estoque = $request->estoque;
        $insumo->ins_consumo = $request->consumo;

        $insumo->save();

        DB::commit();

        return redirect(asset("painel/insumos/editar/$insumo->ins_id"))->with('success', 'Insumo adicionado com sucesso!');
    }

    public function removerInsumo(Request $request)
    {

        DB::beginTransaction();

        $insumo = Insumo::find($request->ins_id);
        if ($insumo->insumosProdutos->count() == 0 && $insumo->insumosVenda->count() == 0 && $insumo->insumosCompra->count() == 0) {
            $insumo->delete();
            DB::commit();

            return redirect()->route('menu-insumos')->with('success', 'Insumo removido com sucesso!');
        } else {
            return redirect()->route('menu-insumos')->with('failed', 'Insumo não pode ser removido, existem produtos, compras e/ou vendas relacionadas');
        }
    }

    public function buscarInsumo(Request $request)
    {
        $insumos = Insumo::where('ins_nome', 'LIKE', '%' . $request->inputFiltro . '%')
            ->orWhere('ins_descricao', 'LIKE', '%' . $request->inputFiltro . '%')
            ->get();

        return view('menu.insumos.listar', ["insumos" => $insumos, "request" => $request]);
    }

    public function telaEditarInsumo(Request $request)
    {
        return view('menu.insumos.editar', [
            "insumo" => Insumo::where('ins_id', $request->ins_id)->first(),
            "produtos" => Produto::all(),
            "insumos_produtos" => InsumoProduto::where('tb_insumos_ins_id', '=', $request->ins_id)->get(),
            "request" => $request
        ]);
    }

    public function editarInsumo(Request $request)
    {

        DB::beginTransaction();

        Insumo::where('ins_id', '=', $request->ins_id)
            ->update([
                'ins_nome' => $request->nome,
                'ins_descricao' => $request->descricao,
                'ins_preco' => number_format(str_replace(',', '.', str_replace('.', '', $request->preco)), 2, '.', ''),
                'ins_estoque' => $request->estoque,
                'ins_consumo' => $request->consumo,
            ]);

        DB::commit();

        return redirect()->route('menu-insumos')->with('success', 'Insumo alterado com sucesso!');
    }
}
