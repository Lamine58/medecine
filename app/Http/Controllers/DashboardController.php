<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Customer;
    use App\Models\Business;
    use App\Models\Contribution;
    use App\Models\Saving;
    use Illuminate\Support\Facades\Auth;

    class DashboardController extends Controller
    {
        public function index()
        {
            if(Auth::user()->account=='ADMINISTRATEUR'){
                $customers = Customer::all();
                $contributions = Contribution::all();
                $savings = Saving::all();
            }else{
                $customers = Customer::where('business_id',Auth::user()->business_id)->get();
                $contributions = Auth::user()->busines->contributions;
                $savings = Auth::user()->busines->savings;
            }

            $businesses = Business::all();
            
            return view('dashboard.index',compact('customers','contributions','savings','businesses'));
        }

    }