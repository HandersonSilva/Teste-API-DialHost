<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    //
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'nome_fantasia',
        'seguimento',
        'cpf/cnpj',
        'email',
        'telefone',
    ];

}
