<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoVenda extends Model
{
    use HasFactory;

    protected $table = 'tb_itens_venda';
    protected $primaryKey = 'iven_id';

    protected $notFoundMessage = "Item da venda não encontrado";
    protected $fillable = ['tb_vendas_ven_id', 'tb_produtos_prod_id', 'iven_quantidade', 'iven_venda', 'iven_custo'];
    public $timestamps = false;

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'tb_vendas_ven_id', 'ven_id');
    }

    public function insumosVenda()
    {
        return $this->hasMany(InsumoVenda::class, 'tb_itens_venda_iven_id', 'iven_id');
    }
}
