<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller

{

    public function GoogleLogin(){
        return Socialite::driver('google')->redirect();
    }

    public function GoogleCallback(){
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('home');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => bcrypt('4paAj4l4h!22D3s3mber2022!'),
                ]);
                Auth::login($newUser);
                return redirect()->intended('home');
            }

        }
        catch (\Throwable $th) {}
    }
}

