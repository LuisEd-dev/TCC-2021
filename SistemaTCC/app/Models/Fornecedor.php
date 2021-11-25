<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'tb_fornecedores';
    protected $primaryKey = 'for_id';

    protected $notFoundMessage = "Fornecedor não encontrado";
    protected $fillable = [
        'for_nome', 'for_tipo_pessoa', 'for_cpf_cnpj', 'for_rg_ie', 'for_endereco',
        'for_numero', 'for_bairro', 'for_cidade', 'for_uf', 'for_cep', 'for_complemento',
        'for_celular', 'for_telefone', 'for_email'
    ];

    public $timestamps = false;

    public function contasPagar()
    {
        return $this->hasMany(ContaPagar::class, 'tb_fornecedores_for_id', 'for_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'tb_fornecedores_for_id', 'for_id');
    }

}
