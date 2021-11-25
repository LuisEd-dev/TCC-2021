<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\{ImagemProduto, Insumo};


class Produto extends Model
{
    use HasFactory;

    protected $table = 'tb_produtos';
    protected $primaryKey = 'prod_id';

    protected $notFoundMessage = "Produto não encontrado";
    protected $fillable = ['prod_nome', 'prod_descricao', 'prod_preco_custo', 'prod_preco_venda'];
    public $timestamps = false;

    public function imagens()
    {
        return $this->hasMany(ImagemProduto::class, 'tb_produtos_prod_id', 'prod_id');
    }

    public function insumosProduto()
    {
        return $this->hasMany(InsumoProduto::class, 'tb_produtos_prod_id', 'prod_id');
    }

    public function itemsVenda()
    {
        return $this->hasMany(ProdutoVenda::class, 'tb_produtos_prod_id', 'prod_id');
    }
}
