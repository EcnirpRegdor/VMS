<?php

namespace App\Http\Controllers;

use App\Models\UserAttempts;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GeneralLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function redirectToAzure()
    {
        return Socialite::driver('azure')->redirectUrl('http://localhost:8000/login/azure/redirect')->redirect();
    }

    public function configUser(Request $request){
        try{
            $validate = $request->validate([
                'dept_id' => 'required|int',
                'id' => 'required'
            ]);
            $findUser = User::findOrFail($validate['id']);

            if($findUser->dept_id == null){
                $findUser->update($validate);
                return redirect()->back()->with('success', 'Successfully Saved');
            }else{
                return redirect()->back()->with('fail', 'Failed to update User');
            }

        }catch(\Exception $e){
            \Log::error('config Error', [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'failed to configure User',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function handleAzureCallback()
    {
        try{
        $azureUser = Socialite::driver('azure')->user();

        $user = User::withTrashed()->where('email', $azureUser ->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $azureUser ->getName(),
                'email' => $azureUser ->getEmail(),
                'password' => bcrypt(\Str::random(8)),
                'provider' => 'azure',
                'profile_picture' => $azureUser->getAvatar() ? $azureUser->getAvatar() : '',
            ]);
        }elseif($user->trashed()){
            return redirect('/')->with('fail', 'You cannot access this account anymore.');
        }

        Auth::login($user, true);
        GeneralLog::log(    "Login", "user", Auth::id(), Auth::user()->name . " has logged in.", null);
        return redirect('/dashboard')->with('success', 'Login Success!');
        }
        catch(\Exception $e){
            \Log::error('Azure Login error', [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'failed to retrieve user from Azure',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function handleCaptcha(Request $request){
        $captcha = $request->validate([
            'g-recaptcha-response' => 'required'
        ]);

        $captchaResponse = $request->input('g-recaptcha-response');

        $response = \Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret'   => env('RECAPTCHA_SECRET_KEY'),
        'response' => $captchaResponse,
        'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!$result['success']) {
            return redirect('/captcha')->withErrors(['captcha' => 'Captcha verification failed. Please try again.']);
        }
        
        session(['captcha_verified' => true]);
        
        return redirect('/')->with('success', 'Captcha verified. You may now attempt to log in.');

    }

    public function login(Request $request){
        $f = $request->validate([
            'email'=> 'required',
            'password'=> 'required'
        ]);

        $loginattempt = UserAttempts::whereEmail($f['email'])->first();

        if($loginattempt && $loginattempt->attempts >= 5 && !$request->session()->get('captcha_verified', false)){
            return redirect('/captcha')->with('fail', 'Please complete the captcha');
        }

        if (auth()->attempt(['email'=> $f['email'],'password'=> $f['password']])) {
            $request->session()->regenerate();
            if($loginattempt){
                $loginattempt->delete();
            }

            GeneralLog::log(    "Login", "user", Auth::id(), Auth::user()->name . " has logged in.", null);
        }else{
            if($loginattempt){
                $loginattempt->increment('attempts');
                $loginattempt->save();

                if($loginattempt->attempts >= 5){
                    return redirect('/captcha')->with('fail', 'Please complete the captcha');
                }
            }else{
                UserAttempts::create([
                    'email' => $f['email'],
                    'attempts' => 1    
                ]);
            }

            GeneralLog::log("Login", "user", 0, "Email: " . $f['email'] . " Attempted user log in fail.", null);
            return redirect('/')->with("fail","Login failed: Email and/or password is incorrect");
        }

        return redirect('/dashboard')->with('success','Login Success!');  
    }
    public function logout()
    {
        $user = Auth::user();
        if($user){
        GeneralLog::log('Logout','user', $user->id, $user->name . " has logged out.", null);

        $checkProv = $user->provider;
        auth()->logout();

            if ($checkProv == 'azure') {
                $azureLogoutUrl = 'https://login.microsoftonline.com/common/oauth2/logout?post_logout_redirect_uri=' . urlencode(url('/'));
                return redirect($azureLogoutUrl);
            }
        }
        return redirect('/');
    }
    
    public function fetchUsers()
    {
        $users = User::select('id', 'name', 'email')->get();

        return response()->json([
            'users' => $users
        ]);
    }
}
