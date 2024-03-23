<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\TypeExam;
    use App\Models\TypeExamBusiness;
    use App\Models\Exam;
    use App\Models\Business;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;


    class TypeExamController extends Controller
    {
        public function index()
        {
            $business_id = null;

            if(Auth::user()->account=="ADMINISTRATEUR"){
                $type_exams = TypeExam::orderBy('created_at', 'desc')->paginate(10);
                $type = 'ADMINISTRATEUR';
            }else{
                $type_exams =  TypeExamBusiness::join('type_exams', 'type_exam_businesses.type_exam_id', '=', 'type_exams.id')
                    ->where('type_exam_businesses.business_id', Auth::user()->business_id)
                    ->select('type_exams.*') 
                    ->orderBy('created_at', 'desc')->paginate(10);
                $type = '!ADMINISTRATEUR';
                $business_id = Auth::user()->business_id;
            }
            return view('type_exam.index',compact('type_exams','type','business_id'));
        }

        
        public function exams()
        {
            $business_id = null;

            if(Auth::user()->account=="ADMINISTRATEUR"){
                $exams = Exam::orderBy('created_at', 'desc')->paginate(10);
                $type = 'ADMINISTRATEUR';
            }else{
                $business = Business::findOrfail(Auth::user()->business_id);
                $exams =  $business->exams->orderBy('created_at', 'desc')->paginate(10);
                $type = '!ADMINISTRATEUR';
                $business_id = Auth::user()->business_id;
            }
            return view('type_exam.exams',compact('exams','type','business_id'));
        }

        public function add($id)
        {
            $type_exam = TypeExam::find($id);

            if(!is_null($type_exam)){
                $title = "Modifier $type_exam->name";
            }else{
                $type_exam = new TypeExam;
                $title = 'Ajouter un type d\'examen';
            }

            return view('type_exam.save',compact('type_exam','title'));
        }

        
        public function type_exam_on_business(Request $request)
        {

            $validator = $request->validate([
                'frequence' => 'required|string',
                'business_id' => 'required|string',
                'type_exam_id' => 'required|string',
            ]);

            $data = $request->except(['_token','business_id','type_exam_id']);

            $type_exam_business = new TypeExamBusiness;
            $type_exam_business->type_exam_id = $request->type_exam_id;
            $type_exam_business->business_id = $request->business_id;
            $type_exam_business->availability = json_encode($data);
            $type_exam_business->user_id = Auth::user()->id;
            $type_exam_business->save();

            $type_exam = TypeExam::find($request->type_exam_id);
            $business = Business::find($request->business_id);

            return response()->json(['message' => "$type_exam->name ajouté à $business->legal_name","status"=>"success"]);
        }

        public function set_result(Request $request){
            
            $validator = $request->validate([
                'id' => 'required|string',
                'files' => 'required',
            ]);

            $exam = Exam::findOrFail($request->id);
            
            $files = $request->file('files');
            $_data = [];

            if ($files) {
                foreach ($files as $file) {
                    $filePath = $file->storeAs('public/files', $file->hashName());
                    $_data[] = str_replace('public/', '', $filePath);
                }
            }

            $exam->results = json_encode($_data);
            $exam->user_id = Auth::user()->id;
            $exam->save();

            return Redirect::back()->with('message', 'Resultat enregisté avec succès');

        }

        public function save(Request $request)
        {

            $validator = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price_xof' => 'required|numeric',
                'price_euro' => 'required|numeric',
                'price_usd' => 'required|numeric',
            ]);

            $data = $request->except(['data']);
            
            $data['user_id'] = Auth::user()->id;
            
            $type_exam = TypeExam::where('name', $data['name'])->where('id', '!=', $request->id)->first();
            
            if ($type_exam) {
                return response()->json(['message' => 'Cet examen existe déjà.',"status"=>"error"]);
            } else {
                $type_exam = TypeExam::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
            
            return response()->json(['message' => 'Type d\'examen enregistré avec succès',"status"=>"success"]);

        }

        public function delete(Request $request){

            $type_exam = TypeExam::find($request->id);

            if($type_exam->delete()){
                return response()->json(['message' => 'Type d\'examen supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function delete_type_exam_on_business(Request $request){

            $type_exam_business = TypeExamBusiness::find($request->id);

            if($type_exam_business->delete()){
                return response()->json(['message' => 'Examen retiré du centre avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de l\'operation veuillez réessayer',"status"=>"error"]);
            }
        }

        
    }