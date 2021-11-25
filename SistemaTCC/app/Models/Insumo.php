<?php

namespace App\Models;

use App\Models\InsumoVenda;
use App\Models\InsumoProduto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'tb_insumos';
    protected $primaryKey = 'ins_id';

    protected $notFoundMessage = "Insumo não encontrado";
    protected $fillable = ['ins_nome', 'ins_descricao', 'ins_preco', 'ins_estoque', 'ins_consumo'];
    public $timestamps = false;

    public function insumosProdutos()
    {
        return $this->hasMany(InsumoProduto::class, 'tb_insumos_ins_id', 'ins_id');
    }

    public function insumosVenda()
    {
        return $this->hasMany(InsumoVenda::class, 'tb_insumos_ins_id', 'ins_id');
    }

    public function insumosCompra()
    {
        return $this->hasMany(InsumoCompra::class, 'tb_insumos_ins_id', 'ins_id');
    }
}
