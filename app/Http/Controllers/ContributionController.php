<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Contribution;
    use App\Models\Customer;
    use App\Models\Business;
    use App\Models\CustomerContribution;
    use Illuminate\Support\Facades\Auth;
    

    class ContributionController extends Controller
    {
        public function index()
        {
            $business_id = null;

            if(Auth::user()->account=="ADMINISTRATEUR"){
                $contributions = Contribution::paginate(10);
                $type = 'ADMINISTRATEUR';
            }else{
                $contributions =  Contribution::where('business_id', Auth::user()->business_id)
                    ->paginate(10);
                $type = '!ADMINISTRATEUR';
                $business_id = Auth::user()->business_id;
            }
            return view('contribution.index',compact('contributions','type','business_id'));
        }

        public function add($id)
        {
            $contribution = Contribution::find($id);

            if(!is_null($contribution)){
                $title = "Modifier $contribution->name";
            }else{
                $contribution = new Contribution;
                $title = 'Ajouter une cotisation';
            }

            return view('contribution.save',compact('contribution','title'));
        }

        
        public function contribution_on_customer(Request $request)
        {

            $validator = $request->validate([
                'customer_id' => 'required|string',
                'contribution_id' => 'required|string',
            ]);

            $data = $request->except(['_token','customer_id','contribution_id']);

            $contribution_customer = new ContributionCustomer;
            $contribution_customer->contribution_id = $request->contribution_id;
            $contribution_customer->customer_id = $request->customer_id;
            $contribution_customer->user_id = Auth::user()->id;
            $contribution_customer->save();

            $contribution = Contribution::find($request->contribution_id);
            $customer = Customer::find($request->customer_id);

            return response()->json(['message' => "$customer->first_name $customer->last_name ajouté à $contribution->name","status"=>"success"]);
        }

        
        public function members($id)
        {
            $contribution = Contribution::find($id);
            
            if(Auth::user()->account=='ADMINISTRATEUR'){
                $customers = Customer::all();
            }else{
                $customers = Customer::where('business_id',Auth::user()->business_id);
            }

            return view('contribution.members',compact('contribution','customers'));
        }

        public function set_customer(Request $request){

            $existingCustomerContribution = CustomerContribution::where('customer_id', $request->customer_id)
                ->where('contribution_id', $request->contribution_id)
                ->first();

            $customer = Customer::find($request->customer_id);

            if ($existingCustomerContribution) {

                $existingCustomerContribution->delete();
                return response()->json(['message' => "$customer->first_name $customer->last_name retiré à la cotisation avec succès", "status" => "error"]);
                
            }else{

                $customer_contribution = new CustomerContribution;
                $customer_contribution->customer_id = $request->customer_id;
                $customer_contribution->contribution_id = $request->contribution_id;
                $customer_contribution->user_id = Auth::user()->id;

                $customer_contribution->save();

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
   
            $contribution = Contribution::updateOrCreate(
                ['id' => $request->id],
                $data
            );
            
            return response()->json(['message' => 'Cotisation enregistré avec succès',"status"=>"success"]);

        }

        public function delete(Request $request){

            $contribution = Contribution::find($request->id);

            if($contribution->delete()){
                return response()->json(['message' => 'Cotisation supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function delete_contribution_on_business(Request $request){

            $contribution_customer = ContributionBusiness::find($request->id);

            if($contribution_customer->delete()){
                return response()->json(['message' => 'Cotisation retiré du centre avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de l\'operation veuillez réessayer',"status"=>"error"]);
            }
        }

        
    }