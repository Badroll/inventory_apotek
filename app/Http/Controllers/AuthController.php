<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session, Hash;

class AuthController extends Controller
{
    public function __construct(){
        // $user = new User;
        // $user->nama = "Badrul";
        // $user->no_wa = "6281219992673";
        // $user->password = Hash::make("12345678");
        // $user->save();
    }


    public function dashboard(Request $request){
        return view("home");
    }

    public function profil(Request $request){
        $user = User::first();

        $data["user"] = $user;
        return view("profil", $data);
    }


    public function login(Request $request){
        return view("login");
    }


    public function doLogin(Request $request){
        $no_wa = $request->{"no_wa"};
        $password = $request->{"password"};
        if(!$password) return back()->with("error", "Parameter tidak lengkap (password)");
        if(!$no_wa) return back()->with("error", "Parameter tidak lengkap (no_wa)");
        $user = User::where("no_wa", $no_wa)->first();
        if(!$user){
            return back()->with("error", "User dengan nomor WA tersebut tidak ditemukan");
        }
        if(!Hash::check($password, $user->{"password"})){
            return back()->with("error", "Passsword salah");
        }
        Session::put("user", $user);
        
        return redirect(url("/"))->with("success", "Selamat datang " . $user->{"nama"});
    }


    public function update(Request $request){
        $id = $request->{"id"};
        $nama = $request->{"nama"};
        $no_wa = $request->{"no_wa"};
        $password = $request->{"password"};
        $password_new = $request->{"password_new"};
        //dd($request);
        if(!$id) return back()->with("error", "Parameter tidak lengkap (id)");
        if(!$nama) return back()->with("error", "Parameter tidak lengkap (nama)");
        if(!$no_wa) return back()->with("error", "Parameter tidak lengkap (no_wa)");
        $user = User::find($id)->first();
        if($password_new && $password_new != ""){
            if(!($password) || $password == ""){
                return back()->with("error", "Parameter tidak lengkap (password)");
            }
            if(!Hash::check($password, $user->{"password"})){
                return back()->with("error", "Passsword salah");
            }
            $user->password = Hash::make($password_new);
        }
        $user->nama = $nama;
        $user->no_wa = $no_wa;
        $user->save();
        Session::put("user", $user);
        
        return back()->with("success", "Profil berhasil disimpan");
    }


    public function logout(Request $request){
        Session::forget("user");
        return redirect(url("auth/login"))->with("info", "Anda telah logout");
    }


}
