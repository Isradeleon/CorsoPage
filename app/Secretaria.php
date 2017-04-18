<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Secretaria extends Model
{
    use SoftDeletes;
    public $timestamps=false;
    protected $table="secretarias";

    public function user(){
      return $this->belongsTo('App\User','usuario_id');
    }

    public function citas(){
      return $this->hasMany('App\Cita');
    }

    public function ventas(){
      return $this->hasMany('App\Venta');
    }
}
