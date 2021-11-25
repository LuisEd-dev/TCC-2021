<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaPagar extends Model
{
    use HasFactory;

    protected $table = 'tb_contas_pagar';
    protected $primaryKey = 'contp_id';

    protected $notFoundMessage = "Conta a pagar não encontrada";
    protected $fillable = [
        'tb_fornecedores_for_id', 'tb_compras_cmp_id', 'contp_data', 'contp_data_venc', 'contp_data_pag',
        'contp_valor', 'contp_descricao', 'contp_num_parcela', 'contp_total_parcelas'
    ];

    public $timestamps = false;
}
