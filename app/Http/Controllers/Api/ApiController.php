<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class ApiController extends Controller
    {

        public function __construct()
        {   
            $this->middleware('authorization');
        }

        public function users(Request $request)
        {
            return response()->json([User::all()], 401);
        }

    }