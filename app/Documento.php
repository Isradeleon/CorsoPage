<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table="documentos";
    public $timestamps=false;

    public function venta(){
      return $this->belongsTo('App\Venta','venta_id');
    }
}
