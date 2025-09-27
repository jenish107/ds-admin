<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAjaxController extends Controller
{
    public function index(){
        return view('user.index');
    }
 
    public function list(Request $request){
        
        $users = User::get();
        
        $data = $users->map(function($user){
            return[
                "id"=>$user->id,
                "email"=>$user->email,
                "userName"=>$user->userName,
                "first_name"=>$user->first_name,
                "last_name"=>$user->last_name,
                "number"=>$user->number,
                "zipcode"=>$user->zipcode,
                'action'=>"
                    <div>
                        <button class='edit btn btn-info' data-bs-toggle='modal' data-bs-target='#exampleModal' data-url=". route('user.show',['id'=> $user->id]) .">edit</button>
                        <button class='delete btn btn-danger' data-url=".route('user.destroy',['id'=> $user->id]).">delete</button>
                    </div>
                ",
            ];
        });
        return response()->json([
            'draw' => intval($request->input('draw')),
            'data'=>$data,
        ]);
    }
    public function save(Request $request){

        return response()->json([
            'success' => true,
            'data'    => $request->all()
        ]); 
       $validate = $request->validate([
        'userName'   => 'required',
        'email'      => 'required',
        'number'     => 'required',
        'zipcode'    => 'required',
        'first_name' => 'required',
        'password' => 'required',
        'last_name'  => 'required',
       ]);
       
        $user = User::updateOrCreate(
            [
                'id' => $request->input('user_id'),
            ],
            [
                'first_name'=> $validate['first_name'],
                'last_name' => $validate['last_name'],
                'userName'  =>  $validate['userName'],
                'email'     =>  $validate['email'],
                'password'     =>  $validate['password'],
                'number'    =>  $validate['number'],
                'zipcode'   =>  $validate['zipcode'],
            ]
        );

        return response()->json(['message'=>'data is updated','user'=>$user]);  
    }

    public function show($id){
        $user = User::find($id);
        return $user;  
    }
    public function destroy($id){
       return User::where('id',$id)->delete();
    }
}
