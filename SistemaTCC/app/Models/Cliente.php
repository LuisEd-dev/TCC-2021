<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'tb_clientes';
    protected $primaryKey = 'cli_id';

    protected $notFoundMessage = "Cliente não encontrado";
    protected $fillable = [
        'cli_nome', 'cli_tipo_pessoa', 'cli_cpf_cnpj', 'cli_rg_ie', 'cli_endereco',
        'cli_numero', 'cli_bairro', 'cli_cidade', 'cli_uf', 'cli_cep', 'cli_complemento',
        'cli_celular', 'cli_telefone', 'cli_email'
    ];

    public $timestamps = false;

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class, 'tb_clientes_cli_id', 'cli_id');
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'tb_clientes_cli_id', 'cli_id');
    }

}
