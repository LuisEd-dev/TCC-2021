<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Insumo;
use App\Models\InsumoCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerInsumosCompra extends Controller
{

    public function adicionarInsumosCompra(Request $request)
    {

        DB::beginTransaction();

        $insumo = Insumo::find($request->insumo);

        $insumo_compra = new InsumoCompra;
        $insumo_compra->tb_compras_cmp_id = $request->cmp_id;
        $insumo_compra->tb_insumos_ins_id = $request->insumo;
        $insumo_compra->icmp_quantidade = $request->qtde;
        $insumo_compra->icmp_preco = $insumo->ins_preco;
        $insumo_compra->save();

        $insumo->ins_estoque = $insumo->ins_estoque + $request->qtde;
        $insumo->save();

        DB::commit();

        return redirect()->back()->with('success', 'Insumo adicionado com sucesso!');
    }

    public function removerInsumosCompra(Request $request)
    {

        DB::beginTransaction();

        $insumo_compra = InsumoCompra::find($request->icmp_id);

        $insumo = Insumo::find($insumo_compra->tb_insumos_ins_id);
        $insumo->ins_estoque = $insumo->ins_estoque - $insumo_compra->icmp_quantidade;
        $insumo->save();

        $insumo_compra->delete();

        DB::commit();

        return redirect()->back()->with('success', 'Insumo removido com sucesso!');
    }
}
