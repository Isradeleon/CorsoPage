<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    protected $table="clientes";
    public $timestamps=false;

    public function citas(){
      return $this->hasMany('App\Cita');
    }

    public function ventas(){
      return $this->hasMany('App\Venta');
    }
}
