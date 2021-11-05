<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Dependente extends Model
{
    protected $table = 'dependentes_pessoas';
    use Notifiable;
    use SoftDeletes;

}
