<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaReceber extends Model
{
    use HasFactory;

    protected $table = 'tb_contas_receber';
    protected $primaryKey = 'contr_id';

    protected $notFoundMessage = "Conta a receber não encontrada";
    protected $fillable = [
        'tb_clientes_cli_id', 'tb_vendas_ven_id', 'contr_data', 'contr_data_venc', 'contr_data_rec',
        'contr_valor', 'contr_descricao', 'contr_num_parcela', 'contr_total_parcelas'
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'tb_clientes_cli_id', 'cli_id');
    }

    public $timestamps = false;
}
