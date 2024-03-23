<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Saving;
    use App\Models\Customer;
    use App\Models\Business;
    use App\Models\CustomerSaving;
    use Illuminate\Support\Facades\Auth;
    

    class SavingController extends Controller
    {
        public function index()
        {
            $business_id = null;

            if(Auth::user()->account=="ADMINISTRATEUR"){
                $savings = Saving::orderBy('created_at', 'desc')->paginate(10);
                $type = 'ADMINISTRATEUR';
            }else{
                $savings =  Saving::where('business_id', Auth::user()->business_id)
                    ->orderBy('created_at', 'desc')->paginate(10);
                $type = '!ADMINISTRATEUR';
                $business_id = Auth::user()->business_id;
            }
            return view('saving.index',compact('savings','type','business_id'));
        }

        public function add($id)
        {
            $saving = Saving::find($id);

            if(!is_null($saving)){
                $title = "Modifier $saving->name";
            }else{
                $saving = new Saving;
                $title = 'Ajouter une épargne';
            }

            return view('saving.save',compact('saving','title'));
        }

        
        public function saving_on_customer(Request $request)
        {

            $validator = $request->validate([
                'customer_id' => 'required|string',
                'saving_id' => 'required|string',
            ]);

            $data = $request->except(['_token','customer_id','saving_id']);

            $saving_customer = new SavingCustomer;
            $saving_customer->saving_id = $request->saving_id;
            $saving_customer->customer_id = $request->customer_id;
            $saving_customer->user_id = Auth::user()->id;
            $saving_customer->save();

            $saving = Saving::find($request->saving_id);
            $customer = Customer::find($request->customer_id);

            return response()->json(['message' => "$customer->first_name $customer->last_name ajouté à $saving->name","status"=>"success"]);
        }

        
        public function members($id)
        {
            $saving = Saving::find($id);
            
            if(Auth::user()->account=='ADMINISTRATEUR'){
                $customers = Customer::all();
            }else{
                $customers = Customer::where('business_id',Auth::user()->business_id);
            }

            return view('saving.members',compact('saving','customers'));
        }

        public function set_customer(Request $request){

            $existingCustomerSaving = CustomerSaving::where('customer_id', $request->customer_id)
                ->where('saving_id', $request->saving_id)
                ->first();

            $customer = Customer::find($request->customer_id);
            
            if ($existingCustomerSaving) {

                $existingCustomerSaving->delete();
                return response()->json(['message' => "$customer->first_name $customer->last_name retiré à l'épargne avec succès", "status" => "error"]);
                
            }else{

                $customer_saving = new CustomerSaving;
                $customer_saving->customer_id = $request->customer_id;
                $customer_saving->saving_id = $request->saving_id;
                $customer_saving->user_id = Auth::user()->id;

                $customer_saving->save();

                return response()->json(['message' => "$customer->first_name $customer->last_name ajouté à la cotisation avec succès", "status" => "success"]);
            }

        }

        public function save(Request $request)
        {

            $validator = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'period' => 'required|string',
                'amount' => 'required|numeric',
            ]);

            $data = $request->except(['data']);
            
            $data['user_id'] = Auth::user()->id;
            $data['business_id'] = Auth::user()->business_id ?? $request->business_id;
            
            $saving = Saving::updateOrCreate(
                ['id' => $request->id],
                $data
            );
            
            return response()->json(['message' => 'Epargne enregistré avec succès',"status"=>"success"]);

        }

        public function delete(Request $request){

            $saving = Saving::find($request->id);

            if($saving->delete()){
                return response()->json(['message' => 'Epargne supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function delete_saving_on_business(Request $request){

            $saving_customer = SavingBusiness::find($request->id);

            if($saving_customer->delete()){
                return response()->json(['message' => 'Epargne retiré du centre avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de l\'operation veuillez réessayer',"status"=>"error"]);
            }
        }

        
    }