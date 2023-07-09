<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{

    public function twitchLoginCallback(Request $request)
    {
        $user = null;
        try {
            $twitchUser = Socialite::driver('twitch')->user();
        } catch (\Exception $exception) {
            throw $exception;
        }

        if ($twitchUser) {
            if (!User::where('email', $twitchUser->email)->first()) {
                $password = Hash::make('password');// for ease, ask me about the production way (env('APP_KEY'))
                $user = new User();
                $user->password = $password;
                $user->twitch_id = $twitchUser->id;
                $user->name = $twitchUser->name;
                $user->email = $twitchUser->email;
                $user->save();
            } else {
                $user = User::where('email', $twitchUser->email)->first();
            }

            auth()->login($user);
            return redirect('/dashboard');
        }

        return back(404);
    }

    public function twitchAuth(Request $request)
    {
        return Socialite::driver('twitch')->redirect();
    }
}
