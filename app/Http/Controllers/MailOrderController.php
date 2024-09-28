<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

class MailOrderController extends Controller
{
    //
    function sendmail() {
        Mail::to('kenkc1999@gmail.com')->send(new OrderMail);
    }
}
