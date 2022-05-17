<?php



namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;

/**
 *
 */
class LoginController extends Controller {

    /**
     * @param \Illuminate\Support\Facades\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback (Request $request) {
        $userAzure = Socialite::driver('azure')->user();

        //** Controllo se la mail appartiene a un utente in DB oppure lo creo direttamente */
        $user = User::query()->firstOrCreate([ 'email' => $userAzure->getEmail()]);

        //'name' => $userAzure->getName(),
        if ($user->name != $userAzure->getName()) {
            $user->name = $userAzure->getName();
            $user->save();
        }

        if ($user) {
            Log::info("Accesso autorizzato", [
                "UtenteAzure" => $userAzure,
                "UtenteDb" => $user,
            ]);
            Auth::loginUsingId($user->id);
            return redirect(\route('dashboard'));
        } else {
            Log::warning("Tentativo accesso non autorizzato", [$userAzure]);
            Auth::logout(); // Log out app
            return redirect(\route('home'))->with('status', 'Unauthorized');
        }
        // $user->token
    }

    /**
     * @param \Illuminate\Support\Facades\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect (Request $request) {
        return Socialite::driver('azure')->redirect();
    }

    /**
     * @param \Illuminate\Support\Facades\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout (Request $request) {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect(\route('home'))->with('status', 'Logout ok');
    }
}
