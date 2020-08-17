<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\controller;

class usercontroller extends Controller
{
    
function insertData(Request $user)
{
    $name=  $user->name;
    $email= $user->email;
    $mobile= $user->mobile;
    $password=$user->password;
    
    $user=DB::table('register')->insert(['name'=>$name,'email'=>$email,'mobile'=>$mobile,
    	'password'=>$password]);
    if($user){
    	return response()->json(array('message'=>'insert successfully'));

    }

    else{
    	return response()->json(array('message'=>'failed'));
    }

}
function getData(){
    $users=DB::table('register')->get();
    return response()->json(array('data'=>$users));
}

function fetchUser($id){
        
  $id=DB::table('register')->find($id);
  return response()->json(array('data'=>$id));

}
function deleteUser(Request $user){

    $id=$user->id;
    $user=DB::table('register')->where('id',$id)->delete();



    if($user){
        return response()->json(array('message'=>'delete successfully'));

    }

    else{
        return response()->json(array('message'=>'failed'));
    }
}

function updateData(Request $user)
{   
    $id= $user->id;
    $name=  $user->name;
    $email= $user->email;
    $mobile= $user->mobile;
    $password=$user->password;
    
    $user=DB::table('register')->where('id',$id)->update(['name'=>$name,'email'=>$email,
        'mobile'=>$mobile,'password'=>$password]);

    if($user){
        return response()->json(array('message'=>'update successfully'));

    }

    else{
        return response()->json(array('message'=>'failed'));
    }

}
   




// function index(Request $req){
//     $req->validate([
//          'username'=>'required'
//         'date'=>'required',
//         'amount' =>'required|regex:/^\d+(\.\d{1,2})?$/',
//         'description' => 'required |min:5 |max:20',



//     ]);
//     return $req->input();

// }

 function fetchUserr(){
        
  $name=DB::table('register')->get();
  return view('invoice',compact('name'));

    }

    function insertuser(Request $request)
   {

    // dd($user);
     $this->validate($request, [
          'username' => 'required',
          'date' => 'required',
          'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
          'description' => 'required'
      ]);
    $userId=$request->username;
    $date= $request->date;
    $amount= $request->amount;
    $description=$request->description;
    $data=['user_id'=>$userId,'date'=>$date,'amount'=>$amount,'description'=>$description];
    
    $user=DB::table('invoice')->insert($data);
      
      if($user){
        return response()->json(array('message'=>'insert successfully'));

    }

    else{
        return response()->json(array('message'=>'failed'));
    }


}
function getuser(){
    $users=DB::table('invoice')->get();
    return response()->json(array('data'=>$users));
}

function deleteData(Request $user){

    $id=$user->id;
    $user=DB::table('invoice')->where('id',$id)->delete();



    if($user){
        return response()->json(array('message'=>'delete successfully'));

    }

    else{
        return response()->json(array('message'=>'failed'));
    }
}

   function fetchData($id){
        
  $id=DB::table('invoice')->find($id);
  return response()->json(array('data'=>$id));

}  
function updateUser(Request $user)
{   
    $id= $user->id;
    $userId=$user->username;
    $name=  $user->name;
    $date= $user->date;
    $amount= $user->amount;
    $description=$user->description;
    
    $user=DB::table('invoice')->where('id',$id)->update(['user_id'=>$userId,'date'=>$date,'amount'=>$amount,'description'=>$description]);

    if($user){
        return response()->json(array('message'=>'update successfully'));

    }

    else{
        return response()->json(array('message'=>'failed'));
    }

}



// public function store(Request $request) {
//       $this->validate($request, [
//           'username' => 'required',
//           'date' => 'required|date_format:d/m/Y',
//           'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
//           'description' => 'required'
//       ]);
//       return response()->json();

 
// }

}

