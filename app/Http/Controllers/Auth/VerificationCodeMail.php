<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationCodeMail extends Controller
{
    //
    public function ShowVerificationcodeForm(){
        return view('emails.VerificationCode');
    }
    
}
