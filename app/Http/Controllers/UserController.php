<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterPost;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        return view('user.register');
    }

    public function register(UserRegisterPost $request){
        // validate済みのデータの取得
        $datum = $request->validated();
        $datum['password'] = Hash::make($datum['password']);
        
        try {
            $r = User::create($datum);
            $request->session()->flash('user_register_success', true);
            return redirect('/');
            } 
        catch(\Throwable $e) {
            echo $e->getMessage();
            exit;
            }       
    }
}