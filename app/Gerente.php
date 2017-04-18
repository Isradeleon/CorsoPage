<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gerente extends Model
{
    use SoftDeletes;
    public $timestamps=false;
    protected $table="gerentes";

    public function user(){
      return $this->belongsTo('App\User','usuario_id');
    }
}
