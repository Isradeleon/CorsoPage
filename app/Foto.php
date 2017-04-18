<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    public $timestamps=false;
    protected $table="fotos_casa";

    public function casa(){
      return $this->belongsTo('App\Casa','casa_id');
    }
}
