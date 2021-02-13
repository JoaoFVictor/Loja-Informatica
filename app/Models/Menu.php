<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'image',
        'icon',
        'descricao',
        'status',
        'categoria_id',
        'carregar_filhos'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function subCategoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id', 'pai');
    }

    public function categoria(){
        return $this->hasMany(Menu::class, 'pai');
    }
}
