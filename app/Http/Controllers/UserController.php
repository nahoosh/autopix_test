<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
   public function create()
    {
        return view('create');
    }
        public function delete($id)
    {
        $delete = DB::table('userDetails')->where('id',$id)->delete();

        return redirect('list');

    }
    public function insert(Request $request)
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $email = $request->input('email');

        $insertData = [

            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
        ];

        $insert = DB::table('userDetails')->insert($insertData);

    }
    public function edit($id)
    {
        $data['user'] = DB::table('userDetails')->where('id',$id)->first();
        return view('edit',$data);
    }

   public function update(Request $request)
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $email = $request->input('email');

        $affected = DB::table('userDetails')
              ->where('email', $email)
              ->update(['firstName' => $firstName,'lastName'=>$lastName]);

    }

    public function list()
    {
        $data['users'] = DB::table('userDetails')->get();
        return view('list', $data);
    }
}




