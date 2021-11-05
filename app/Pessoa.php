<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Pessoa extends Model
{
    protected $table = 'pessoas';
    use Notifiable;
    use SoftDeletes;

    public function dependentes()
    {
        return $this->hasMany(Dependente::class, 'pessoa_id');
    }

    public function getPathImg(){
        if($this->url_foto){
            return $this->url_foto;
        }else{
            return url('/img/avatar-default.jpg');
        }
    }

}
