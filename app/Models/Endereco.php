<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id', 'rua', 'numero', 'cep', 'cidade', 'estado' ,'complemento', 'forma_pagamento'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
