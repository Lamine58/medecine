<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Archive;
    use App\Models\OtherExam;
    use App\Models\Customer;
    use Illuminate\Support\Facades\Auth;

    class MeasureController extends Controller
    {
        public function index($id)
        {
            $customer = Customer::find($id);
            $measures = $customer->measures()->orderBy('created_at', 'desc')->paginate(10);
            return view('measure.index',compact('measures','customer'));
        }
    }