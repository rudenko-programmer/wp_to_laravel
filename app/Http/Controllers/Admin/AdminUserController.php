<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function allUser(){
        $users = User::orderBy('login','asc')->get();
        return view('adminpanel.user.allusers')->withUsers($users);
    }
    
    public function getUser($user_id){
        $user = User::findOrFail($user_id);


        if(!$user){abort(404);}
        $code = session('code')?session('code'):"0";

        return view('adminpanel.user.edituser')
            ->withUser($user)
            ->withCode($code);
    }
    
    public function newUser(){
        return view('adminpanel.user.newuser');
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function createUser(Request $request){
        $validate = $this->validate($request, [
            'first_name' => 'required|max:255',
            'second_name' => 'max:25',
            'third_name' => 'max:25',
            'login' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);
        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name!=null?$request->second_name:'',
            'third_name' => $request->third_name!=null?$request->third_name:'',
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'login' => $request->login,
            'role' => $request->role,
        ]);

        return redirect('/adminpanel/user/'.$user->user_id);

    }
    
    public function editUser(Request $request){
        $validate = $this->validate($request, [
            'first_name' => 'required|max:255',
            'second_name' => 'max:25',
            'third_name' => 'max:25',
            'email' => 'required|email|max:255|'.Rule::unique('users')->ignore($request->user_id, 'user_id'),
        ]);

        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }
        $user = User::findOrFail($request->user_id);
        $user->first_name = $request->first_name;
        $user->second_name = $request->second_name!=null?$request->second_name:'';
        $user->third_name = $request->third_name!=null?$request->third_name:'';
        $user->email = $request->email;
        $user->save();

        return redirect('/adminpanel/user/'.$user->user_id);
    }
}
