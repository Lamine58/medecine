<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Customer;
    use App\Models\Business;
    use Illuminate\Support\Facades\Auth;

    class CustomerController extends Controller
    {
        public function index()
        {
            $customers = Customer::paginate(10);
            return view('customer.index',compact('customers'));
        }

        public function add($id)
        {
            $customer = Customer::find($id);

            if(!is_null($customer)){
                $title = "Modifier $customer->fist_name $customer->last_name";
            }else{
                $customer = new Customer;
                $title = 'Ajouter un utilisateur';
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
                'password' => 'nullable|string|min:6|confirmed',
            ]);
            
            $data = $request->except(['avatar']);
            $customer = Customer::where('email', $data['email'])->where('id', '!=', $request->id)->first();
            
            $data['customer_id'] = Auth::user()->id ?? null;

            if ($customer) {
                return response()->json(['message' => 'L\'adresse e-mail est déjà utilisée.',"status"=>"error"]);
            } else {
                
                $file = $request->file('avatar');
                if ($file) {
                    $filePath = $file->storeAs('public/avatar', $file->hashName());
                    $data['avatar'] = $filePath ?? '';
                    $data['avatar'] = str_replace('public/','',$data['avatar']);
                }
            
                if ($request->filled('password')) {
                    $data['password'] = sha1($request->password);
                }else{
                    $customer = Customer::find($request->id);
                    $data['password'] = $customer->password;
                }

                $customer = Customer::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
            
            return response()->json(['message' => 'Utilisateur enregistré avec succès', 'status' => 'success']);
            

        }

        public function delete(Request $request){

            $customer = Customer::find($request->id);

            if($customer->delete()){
                return response()->json(['message' => 'Utilisateur supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }