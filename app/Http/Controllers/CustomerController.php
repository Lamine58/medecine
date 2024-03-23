<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Customer;
    use App\Models\Business;
    use App\Models\HistoryCustomer;
    use Illuminate\Support\Facades\Auth;

    class CustomerController extends Controller
    {
        public function index()
        {
            $customers = Customer::orderBy('created_at', 'desc')->paginate(10);
            return view('customer.index',compact('customers'));
        }

        public function history($id)
        {
            $customer = Customer::find($id);
            $history_customers = $customer->history_customers()->orderBy('created_at', 'desc')->paginate(10);
            return view('customer.history',compact('history_customers','customer'));
        }

        public function add($id)
        {
            $customer = Customer::find($id);

            if(!is_null($customer)){
                $title = "Modifier $customer->fist_name $customer->last_name";
            }else{
                $customer = new Customer;
                $title = 'Ajouter un patient';
            }

            $businesses = Business::all();
            return view('customer.save',compact('customer','title','businesses'));
        }
        
        public function save(Request $request)
        {
            
            $validator = $request->validate([
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'location' => 'required|string',
                'weight' => 'required|string',
                'size' => 'required|string',
                'medics' => 'required|string',
                'origin' => 'required|string',
                'situation' => 'required|string',
                'activity' => 'required|string',
            ]);
            
            if(!is_null($request->id)){
                $history_customer = new HistoryCustomer;
                $customer_data = Customer::find($request->id);
                $history_customer->customer_id = $request->id;
                $history_customer->before = json_encode($customer_data);
                $history_customer->panel = 'Application web';
                $history_customer->user_id = Auth::user()->id;
            }

            $data = $request->except(['avatar']);

            $customer = Customer::where('email', $data['email'])->where('id', '!=', $request->id)->first();
            
            if ($customer) {
                return response()->json(['message' => 'L\'adresse e-mail est déjà utilisée.',"status"=>"error"]);
            }
            
            $customer = Customer::where('phone', $data['phone'])->where('id', '!=', $request->id)->first();
            
            if ($customer) {
                return response()->json(['message' => 'Le téléphone est déjà utilisée.',"status"=>"error"]);
            }
                
            $file = $request->file('avatar');

            $data['state'] = 'SUCCESS';
            $data['hash'] = 'HASH';

            if ($file) {
                $filePath = $file->storeAs('public/avatar', $file->hashName());
                $data['avatar'] = $filePath ?? '';
                $data['avatar'] = str_replace('public/','',$data['avatar']);
            }
        
            $customer = Customer::updateOrCreate(
                ['id' => $request->id],
                $data
            );

            if(!is_null($request->id)){
                $history_customer->after = json_encode($customer);
                $history_customer->save();
            }
        
            return response()->json(['message' => 'Patient enregistré avec succès', 'status' => 'success']);
            

        }

        public function delete(Request $request){

            $customer = Customer::find($request->id);

            if($customer->delete()){
                return response()->json(['message' => 'Patient supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
        
        // public function reservation(){
        //     $reservation = 'reservation';
        //     return view('mail.reservation',compact('reservation'));
        // }
    }