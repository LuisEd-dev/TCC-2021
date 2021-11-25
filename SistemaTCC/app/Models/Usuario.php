<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'tb_usuarios';
    protected $primaryKey = 'usr_id';

    protected $notFoundMessage = "Usuário não encontrado";
    protected $fillable = ['usr_email', 'usr_senha', 'usr_nome', 'usr_status'];
    public $timestamps = false;

    public function lgpd()
    {
        return $this->hasOne(LGPD::class, 'tb_usuarios_usr_id', 'usr_id');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'tb_usuarios_usr_id', 'usr_id');
    }
}
