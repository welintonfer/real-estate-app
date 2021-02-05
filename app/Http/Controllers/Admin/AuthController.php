<?php

namespace LaraDev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraDev\Http\Controllers\Controller;
use LaraDev\User;

class AuthController extends Controller
{
    //Using Illuminate\Support\Facades\Auth; for Auth
    public function showLoginForm()
    {
        if(Auth::check() === true) {
            return redirect()->route('admin.home');
        }
        return view('admin.index');
    }

    public function home()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if(in_array('', $request->only('email', 'password'))) {
            //Old code commented
            //$json['message'] = "Ooops, informe todos os dados para efetuar o login!";
            $json['message'] = $this->message->error('Ooops, informe todos os dados para efetuar o login!')->render();
            return response()->json($json);
        }

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $json['message'] = $this->message->error('Ooops, informe um email valido!')->render();
            return response()->json($json);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        //Auth\Support\facades
        if(!Auth::attempt($credentials)) {
            $json['message'] = $this->message->error('Ooops, usuário ou senha não conferem!')->render();
            return response()->json($json);
        }

        $this->authenticated($request->getClientIp());
        $json['redirect'] = route('admin.home');
        return response()->json($json);

    }

    public function logout()
    {
        //Auth have to be from this facade //Illuminate\Support\Facades\Auth;
        Auth::logout();
        return redirect()->route('admin.login');
    }

    //That comes from $this->authenticated(); above $json
    private function authenticated(string $ip) {
        $user = User::where('id', Auth::user()->id);
        $user->update([
           'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ip
        ]);
    }
}
