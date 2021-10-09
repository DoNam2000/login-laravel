<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    public function postlogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $set_sesion_user = [
                'id' => Str::random(40),
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User_Agent'),
                'payload' => Str::random(80),
                'last_activity' => Carbon::now()->getTimestamp()  
            ];
            
            DB::table('sessions')->insert($set_sesion_user); 

            return response()->json([
                'code' => 200,
                'message' => 'Đăng nhập thành công',
                'data' => $set_sesion_user 
            ],200);

        }else{
            return response()->json([
                'code' => 401,
                'message' => 'Đăng nhập không thành công',
            ],200);
        }
    }
}
