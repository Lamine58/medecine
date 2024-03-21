<?php

    namespace App\Http\Controllers\Api\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Customer;
    use Carbon\Carbon;
    use App\Mail\Otp;
    use Illuminate\Support\Facades\Mail;

    class AuthController extends Controller
    {

        public function login_center(Request $request)
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

                $user = Auth::user();
                return response()->json(["user"=>$user,"status"=>"success"], 200);

            } else {
                return response()->json(["message"=>"Identifiants invalides","status"=>"error"], 200);
            }
        }
        
        public function user(Request $request)
        {
            
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }

            $customer = Customer::findOrfail($request->id);
            return response()->json(["customer"=>$customer,"status"=>"success"], 200);
        }

        public function login(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $customer = Customer::where('email', $request->email)->where('state','SUCCESS')->first();
            
            if (!$customer) {
                return response()->json(['message' => 'Aucun compte n\'est lié a ce email',"status"=>"error"]);
            } else {

                $customer->hash = $this->hashed();
                $customer->save();
                // $this->sms('Bienvenue sur '.env('APP_NAME').' votre code de connexion est : '.$customer->hash,$request->phone);
                Mail::to($customer->email)->send(new Otp($customer->hash));

                return response()->json(['message' => "Connexion effectuée avec succès","customer"=>$customer,"status"=>"success"]);

            }
        }

        public function sign_in(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $customer = Customer::where('phone', $request->phone)->where('state','!=','PENDING')->first();
            
            if ($customer) {
                return response()->json(['message' => 'Ce compte existe déjà.',"status"=>"error"]);
            } else {

                    
                $customer = Customer::where('phone', $request->phone)->where('state','PENDING')->first();

                if(!$customer){
                    $customer = new Customer;
                    $customer->first_name = $request->first_name;
                    $customer->last_name = $request->last_name;
                    $customer->phone = $request->phone;
                    $customer->hash = $this->hashed();
                    $customer->state = 'PENDING';
                    $customer->save();
                }
                
                // $this->sms('Bienvenue sur '.env('APP_NAME').' votre code de confirmation est : '.$customer->hash,$request->phone);
                Mail::to($customer->email)->send(new Otp($customer->hash));

                return response()->json(['message' => 'Veuillez valider votre compte',"status"=>"success"]);

            }

        }
        

        public function send_code(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $customer = Customer::where('email', $request->email)->first();
            
            if (!$customer) {
                return response()->json(['message' => 'Ce compte n\'existe pas.',"status"=>"error"]);
            } else {

                // $this->sms('Bienvenue sur '.env('APP_NAME').' votre code de confirmation est : '.$customer->hash,$request->phone);
                Mail::to($customer->email)->send(new Otp($customer->hash));
                return response()->json(['message' => "Code renvoyé avec succès","status"=>"success"]);
            }

        }

        
        public function verify_code(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'hash' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $customer = Customer::where('email', $request->email)->where('hash', $request->hash)->first();
            
            if (!$customer) {
                return response()->json(['message' => 'Code invalide veuillez renvoyer un nouveau code',"status"=>"error"]);
            } else {
                $customer->state = 'SUCCESS';
                $customer->hash='HASH';
                $customer->save();
                return response()->json(['message' => "Compte activé avec succès","customer"=>$customer,"status"=>"success"]);
            }

        }

        public static function sms($message,$phone){

            $curl = curl_init();
            $greeting = date('H')>=12 ? 'Bonsoir' : 'Bonjour';
            $message = $greeting.' '.$message;

            $data = array("api_key" => "TLexO4btRYvSn30HrfgosIbtZGknV6rxT6Ip2cDtun2LReGLW641lbMJAxL6LS", "to" => $phone,  "from" => "UpDev",
            "sms" => $message,  "type" => "plain",  "channel" => "generic" );
            $post_data = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $post_data,
                CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
        }

        public static function hashed() {
            
            $hash = '';
        
            for ($i = 0; $i < 4; $i++) {
                $hash .= rand(0, 9);
            }
        
            return $hash;
        }

    }

