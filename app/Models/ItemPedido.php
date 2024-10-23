<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPedido extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id', 'product_id', 'quantidade'];

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
