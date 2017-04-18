<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendedor extends Model
{
    use SoftDeletes;
    public $timestamps=false;
    protected $table="vendedores";

    public function user(){
      return $this->belongsTo('App\User','usuario_id');
    }

    public function ventas(){
      return $this->hasMany('App\Venta',"vendedor_id");
    }

    public function citas(){
      return $this->hasMany('App\Cita');
    }
}
