<?php

namespace App\Http\Controllers;
use App\Models\User;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class loginController extends Controller
{
            public function register(Request $request){
                $dataValidate = Validator::make($request->all(),[
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:6',
                ]);
                if($dataValidate->fails()){
                    return response()->json([
                        'status_code'=>600,
                        'message'=>'Bad Request'
                    ]);
                }
                $user= new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save(); 

                return response()->json([
                    'status_code'=>200,
                    'message'=>'User Created Successfully'
                ]);
            }

            public function login(Request $request){

                $dataValidate = Validator::make($request->all(),[
                    'email'=> 'required|email',
                    'password' => 'required|min:6',
                ]);

                if($dataValidate->fails()){
                    return response()->json(['status_code'=>600, 'message'=>'Bad Request']);
                }

                $cred = request(['email','password']);

                if(!Auth::attempt($cred)){
                    return response()->json(['status_code'=> 500 , 'message'=>'Unauthorized']);
                }

                $user = User::where('email',$request->email)->first();

                $tokenResult = $user->createToken('authToken')->plainTextToken;

                return response()->json([
                    'status_code'=>200,
                    'token'=>$tokenResult
                ]);
            }

            public function logout(Request $request){
                $request->user()->currentAccessToken()->delete();
                return response()->json([
                    'status_code'=>200,
                    'message'=>'Token Deleted Successfully !'
                ]);
            }
}
