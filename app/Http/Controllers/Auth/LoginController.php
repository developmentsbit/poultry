<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\member_info;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $redirectMemberTo = RouteServiceProvider::MEMBER_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        session_start();

        $this->middleware('guest')->except('logout');
        $this->middleware('guest:member')->except('logout');
    }

    public function username()
    {
        $login = request()->input('email');

        if (is_numeric($login)) {
            $field = session()->get('guard') == 'member' ? 'phone' : 'mobile';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'member_id';
        }

        return $field;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $this->validateIfUserActive($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateIfUserActive(Request $request)
    {
        $user = User::query()
            ->where('email', $request->email)
            ->orWhere('mobile', $request->email)
            ->first();

        if ($user) {
            if ($user->status == 0) {
                throw ValidationException::withMessages([
                    $this->username() => ['Account is inactive. Please contact with Administrators.'],
                ]);
            }
        }
    }

    protected function validateIfMemberActive(Request $request)
    {
        $user = member_info::query()
            ->where('email', $request->email)
            ->orWhere('phone', $request->email)
            ->orWhere('member_id', $request->email)
            ->first();

        if ($user) {
            if ($user->status === 0) {
                throw ValidationException::withMessages([
                    $this->username() => ['Account is inactive. Please contact with Administrators.'],
                ]);
            }
        }
    }

    public function showMemberLoginForm()
    {
        return view('member-views.auth.login', ['title' => 'Member Login']);
    }

    public function memberLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:4'
        ]);

        session()->put('guard', 'member');

        if ($validator->fails()) {
            return back()->withInput($request->only('email', 'remember'))->withErrors($validator->errors());
        }

        $this->validateIfMemberActive($request);

        if (\Auth::guard('member')->attempt([$this->username() => $request->email, 'password' => $request->password])) {
            return redirect()->intended(RouteServiceProvider::MEMBER_HOME);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

}