<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Diagnostic;
    use Illuminate\Support\Facades\Auth;

    class DiagnosticController extends Controller
    {
        public function index()
        {
            $diagnostics = Diagnostic::paginate(10);
            return view('diagnostic.index',compact('diagnostics'));
        }

        public function diagnostic($id)
        {
            $diagnostic = Diagnostic::find($id);

            if(!is_null($diagnostic)){
                $title = "Modifier $diagnostic->name";
            }

            return view('diagnostic.diagnostic',compact('diagnostic','title'));
        }

        public function save(Request $request)
        {
            
            $validator = $request->validate([
                'name' => 'required|string',
            ]);
            
            $data = $request->except([]);
            
            $data['user_id'] = Auth::user()->id;
            
            $diagnostic = Diagnostic::where('name', $data['name'])->where('id', '!=', $request->id)->first();
            
            if ($diagnostic) {
                return response()->json(['message' => 'Diagnostique existe déjà.',"status"=>"error"]);
            } else {
                $diagnostic = Diagnostic::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
            
            return response()->json(['message' => 'Diagnostique enregistré avec succès',"status"=>"success"]);

        }

        public function delete(Request $request){

            $diagnostic = Diagnostic::find($request->id);

            if($diagnostic->delete()){
                return response()->json(['message' => 'Diagnostique supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }