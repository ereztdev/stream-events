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

    /**
     * Update event read status
     *
     * @param UpdateEventsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Instantiating the user from socialite (Twitch) and setting into the DB
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
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

    /**
     * Get user authenticated with twitch Oauth server
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function twitchAuth(Request $request)
    {
        return Socialite::driver('twitch')->redirect();
    }

    /**
     * return the dashboard view via Inertia
     *
     * @return \Inertia\Response
     */
    public function getDashboard()
    {
        $userResource = new UserResource(auth()->user());

        return Inertia::render('Dashboard', [
            'user' => $userResource,
        ]);
    }
}
