<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Customer;
    use App\Models\Business;
    use App\Models\Exam;
    use App\Models\Archive;
    use App\Models\OtherExam;
    
    class ApiController extends Controller
    {

        public function __construct()
        {   
            // $this->middleware('authorization');
        }

        public function customer_data(Request $request)
        {
                
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }

            $customer = Customer::findOrfail($request->id);

            $file = $request->file('avatar');

            if ($file) {
                $filePath = $file->storeAs('public/avatar', $file->hashName());
                $customer->avatar = $filePath ?? '';
                $customer->avatar = str_replace('public/','',$customer->avatar);
            }

            $customer->email = $request->email;
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->location = $request->location;
            $customer->weight = $request->weight;
            $customer->size = $request->size;
            $customer->medics = $request->medics;
            $customer->origin = $request->origin;
            $customer->situation = $request->situation;
            $customer->activity = $request->activity;
            $customer->diseases = $request->diseases;
            $customer->save();

            return response()->json(["customer"=>$customer,'message'=>"Informations enregistré avec succès","status"=>"success"], 200);
        }
  
        public function archive_customer(Request $request)
        {
                
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }

            $customer = Customer::findOrfail($request->id);
            foreach($customer->archives as $archive){
                $archive->other_exam;
                $archive->time = date('Y-m-d',strtotime($archive->created_at));
            }
            
            return response()->json(["archives"=>$customer->archives,"other_exam"=>OtherExam::all(),"status"=>"success"], 200);

        }

        public function exam_customer(Request $request)
        {
                
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }

            $customer = Customer::findOrfail($request->id);
            foreach($customer->exams as $exams){
                $exams->type_exam;
                $exams->results = json_decode($exams->results);
                $exams->time = $exams->date==null ? date('Y-m-d',strtotime($exams->created_at)) : date('Y-m-d',strtotime($exams->date));
            }
            
            return response()->json(["exams"=>$customer->exams,"status"=>"success"], 200);

        }
        
        public function add_exam(Request $request)
        {
                
            $validator = Validator::make($request->all(), [
                'type_exam_id' => 'required',
                'customer_id' => 'required',
                'business_id' => 'required',
                // 'order' => 'required',
                // 'card' => 'required',
                'files' => 'required',
                // 'date' => 'required',
                // 'code' => 'required',
                // 'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }

            $exam = new Exam;

            $files = $request->file('files');
            $_data = [];

            if ($files) {
                foreach ($files as $file) {
                    $filePath = $file->storeAs('public/files', $file->hashName());
                    $_data[] = str_replace('public/', '', $filePath);
                }
            }

            $exam->type_exam_id = $request->type_exam_id;
            $exam->customer_id = $request->customer_id;
            $exam->business_id = $request->business_id;
            $exam->order = $request->order;
            $exam->files = json_encode($_data);
            $exam->date = $request->date;
            $exam->code = $this->hashed();
            $exam->save();

            return response()->json(['message'=>"Informations enregistré avec succès","code"=>$exam->code,"status"=>"success"], 200);
        }
        
        public function add_exam_card(Request $request)
        {
                
            $validator = Validator::make($request->all(), [
                'type_exam_id' => 'required',
                'customer_id' => 'required',
                'business_id' => 'required',
                'files' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }

            $exam = new Exam;

            $files = $request->file('files');
            $_data = [];

            if ($files) {
                foreach ($files as $file) {
                    $filePath = $file->storeAs('public/files', $file->hashName());
                    $_data[] = str_replace('public/', '', $filePath);
                }
            }

            $exam->type_exam_id = $request->type_exam_id;
            $exam->customer_id = $request->customer_id;
            $exam->business_id = $request->business_id;
            $exam->order = $request->order;
            $exam->card = json_encode($_data);
            $exam->date = date('Y-m-d H:i:s',strtotime($request->date));
            $exam->code = $this->hashed();
            $exam->save();

            return response()->json(['message'=>"Informations enregistré avec succès","code"=>$exam->code,"status"=>"success"], 200);
        }
        
        public static function hashed() {
            
            $hash = '';
        
            for ($i = 0; $i < 6; $i++) {
                $hash .= rand(0, 9);
            }
        
            return $hash;
        }

        public function exam_center(Request $request)
        {   
            $businesses = Business::all();
            foreach($businesses as $business){
                $business->typeExams;
            }

            return response()->json(["centre"=>$businesses,"status"=>"success"], 200);
        }

        
        public function add_archive(Request $request)
        {
            
            $validator = $request->validate([
                'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:5048',
                'other_exam_id' => 'required|string',
                'customer_id' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
            ]);
            
            $file = $request->file('avatar');

            $archive = new Archive;

            if($file){
                $filePath = $file->storeAs('public/files', $file->hashName());
                $archive->file = $filePath ?? '';
                $archive->file = str_replace('public/','',$archive->file);
            }

            $archive->other_exam_id = $request->other_exam_id;
            $archive->customer_id = $request->customer_id;
            $archive->description = $request->description;
            $archive->date = date("Y-m-d",strtotime($request->date));
            $archive->save();
            
            return response()->json(['message' => 'Archive d\'examen enregistré avec succès',"status"=>"success"]);
        }

    }