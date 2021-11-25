<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsumoCompra extends Model
{
    use HasFactory;

    protected $table = 'tb_itens_compra';
    protected $primaryKey = 'icmp_id';

    protected $notFoundMessage = "Item da venda não encontrado";
    protected $fillable = ['tb_compras_cmp_id', 'tb_insumos_ins_id', 'icmp_quantidade', 'icmp_preco'];
    public $timestamps = false;

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'tb_compras_cmp_id', 'cmp_id');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'tb_insumos_ins_id', 'ins_id');
    }
}
