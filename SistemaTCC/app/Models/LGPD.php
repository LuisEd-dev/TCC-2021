<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LGPD extends Model
{
    use HasFactory;

    protected $table = 'tb_lgpd';
    protected $primaryKey = 'lgpd_id';

    protected $notFoundMessage = "LGPD não encontrada";
    protected $fillable = ['tb_usuarios_usr_id', 'lgpd_data'];
    public $timestamps = false;
}
