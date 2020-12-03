<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function Registro(Request $request){
        $request->validate([
            'email'=>'required|email', 
            'password'=>'required', 
            'name'=>'required'
     ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if($user->save()){
            return response()->json(["Usuario Registrado:"=>$user],200);
        }
        return response()->json("Error al registrar",400);
    }

    public function LogIn(Request $request)
    {
    $request->validate([
        'email'=>'required|email',
        'password'=>'required',
    ]);
    $user=User::where('email',$request->email)->first();

    if(!$user || !Hash::check($request->password, $user->password)){
        throw ValidationException::withMessages([
            'email|password'=>['Datos Incorrectos']
        ]);
    }  
       /* $token=$user->createToken($request->email, ['admin:admin'])->plainTextToken;*/ 
        return response()->json(["Validacion"=>1],201);
    }

    public function Datos(Request $request){
        $user=User::find($request->id);
        return response()->json($user);
    }
}
