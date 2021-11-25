<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;
use App\Models\InsumoProduto;
use Illuminate\Support\Facades\DB;

class ControllerInsumosProdutos extends Controller
{
    public function adicionarInsumoProduto(Request $request)
    {
        DB::beginTransaction();

        $insumo_produto = new InsumoProduto;
        $insumo_produto->tb_produtos_prod_id = $request->produto;
        $insumo_produto->tb_insumos_ins_id = $request->ins_id;
        $insumo_produto->save();

        DB::commit();

        return redirect(asset("painel/insumos/editar/$request->ins_id"))->with('success', 'Produto relacionado com sucesso!');
    }

    public function removerInsumoProduto(Request $request)
    {
        $insumo_produto = InsumoProduto::find($request->insprod_id);

        DB::beginTransaction();
        $insumo_produto->delete();
        DB::commit();

        return redirect()->back()->with('success', 'Produto desvinculado com sucesso!');
    }
}
