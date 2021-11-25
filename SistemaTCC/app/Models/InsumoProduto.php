<?php

namespace App\Models;

use App\Models\Produto;
use App\Models\InsumoVenda;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsumoProduto extends Model
{
    use HasFactory;

    protected $table = 'tb_insumos_produto';
    protected $primaryKey = 'insprod_id';

    protected $notFoundMessage = "Insumo do produto não encontrado";
    protected $fillable = ['tb_produtos_prod_id', 'tb_insumos_ins_id'];
    public $timestamps = false;

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'tb_produtos_prod_id', 'prod_id');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'tb_insumos_ins_id', 'ins_id');
    }
}
