<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    function register(Request $request){
        $validator= Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(["status_code" => 400, "İstek Hatası"]);
        }

        $newUser = new User;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);
        $newUser->save();

        return response()->json(["status_code" => 200, "Başarıyla Kayıt Olundu"]);
    }

    function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(["status_code" => 400, "İstek Hatası"]);
        }

        $user = User::where('email', $request->email)->first(); //mail var mı ?

        if($user && Hash::check($request->password, $user->password)){ //mail varsa ve şifreler doğruysa
            return $user->createToken($request->device_name)->plainTextToken; //bu usere ait bir token yarat.
        }else{
            return response()->json(["status_code" => 401, "Kimlik doğrulaması başarısız"]);
        }

    }

    function getUser(Request $request){
        return Auth::user(); //Request deki Authorization daki Token bilgisinden usera ulaşır.
    }
}
