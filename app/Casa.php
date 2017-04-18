<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    protected $table="casas";
    public $timestamps=false;

    public function citas(){
      return $this->hasMany('App\Cita');
    }

    public function ventas(){
      return $this->hasMany('App\Venta');
    }

    public function fotos(){
      return $this->hasMany('App\Foto');
    }
}
