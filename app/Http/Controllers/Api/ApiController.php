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
    use App\Models\Measure;
    use App\Models\OtherExam;
    use App\Models\Diagnostic;
    use App\Models\TypeExamBusiness;
    use App\Models\HistoryCustomer;
    use App\Models\TypeExam;
    use App\Mail\Reservation;
    use Illuminate\Support\Facades\Mail;

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

            if(!is_null($request->user_id)){
                $history_customer = new HistoryCustomer;
                $customer_data = Customer::find($request->id);
                $history_customer->customer_id = $request->id;
                $history_customer->before = json_encode($customer_data);
                $history_customer->panel = 'Application mobile';
                $history_customer->user_id = $request->user_id;
            }

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

            if(!is_null($request->user_id)){
                $history_customer->after = json_encode($customer);
                $history_customer->save();
            }
            
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

        public function measure_customer(Request $request)
        {
                
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }

            $customer = Customer::findOrfail($request->id);
            foreach($customer->measures as $measure){
                $measure->business;
                $measure->user;
                $measure->time = date('Y-m-d H:i:s',strtotime($measure->created_at));
            }
            
            return response()->json(["measures"=>$customer->measures,"status"=>"success"], 200);

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
                // 'files' => 'required',
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

            Mail::to($exam->business->email)->send(new Reservation($exam));

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

            Mail::to($exam->business->email)->send(new Reservation($exam));

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

        public function diagnostics(Request $request)
        {   
            $diagnostics = Diagnostic::all();
            foreach($diagnostics as $diagnostic){
                $diagnostic->questions = json_decode($diagnostic->questions);
                $diagnostic->analyses = json_decode($diagnostic->analyses);
                foreach($diagnostic->questions ?? [] as $data):
                    $data->option = '';
                    $data->value = '';
                    foreach($data->responses as $response):
                        $response->checked = false;
                    endforeach;
                endforeach;
            }

            return response()->json(["diagnostics"=>$diagnostics,"status"=>"success"], 200);
        }

        public function customers(Request $request)
        {   
            $customers = Customer::all();
            return response()->json(["customers"=>$customers,"status"=>"success"], 200);
        }

        public function exams(Request $request)
        {   
            $user = User::find($request->id);
            if($user->account=="ADMINISTRATEUR"){
                $exams = Exam::all();
            }else{
                $business = Business::findOrfail($user->business_id);
                $exams =  $business->exams;
            }

            foreach($exams as $exam){
                $exam->customer;
                $exam->type_exam;
                $exam->card = json_decode($exam->card);
                $exam->files = json_decode($exam->files);
                $exam->results = json_decode($exam->results);
            }

            return response()->json(["exams"=>$exams,"status"=>"success"], 200);
        }

        public function type_exams(Request $request)
        {   
            $user = User::find($request->id);

            if($user->account=="ADMINISTRATEUR"){
                $type_exams = TypeExam::all();
            }else{
                $type_exams =  TypeExamBusiness::join('type_exams', 'type_exam_businesses.type_exam_id', '=', 'type_exams.id')
                    ->where('type_exam_businesses.business_id', $user->business_id)
                    ->select('type_exams.*')->get();
            }
            

            return response()->json(["type_exams"=>$type_exams,"status"=>"success"], 200);
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

        public function add_measure(Request $request)
        {
            
            $validator = $request->validate([
                'systolic_bp' => 'required',
                'diastolic_bp' => 'required',
                'oxygen_saturation' => 'required',
                'heart_rate' => 'required',
                'heart_rhythm' => 'required',
                'customer_id' => 'required',
                'user_id' => 'required',
            ]);
            
            $measure = new Measure;

            $measure->systolic_bp = $request->systolic_bp;
            $measure->diastolic_bp = $request->diastolic_bp;
            $measure->oxygen_saturation = $request->oxygen_saturation;
            $measure->heart_rate = $request->heart_rate;
            $measure->heart_rhythm = $request->heart_rhythm;
            $measure->customer_id = $request->customer_id;
            $measure->user_id = $request->user_id;
            $measure->business_id = $request->business_id;
            $measure->save();
            
            return response()->json(['message' => 'Mesure enregistré avec succès',"status"=>"success"]);
        }

    }