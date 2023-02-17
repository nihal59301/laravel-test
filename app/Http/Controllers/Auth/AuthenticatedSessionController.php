<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\ProductModel;



class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $user=User::where('email',$request->email)->get();
        $usertype=$user->toArray();
        $request->authenticate();
        $request->session()->regenerate();
        if($usertype[0]["usertype"]==2){
            return redirect()->intended(RouteServiceProvider::SELLERHOME);
        }
        if($usertype[0]["usertype"]==3){
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        if($usertype[0]["usertype"]==1){
            return redirect()->intended(RouteServiceProvider::ADMINHOME);
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
