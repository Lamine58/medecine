<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Business;
    use Illuminate\Support\Facades\Auth;

    class BusinessController extends Controller
    {
        public function index()
        {
            $businesses = Business::paginate(10);
            return view('business.index',compact('businesses'));
        }

        public function add($id)
        {
            $business = Business::find($id);

            if(!is_null($business)){
                $title = "Modifier $business->legal_name";
            }else{
                $business = new Business;
                $title = 'Ajouter un centre de santé';
            }

            return view('business.save',compact('business','title'));
        }

        public function save(Request $request)
        {
            
            $validator = $request->validate([
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'legal_name' => 'required|string',
                'phone' => 'required|string',
                'location' => 'required|string',
                'email' => 'required|email',
            ]);
            
            $data = $request->except(['logo']);
            
            $data['user_id'] = Auth::user()->id;
            
            $business = Business::where('email', $data['email'])->where('id', '!=', $request->id)->first();
            
            if ($business) {
                return response()->json(['message' => 'L\'adresse e-mail est déjà utilisée.',"status"=>"error"]);
            } else {
                $file = $request->file('logo');
                if($file){
                    $filePath = $file->storeAs('public/logo', $file->hashName());
                    $data['logo'] = $filePath ?? '';
                    $data['logo'] = str_replace('public/','',$data['logo']);
                }
                $business = Business::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
            
            return response()->json(['message' => 'Centre de santé enregistré avec succès',"status"=>"success"]);

        }

        public function delete(Request $request){

            $business = Business::find($request->id);

            if($business->delete()){
                return response()->json(['message' => 'Centre de santé supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }