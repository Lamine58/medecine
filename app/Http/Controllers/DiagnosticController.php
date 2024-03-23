<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Diagnostic;
    use Illuminate\Support\Facades\Auth;

    class DiagnosticController extends Controller
    {
        public function index()
        {
            $diagnostics = Diagnostic::orderBy('created_at', 'desc')->paginate(10);
            return view('diagnostic.index',compact('diagnostics'));
        }

        public function diagnostic($id)
        {
            $diagnostic = Diagnostic::find($id);

            if(!is_null($diagnostic)){
                $title = "Modifier $diagnostic->name";
            }

            $diagnostic->questions = json_decode($diagnostic->questions);
            $diagnostic->analyses = json_decode($diagnostic->analyses);
            

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
        
        public function data(Request $request)
        {
            $validator = $request->validate([
                'name' => 'required|string',
                'id' => 'required|string'
            ]);

            $diagnostic = Diagnostic::find($request->id);
            $diagnostic->name = $request->name;

            $data = [];
            for ($i=0; $i < count($request->analyses) ; $i++) { 
                $data[]=["signe"=>$request->signes[$i],"value"=>$request->values[$i],"analyse"=>$request->analyses[$i]];
            }
            $diagnostic->analyses = json_encode($data);

            $data = [];
            for ($i=0; $i < count($request->questions) ; $i++) { 
                $responses = [];
                for ($j=0; $j < count($request->responses[$i]); $j++) { 
                    $responses [] = ["reponse"=>$request->responses[$i][$j],"point"=>$request->points[$i][$j]];
                }
                if($i==0){
                    $data[]=[
                            "question"=>$request->questions[$i],
                            "type"=>$request->types[$i],
                            "responses"=>$responses,
                            "condition" => '',
                            "condition_value" => ''
                        ];
                }else{
                    $data[]=[
                        "question"=>$request->questions[$i],
                        "type"=>$request->types[$i],
                        "responses"=>$responses,
                        "condition" => $request->condition[$i-1] ?? '',
                        "condition_value" => $request->condition_value[$i-1] ?? ''
                    ];
                }
            }

            $diagnostic->questions = json_encode($data);

            if($diagnostic->save()){
                return response()->json(['message' => 'Enregistrement avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de l\'enregistrement veuillez réessayer',"status"=>"error"]);
            }

        }
    }