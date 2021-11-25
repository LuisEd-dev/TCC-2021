<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Produto, ImagemProduto, Insumo, InsumoProduto};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class ControllerProdutos extends Controller
{
    public function listarProduto(Request $request)
    {
        return view('menu.produtos.listar', ["produtos" => Produto::all(), "request" => $request]);
    }

    public function telaAdicionarProduto(Request $request)
    {
        return view('menu.produtos.adicionar', compact('request'));
    }

    public function adicionarProduto(Request $request)
    {
        DB::beginTransaction();
        $produto = new Produto;
        $produto->prod_nome = $request->nome;
        $produto->prod_descricao = $request->descricao;
        $produto->prod_preco_venda = number_format(str_replace(',', '.', str_replace('.', '', $request->venda)), 2, '.', '');
        $produto->prod_preco_custo = number_format(str_replace(',', '.', str_replace('.', '', $request->custo)), 2, '.', '');

        $produto->save();

        $imagem1 = new ImagemProduto;
        $imagem1->tb_produtos_prod_id = $produto->prod_id;
        $imagem1->pimg_url = $this->saveImage($request->img1, 'produtos', 250);
        $imagem1->pimg_index = 1;

        $imagem1->save();

        if ($request->img2 != null) {
            $imagem2 = new ImagemProduto;
            $imagem2->tb_produtos_prod_id = $produto->prod_id;
            $imagem2->pimg_url = $this->saveImage($request->img2, 'produtos', 250);
            $imagem2->pimg_index = 2;

            $imagem2->save();
        }

        if ($request->img3 != null) {
            $imagem3 = new ImagemProduto;
            $imagem3->tb_produtos_prod_id = $produto->prod_id;
            $imagem3->pimg_url = $this->saveImage($request->img3, 'produtos', 250);
            $imagem3->pimg_index = 3;

            $imagem3->save();
        }

        DB::commit();

        return redirect()->route('menu-produtos')->with('success', 'Produto adicionado com sucesso!');
    }

    public function removerProduto(Request $request)
    {
        DB::beginTransaction();

        $produto = Produto::find($request->prod_id);
        if ($produto->itemsVenda->count() == 0 && $produto->insumosProduto->count() == 0) {
            foreach ($produto->imagens as $imagen) {
                $imagen->delete();
            }
            $produto->delete();
            DB::commit();

            return redirect()->route('menu-produtos')->with('success', 'Produto removido com sucesso!');
        } else {
            return redirect()->route('menu-produtos')->with('failed', 'Produto não pode ser removido, existem insumos e/ou vendas relacionadas');
        }
    }

    public function buscarProduto(Request $request)
    {
        $produtos = Produto::where('prod_nome', 'LIKE', '%' . $request->inputFiltro . '%')
            ->orWhere('prod_descricao', 'LIKE', '%' . $request->inputFiltro . '%')
            ->get();

        return view('menu.produtos.listar', ["produtos" => $produtos, "request" => $request]);
    }

    public function telaEditarProduto(Request $request)
    {
        $produto = Produto::find($request->prod_id);

        $insumosProduto = InsumoProduto::where('tb_produtos_prod_id', '=', $produto->prod_id)->get();

        return view('menu.produtos.editar', [
            "produto" => $produto,
            "insumosProduto" => $insumosProduto,
            "request" => $request
        ]);
    }

    public function editarProduto(Request $request)
    {

        DB::beginTransaction();

        $produto = Produto::find($request->prod_id);

        if ($request->img1 != null) {
            if ($produto->imagens->where('pimg_index', '=', 1)->count() == 1) {
                $produto->imagens->where('pimg_index', '=', 1)->first()->delete();
            }

            $imagem1 = new ImagemProduto;
            $imagem1->tb_produtos_prod_id = $produto->prod_id;
            $imagem1->pimg_url = $this->saveImage($request->img1, 'produtos', 250);
            $imagem1->pimg_index = 1;
            $imagem1->save();
        }

        if ($request->img2 != null) {
            if ($produto->imagens->where('pimg_index', '=', 2)->count() == 1) {
                $produto->imagens->where('pimg_index', '=', 2)->first()->delete();
            }

            $imagem2 = new ImagemProduto;
            $imagem2->tb_produtos_prod_id = $produto->prod_id;
            $imagem2->pimg_url = $this->saveImage($request->img2, 'produtos', 250);
            $imagem2->pimg_index = 2;
            $imagem2->save();
        }

        if ($request->img3 != null) {
            if ($produto->imagens->where('pimg_index', '=', 3)->count() == 1) {
                $produto->imagens->where('pimg_index', '=', 3)->first()->delete();
            }

            $imagem3 = new ImagemProduto;
            $imagem3->tb_produtos_prod_id = $produto->prod_id;
            $imagem3->pimg_url = $this->saveImage($request->img3, 'produtos', 250);
            $imagem3->pimg_index = 3;
            $imagem3->save();
        }

        $produto->update([
            'prod_nome' => $request->nome,
            'prod_descricao' => $request->descricao,
            'prod_preco_venda' => number_format(str_replace(',', '.', str_replace('.', '', $request->venda)), 2, '.', ''),
            'prod_preco_custo' => number_format(str_replace(',', '.', str_replace('.', '', $request->custo)), 2, '.', ''),
        ]);

        DB::commit();

        return redirect()->route('menu-produtos')->with('success', 'Produto alterado com sucesso!');
    }

    public function saveImage($image, $type, $size)
    {
        if (!is_null($image)) {
            $file = $image;
            $extension = $image->getClientOriginalExtension();

            $fileName = time() . random_int(100, 999) . '.' . $extension;
            $destinationPath = public_path('images/' . $type . '/');
            $url = '/images/' . $type . '/' . $fileName;

            $fullPath = $destinationPath . $fileName;

            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0775, true);
            }

            $image = Image::make($file)
                ->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('jpg');
            $image->save($fullPath, 100);

            return $url;
        } else {
            return 'http://' . $_SERVER['HTTP_HOST'] . '/images/' . '/erro_imagem.png';
        }
    }
}
