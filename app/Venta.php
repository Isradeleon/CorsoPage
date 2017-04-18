<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table="ventas";
    public $timestamps=true;

    public function cliente(){
      return $this->belongsTo('App\Cliente','cliente_id')->withTrashed();
    }

    public function secretaria(){
      return $this->belongsTo('App\Secretaria','secretaria_id')->withTrashed();
    }

    public function vendedor(){
      return $this->belongsTo('App\Vendedor','vendedor_id')->withTrashed();
    }

    public function casa(){
      return $this->belongsTo('App\Casa','casa_id');
    }

    public function notario(){
      return $this->belongsTo('App\Notario','notario_id')->withTrashed();
    }

    public function documento(){
      return $this->hasOne('App\Documento','venta_id');
    }
}
