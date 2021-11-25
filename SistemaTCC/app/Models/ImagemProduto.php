<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Produto;

class ImagemProduto extends Model
{
    use HasFactory;

    protected $table = 'tb_img_prod';
    protected $primaryKey = 'pimg_id';

    protected $notFoundMessage = "Imagem não encontrada";
    protected $fillable = ['tb_produtos_prod_id', 'pimg_url', 'pimg_index'];

    public $timestamps = false;

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'tb_produtos_prod_id', 'pimg_id');
    }
}
