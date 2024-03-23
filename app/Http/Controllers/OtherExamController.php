<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\OtherExam;
    use App\Models\OtherExamBusiness;
    use App\Models\Exam;
    use App\Models\Business;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;


    class OtherExamController extends Controller
    {
        public function index()
        {
            $other_exams = OtherExam::orderBy('created_at', 'desc')->paginate(10);
            return view('other_exam.index',compact('other_exams'));
        }

        public function add($id)
        {
            $other_exam = OtherExam::find($id);

            if(!is_null($other_exam)){
                $title = "Modifier $other_exam->name";
            }else{
                $other_exam = new OtherExam;
                $title = 'Ajouter un examen';
            }

            return view('other_exam.save',compact('other_exam','title'));
        }

        public function save(Request $request)
        {

            $validator = $request->validate([
                'name' => 'required|string',
            ]);

            $data = $request->except(['data']);
            
            $data['user_id'] = Auth::user()->id;
            
            $other_exam = OtherExam::where('name', $data['name'])->where('id', '!=', $request->id)->first();
            
            if ($other_exam) {
                return response()->json(['message' => 'Cet examen existe déjà.',"status"=>"error"]);
            } else {
                $other_exam = OtherExam::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );
            }
            
            return response()->json(['message' => 'Examen enregistré avec succès',"status"=>"success"]);

        }

        public function delete(Request $request){

            $other_exam = OtherExam::find($request->id);

            if($other_exam->delete()){
                return response()->json(['message' => 'Examen supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }