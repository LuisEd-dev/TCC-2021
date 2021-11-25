<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsumoVenda extends Model
{
    use HasFactory;

    protected $table = 'tb_insumos_venda';
    protected $primaryKey = 'insven_id';

    protected $notFoundMessage = "Insumo da venda não encontrado";
    protected $fillable = ['tb_itens_venda_iven_id', 'tb_insumos_ins_id', 'insven_consumo', 'insven_preco'];
    public $timestamps = false;

    public function itemVenda()
    {
        return $this->belongsTo(ProdutoVenda::class, 'tb_itens_venda_iven_id', 'iven_id');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'tb_insumos_ins_id', 'ins_id');
    }
}
