<?php

    namespace App\Http\Controllers\Api\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use Carbon\Carbon;

    class AuthController extends Controller
    {

        public function login(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {

                if(Auth::user()->account == 'ENQUETEUR'){

                    $token = auth()->user()->createToken('auth.user',['*'],Carbon::now()->addhours(1))->accessToken;
                    $user = Auth::user();

                    return response()->json(["user"=>$user,"token"=>$token->token,"status"=>"success"], 200);
                }else{
                    Auth::logout();
                    return response()->json(['message' => 'Identifiants invalides', 'status' => 'error'], 401);
                }

            } else {
                return response()->json(["message"=>"Identifiants invalides","status"=>"error"], 401);
            }
        }

    }

