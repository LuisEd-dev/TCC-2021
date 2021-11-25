<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'tb_vendas';
    protected $primaryKey = 'ven_id';

    protected $notFoundMessage = "Venda não encontrado";
    protected $fillable = ['tb_clientes_cli_id', 'ven_data', 'ven_observacao', 'ven_conta_lancada'];
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'tb_clientes_cli_id', 'cli_id');
    }

    public function produtos_venda()
    {
        return $this->hasMany(ProdutoVenda::class, 'tb_vendas_ven_id', 'ven_id');
    }

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class, 'tb_vendas_ven_id', 'ven_id');
    }

}
