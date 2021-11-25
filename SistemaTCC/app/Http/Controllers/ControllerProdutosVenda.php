<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Insumo;
use App\Models\Produto;
use App\Models\InsumoVenda;
use App\Models\ProdutoVenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerProdutosVenda extends Controller
{
    public function removerProdutoVenda(Request $request)
    {
        DB::beginTransaction();

        $produto_venda = ProdutoVenda::find($request->iven_id);
        foreach ($produto_venda->insumosVenda as $insumoVenda){
            $insumo = Insumo::find($insumoVenda->tb_insumos_ins_id);
            $insumo->ins_estoque = $insumo->ins_estoque + ($insumoVenda->insven_consumo * $produto_venda->iven_quantidade);
            $insumo->save();

            $insumoVenda->delete();
        }

        $produto_venda->delete();

        DB::commit();

        return redirect()->back()->with('success', 'Produto removido com sucesso!');
    }

    public function adicionarProdutoVenda(Request $request)
    {
        DB::beginTransaction();

        $produto = Produto::find($request->produto);

        $produto_venda = new ProdutoVenda;
        $produto_venda->tb_vendas_ven_id = $request->ven_id;
        $produto_venda->tb_produtos_prod_id = $request->produto;
        $produto_venda->iven_quantidade = $request->qtde;
        $produto_venda->iven_venda = $produto->prod_preco_venda;
        $produto_venda->iven_custo = $produto->prod_preco_custo;
        $produto_venda->save();

        foreach ($produto->insumosProduto as $insumo_produto) {
            $insumo = Insumo::find($insumo_produto->tb_insumos_ins_id);
            if ($insumo->ins_estoque - ($insumo->ins_consumo * $request->qtde) >= 0) {

                $insumo_venda = new InsumoVenda;
                $insumo_venda->tb_itens_venda_iven_id = $produto_venda->iven_id;
                $insumo_venda->tb_insumos_ins_id = $insumo->ins_id;
                $insumo_venda->insven_consumo = $insumo->ins_consumo;
                $insumo_venda->insven_preco = $insumo->ins_preco;
                $insumo_venda->save();

                $insumo->ins_estoque = $insumo->ins_estoque - ($insumo->ins_consumo * $request->qtde);
                $insumo->save();
            } else {
                return redirect()->back()->with('failed', 'Insumos insuficientes!');
            }
        }

        DB::commit();

        return redirect()->back()->with('success', 'Produto adicionado com sucesso!');
    }
}
