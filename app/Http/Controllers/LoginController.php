<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEventsRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{

    public function updateEvent(UpdateEventsRequest $request)
    {
        try {
            $tableName = $request->eventType;
            $modelName = Str::studly(Str::singular($tableName));
            $ns = 'App\Models\\';
            $fqn = $ns . $modelName;

            $modelFound = $fqn::find($request->eventId);

            $modelFound->read = !$request->eventRead;
            $modelFound->save();
            return response()->json([
                'error' => false,
                'message' => 'successfully updated read status',
                'data' => $modelFound,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
    }

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

    public function getDashboard()
    {

        $userResource = new UserResource(auth()->user());
        return Inertia::render('Dashboard', [
            'user' => $userResource,
        ]);
    }
}
