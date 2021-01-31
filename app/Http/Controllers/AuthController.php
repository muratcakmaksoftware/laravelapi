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
            'username' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(["status" => 0, "message" => "İstek Hatası"]);
        }

        if(User::where("email", $request->email)->exists()){
            return response()->json(["status" => 0, "message" => "This email address already exists."]);
        }

        if(User::where("username", $request->username)->exists()){
            return response()->json(["status" => 0, "message" => "This username already exists."]);
        }

        $newUser = new User;
        $newUser->username = $request->username;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);
        $newUser->save();

        return response()->json(["status" => 1, "message" => "Signed up successfully."]);
    }

    function login(Request $request){

        $validator = Validator::make($request->all(),[
            //'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(["status" => 0, "message" => "İstek Hatası"]);
        }

        $user = User::where('username', $request->username)->first(); //username var mı ?

        if($user && Hash::check($request->password, $user->password)){ //username varsa ve şifreler doğruysa
            return response()->json(["status" => 1, "token" => $user->createToken($request->device_name)->plainTextToken]); //bu usere ait bir token yarat.
        }else{
            return response()->json(["status" => 0, "message" => "Kimlik doğrulaması başarısız"]);
        }

    }

    function getUser(Request $request){
        return Auth::user(); //Request deki Authorization daki Token bilgisinden usera ulaşır.
    }

    function testapi(){
        return "test ok";
    }
}
