<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'tb_agendas';
    protected $primaryKey = 'agd_id';

    protected $notFoundMessage = "Agenda não encontrado";
    protected $fillable = [
        'tb_usuarios_usr_id','agd_titulo', 'agd_descricao', 'agd_data', 'agd_cor'
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'tb_usuarios_usr_id', 'usr_id');
    }

}
