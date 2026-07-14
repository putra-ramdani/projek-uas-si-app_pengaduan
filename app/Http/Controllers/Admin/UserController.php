<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index(Request $request)
    {

        $users = User::query();


        if($request->search){

            $users->where(function($q) use ($request){

                $q->where('name','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%');

            });

        }


        if($request->role){

            $users->where('role',$request->role);

        }


        $users = $users->paginate(10);


        $totalAdmin = User::where('role','admin')->count();

        $totalTeknisi = User::where('role','teknisi')->count();

        $totalAktif = User::where('status','aktif')->count();


        return view('admin.users.index',
        compact(
            'users',
            'totalAdmin',
            'totalTeknisi',
            'totalAktif'
        ));

    }



    public function store(Request $request)
    {

        $request->validate([

            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'role'=>'required'

        ]);


        User::create([

            'name'=>$request->name,
            'username'=>strtolower(str_replace(' ','_',$request->name)),
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'no_telepon'=>$request->no_telepon,
            'role'=>$request->role,
            'status'=>'aktif'

        ]);


        return back()->with('success','User berhasil ditambahkan');

    }



    public function update(Request $request,$id)
    {

        $user=User::findOrFail($id);


        $user->update([

            'name'=>$request->name,
            'email'=>$request->email,
            'no_telepon'=>$request->no_telepon,
            'role'=>$request->role,
            'status'=>$request->status

        ]);


        return back();

    }



    public function destroy($id)
    {

        User::findOrFail($id)->delete();


        return back();

    }

}