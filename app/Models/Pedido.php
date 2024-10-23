<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'valor'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function itens(){
        return $this->hasMany(ItemPedido::class);
    }
}
