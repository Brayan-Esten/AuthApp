<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function handleCallback($provider){

        try{
            $providerUser = Socialite::driver($provider)->user();
        }
        catch(Exception $e){
            return redirect('/login');
        }

        $user = User::where([
            'provider_id' => $providerUser->getId(),
            'provider' => $provider
        ])->first();


        if(!$user){

            $validate = Validator::make(
                ['email' => $providerUser->getEmail()],
                ['email' => ['unique:users,email']],
                ['email.unique' => 'Could not login. Maybe you used a different login method ?']
            );

            if($validate->fails()){
                return redirect('/login')->withErrors($validate);
            }

            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'provider_id' => $providerUser->getId(),
                'provider' => $provider,
                'email_verified_at' => now()
            ]);
        }
        
        Auth::login($user);
        return redirect('/');
    }

}
