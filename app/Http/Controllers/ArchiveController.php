<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Archive;
    use App\Models\OtherExam;
    use App\Models\Customer;
    use Illuminate\Support\Facades\Auth;

    class ArchiveController extends Controller
    {
        public function index($id)
        {
            $customer = Customer::find($id);
            $archives = $customer->archives()->paginate(10);
            return view('archive.index',compact('archives','customer'));
        }

        public function add($id,$customer_id)
        {
            $archive = Archive::find($id);

            if(!is_null($archive)){
                $title = "Modifier $archive->legal_name";
            }else{
                $archive = new Archive;
                $title = 'Ajouter une archive d\'examen';
            }

            $other_exams = OtherExam::paginate(10);

            return view('archive.save',compact('archive','title','other_exams','customer_id'));
        }

        public function save(Request $request)
        {
            
            $validator = $request->validate([
                'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:5048',
                'other_exam_id' => 'required|string',
                'customer_id' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
            ]);
            
            $data = $request->except(['file']);
            
            $data['user_id'] = Auth::user()->id;
       
            $file = $request->file('file');
            if($file){
                $filePath = $file->storeAs('public/files', $file->hashName());
                $data['file'] = $filePath ?? '';
                $data['file'] = str_replace('public/','',$data['file']);
            }
            $archive = Archive::updateOrCreate(
                ['id' => $request->id],
                $data
            );
            
            return response()->json(['message' => 'Archive d\'examen enregistré avec succès',"status"=>"success"]);
        }

        public function delete(Request $request){

            $archive = Archive::find($request->id);

            if($archive->delete()){
                return response()->json(['message' => 'Archive d\'examen supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }
    }