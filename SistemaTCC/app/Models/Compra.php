<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'tb_compras';
    protected $primaryKey = 'cmp_id';

    protected $notFoundMessage = "Compra não encontrado";
    protected $fillable = ['tb_fornecedores_for_id', 'cmp_data', 'cmp_observacao', 'cmp_conta_lancada'];
    public $timestamps = false;

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'tb_fornecedores_for_id', 'for_id');
    }

    public function insumos_compra()
    {
        return $this->hasMany(InsumoCompra::class, 'tb_compras_cmp_id', 'cmp_id');
    }

    public function contasPagar()
    {
        return $this->hasMany(ContaPagar::class, 'tb_compras_cmp_id', 'cmp_id');
    }
}
