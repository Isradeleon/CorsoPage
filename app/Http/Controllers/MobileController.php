<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
use App\Casa;
use App\Llave;
use App\Cita;
use Carbon\Carbon;

class MobileController extends Controller {
	public function cancel_date($userid,$tokenid,$token,$dateid){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$cita=Cita::find($dateid);
			$key->token=str_random(50);
			$key->update();
			if ($cita) {
				if ($cita->status==1) {
					$cita->status=3;
					$cita->update();
				}
			}
			return [
				"Result"=>true,
				"NewToken"=>$key->token
			];
		}
		return [
			"Result"=>false
		];
    }

    public function successful_date($userid,$tokenid,$token,$dateid){
      	$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$cita=Cita::find($dateid);
			$key->token=str_random(50);
			$key->update();
			if ($cita) {
				if ($cita->status==1) {
					$cita->status=2;
					$cita->update();
				}
			}
			return [
				"Result"=>true,
				"NewToken"=>$key->token
			];
		}
		return [
			"Result"=>false
		];
    }
	
	public function check_date($dateid){
		$date=Cita::find($dateid);
		$date_day=new Carbon($date->fecha_hora);
		$date_day->second(0)->minute(0)->hour(0)->addDay();
		$today=Carbon::now("America/Monterrey");
		$today->second(0)->minute(0)->hour(0);
		$todayUp=Carbon::now("America/Monterrey");
		$todayUp->second(0)->minute(0)->hour(0)->addDay();

		$action=false;
		$success=false;
		
		if($date->status==1){
			if($date->fecha_hora>$today){
				$action=true;
			}
			if($date->fecha_hora>=$today && $date->fecha_hora<$todayUp){
				$success=true;
			}
		}
		return[
			"Action"=>$action,
			"Success"=>$success
		];
	}

	public function logout_mobile($tokenid){
		$key=Llave::find($tokenid);
		if($key){
			$key->delete();
			return ["Result"=>true];
		}
		return ["Result"=>false];
	}

	public function casas_mobile_1($userid,$tokenid,$token){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$key->token=str_random(50);
			$key->update();
			$casas=Casa::where("disponibilidad",1)->with("fotos")->get();
			$count=Casa::where("disponibilidad",1)->count();
			return [
				"Result"=>true,
				"NewToken"=>$key->token,
				"Count"=>$count,
				"Casas"=>$casas
			];
		}
		return ["Result"=>false];
	}

	public function casas_mobile_2($userid,$tokenid,$token){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$key->token=str_random(50);
			$key->update();
			$casas=Casa::where("disponibilidad",2)->with("fotos")->get();
			$count=Casa::where("disponibilidad",2)->count();
			return [
				"Result"=>true,
				"NewToken"=>$key->token,
				"Count"=>$count,
				"Casas"=>$casas
			];
		}
		return ["Result"=>false];
	}

	public function casas_mobile_3($userid,$tokenid,$token){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$key->token=str_random(50);
			$key->update();
			$casas=Casa::where("disponibilidad",3)->with("fotos")->get();
			$count=Casa::where("disponibilidad",3)->count();
			return [
				"Result"=>true,
				"NewToken"=>$key->token,
				"Count"=>$count,
				"Casas"=>$casas
			];
		}
		return ["Result"=>false];
	}

	public function ventas_mobile_1($userid,$tokenid,$token){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$key->token=str_random(50);
			$key->update();
			$ventas=$user->vendedor->ventas()
			->with(["casa.fotos","secretaria","cliente","documento"])
			->where("status",1)
			->orderBy("id","desc")
			->get();
			$count=$user->vendedor->ventas()
			->where("status",1)
			->count();
			return [
				"Result"=>true,
				"NewToken"=>$key->token,
				"Count"=>$count,
				"Ventas"=>$ventas
			];
		}
		return ["Result"=>false];
	}

	public function ventas_mobile_2($userid,$tokenid,$token){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$key->token=str_random(50);
			$key->update();
			$ventas=$user->vendedor->ventas()
			->with(["casa.fotos","secretaria","cliente","documento"])
			->whereIn("status",[2,3])
			->orderBy("id","desc")
			->get();
			$count=$user->vendedor->ventas()
			->whereIn("status",[2,3])
			->count();
			return [
				"Result"=>true,
				"NewToken"=>$key->token,
				"Count"=>$count,
				"Ventas"=>$ventas
			];
		}
		return ["Result"=>false];
	}

	public function citas_mobile_1($userid,$tokenid,$token){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$c=Carbon::now("America/Monterrey");
      		$c->second(0)->minute(0)->hour(0);
			$key->token=str_random(50);
			$key->update();
			$citas=$user->vendedor->citas()
			->with(["casa.fotos","secretaria","cliente"])
			->where("status",1)->orderBy("fecha_hora","asc")
			->where("fecha_hora",">",$c->toDateTimeString())
			->get();
			$count=$user->vendedor->citas()
			->where("status",1)->orderBy("fecha_hora","asc")
			->where("fecha_hora",">",$c->toDateTimeString())
			->count();
			return [
				"Result"=>true,
				"NewToken"=>$key->token,
				"Count"=>$count,
				"Citas"=>$citas
			];
		}
		return ["Result"=>false];
	}

	public function citas_mobile_2($userid,$tokenid,$token){
		$key=Llave::find($tokenid);
		$user=User::find($userid);
		if ($key && $key->token==$token && $user) {
			$c=Carbon::now("America/Monterrey");
      		$c->second(0)->minute(0)->hour(0);
			$key->token=str_random(50);
			$key->update();
			$citas=$user->vendedor->citas()
			->with(["casa.fotos","secretaria","cliente"])
			->whereIn("status",[2,3])
			->Orwhere("fecha_hora","<",$c->toDateTimeString())
     		->orderBy("fecha_hora","desc")
			->get();
			$count=$user->vendedor->citas()
			->whereIn("status",[2,3])
			->Orwhere("fecha_hora","<",$c->toDateTimeString())
      		->orderBy("fecha_hora","desc")
			->count();
			return [
				"Result"=>true,
				"NewToken"=>$key->token,
				"Count"=>$count,
				"Citas"=>$citas
			];
		}
		return ["Result"=>false];
	}

	public function login_mobile($email,$password)
	{
		$arrayE=explode("2",$email);
		$arrayP=explode("2",$password);

		$real_email=self::decryptStringNotReallyEncryptedYouKnow($arrayE);
		$real_pass=self::decryptStringNotReallyEncryptedYouKnow($arrayP);

		$userData=[
			"email"=>$real_email,
			"password"=>$real_pass
		];
		if (Auth::validate($userData)) {
			$user=User::where("email",$userData["email"])->first();
			if ($user->tipo_usuario==3) {
				$token=str_random(50);
				$key=new Llave();
				$key->token=$token;
				$key->save();
				return [
					"Result"=>true,
					"User"=>$user,
					"Vendedor"=>$user->vendedor,
					"Llave"=>$key
				];
			}
		}
		return ["Result"=>false];
	}

	private function decryptStringNotReallyEncryptedYouKnow($stringArray){
		$result="";
		foreach ($stringArray as $val) {
			 $result=$result.chr(bindec($val));
		}
		return $result;
	}
}
