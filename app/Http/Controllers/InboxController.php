<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $mails = Mail::where('receiver_id', Auth::id())
            ->where('is_deleted', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        dump($mails);

        return view('inbox', compact('mails'));
    }
}
