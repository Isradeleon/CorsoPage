<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notario extends Model
{
    use SoftDeletes;
    protected $table="notarios";
    public $timestamps=false;

    public function ventas(){
      return $this->hasMany('App\Venta','notario_id');
    }
}
