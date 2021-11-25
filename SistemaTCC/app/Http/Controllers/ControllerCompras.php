<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Insumo;
use App\Models\Fornecedor;
use App\Models\InsumoCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerCompras extends Controller
{
    public function listarCompra(Request $request)
    {
        return view('menu.compras.listar', ["compras" => Compra::all(), "request" => $request]);
    }

    public function telaAdicionarCompra(Request $request)
    {
        return view('menu.compras.adicionar', ["insumos" => Insumo::all(), "fornecedores" => Fornecedor::all(), "request" => $request]);
    }

    public function adicionarCompra(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        DB::beginTransaction();

        $compra = new Compra;
        $compra->tb_fornecedores_for_id = $request->fornecedor;
        $compra->cmp_data = date('Y-m-d H:i:s');
        $compra->cmp_observacao = $request->observacao;
        $compra->save();

        DB::commit();

        return redirect(asset("painel/compras/editar/$compra->cmp_id"))->with('success', 'Compra adicionada com sucesso!');
    }

    public function telaEditarCompra(Request $request)
    {
        return view('menu.compras.editar', [
            "compra" => Compra::find($request->cmp_id),
            "fornecedores" => Fornecedor::all(),
            "insumos" => Insumo::all(),
            "insumos_compra" => collect(InsumoCompra::where('tb_compras_cmp_id', '=', $request->cmp_id)->get())->groupBy('tb_insumos_ins_id'),
            "request" => $request
        ]);
    }

    public function editarCompra(Request $request)
    {
        DB::beginTransaction();

        Compra::find($request->cmp_id)
            ->update([
                'cmp_observacao' => $request->observacao
            ]);

        DB::commit();

        return redirect()->back()->with('success', 'Compra alterada com sucesso!');
    }

    public function removerCompra(Request $request)
    {

        DB::beginTransaction();

        $compra = Compra::find($request->cmp_id);

        if ($compra->contasPagar->count() == 0) {
            foreach ($compra->insumos_compra as $insumoCompra) {
                $insumo = Insumo::find($insumoCompra->tb_insumos_ins_id);
                $insumo->ins_estoque = $insumo->ins_estoque - ($insumoCompra->icmp_quantidade);
                $insumo->save();

                $insumoCompra->delete();
            }
            $compra->delete();

            DB::commit();
            return redirect()->route('menu-compras')->with('success', 'Compra removida com sucesso!');
        } else {
            return redirect()->route('menu-compras')->with('failed', 'Compra não pode ser removida, existem contas a pagar relacionadas');
        }
    }

    public function buscarCompra(Request $request)
    {

        $fornecedor = null;
        $compras = null;

        if ($request->inputFiltro != null && $request->inputFiltro != '') {
            $fornecedor = Fornecedor::where('for_nome', 'LIKE', '%' . $request->inputFiltro . '%')->first();
            $compras = Compra::where('cmp_id', '=', $request->inputFiltro)
                ->orWhere('cmp_observacao', 'LIKE', '%' . $request->inputFiltro . '%');
            if ($fornecedor != null) {
                $compras = $compras->orWhere('tb_fornecedores_for_id', '=', $fornecedor->for_id);
            }
        } else {
            $compras = Compra::where('cmp_id', '!=', null);
        }

        if ($request->filtroDataInicio != null && $request->filtroDataFim != null) {
            $from = date('Y-m-d 00:00:00', strtotime($request->filtroDataInicio));
            $to = date('Y-m-d 23:59:59', strtotime($request->filtroDataFim));

            $compras = $compras->whereBetween('cmp_data', [$from, $to]);
        }

        $compras = $compras->get();

        return view('menu.compras.listar', ["compras" => $compras, "filtroDataInicio" => $request->filtroDataInicio, "filtroDataFim" => $request->filtroDataFim, "request" => $request]);
    }
}
