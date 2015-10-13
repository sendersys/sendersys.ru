<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller {

    use ResetsPasswords;
    
    protected $table = 'sendersysusers';


public function forgot_password(Request $request)
{   
   
    $this->validate($request, ['email' => 'required']);

    $response = $this->passwords->sendResetLink($request->only('email'), function($message)
    {
        $message->subject('Password Reminder');
    });

    switch ($response)
    {
        case PasswordBroker::RESET_LINK_SENT:
            return redirect()->back()->with('status', trans($response));

        case PasswordBroker::INVALID_USER:
            return redirect()->back()->withErrors(['email' => trans($response)]);
    }
}

}

