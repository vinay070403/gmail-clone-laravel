<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{
    // Inbox mails
    public function inbox()
    {
        $mails = Mail::join('mail_user', 'mail_user.mail_id', '=', 'mails.id')
            ->where('mail_user.user_id', Auth::id())
            ->where('mail_user.folder', 'inbox')
            ->where('mail_user.is_deleted', false)
            ->orderBy('mails.created_at', 'desc')
            ->select('mails.*', 'mail_user.is_favorite', 'mail_user.is_deleted', 'mail_user.folder')
            ->get();

        dd($mails);


        return view('inbox', compact('mails'));
    }



    // Sent mails
    public function sent()
    {
        $mails = Mail::join('mail_user', 'mail_user.mail_id', '=', 'mails.id')
            ->where('mail_user.user_id', Auth::id())
            ->where('mail_user.folder', 'sent')
            ->where('mail_user.is_deleted', false)
            ->orderBy('mails.created_at', 'desc')
            ->select('mails.*', 'mail_user.is_favorite', 'mail_user.is_deleted', 'mail_user.folder')
            ->get();





        return view('sent', compact('mails'));
    }

    // Favorites
    public function favorites()
    {
        $mails = Mail::join('mail_user', 'mail_user.mail_id', '=', 'mails.id')
            ->where('mail_user.user_id', Auth::id())
            ->where('mail_user.is_favorite', true)
            ->where('mail_user.is_deleted', false)
            ->orderBy('mails.created_at', 'desc')
            ->select('mails.*', 'mail_user.is_favorite', 'mail_user.is_deleted', 'mail_user.folder')
            ->get();

        return view('favorites', compact('mails'));
    }

    // Trash
    public function trash()
    {
        $mails = Mail::join('mail_user', 'mail_user.mail_id', '=', 'mails.id')
            ->where('mail_user.user_id', Auth::id())
            ->where('mail_user.is_deleted', true)
            ->orderBy('mails.created_at', 'desc')
            ->select('mails.*', 'mail_user.is_favorite', 'mail_user.is_deleted', 'mail_user.folder')
            ->get();

        dd($mails->toSql(), $mails->getBindings()); // shows raw SQL + bindings


        return view('trash', compact('mails'));
    }

    // Compose page
    public function create()
    {
        return view('compose');
    }

    // Store new mail
    public function store(Request $request)
    {
        $request->validate([
            'receiver_email' => 'required|email|exists:users,email',
            'subject'        => 'required|string|max:255',
            'body'           => 'required|string',
        ]);

        $receiver = User::where('email', $request->receiver_email)->firstOrFail();

        // Step 1: create mail
        $mail = Mail::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $receiver->id,
            'subject'     => $request->subject,
            'body'        => $request->body,
        ]);

        $now = now();

        // Step 2: pivot entries
        DB::table('mail_user')->insert([
            [
                'user_id'     => Auth::id(),
                'mail_id'     => $mail->id,
                'folder'      => 'sent',   // sender ka sent
                'is_favorite' => false,
                'is_deleted'  => false,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'user_id'     => $receiver->id,
                'mail_id'     => $mail->id,
                'folder'      => 'inbox',  // receiver ka inbox
                'is_favorite' => false,
                'is_deleted'  => false,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);

        return redirect()->route('inbox')->with('success', 'Mail sent successfully!');
    }

    // Toggle favorite
    public function toggleFavorite($id)
    {
        $pivot = DB::table('mail_user')
            ->where('user_id', Auth::id())
            ->where('mail_id', $id)
            ->first();

        if (! $pivot) abort(403);

        $new = $pivot->is_favorite ? 0 : 1;

        DB::table('mail_user')
            ->where('user_id', Auth::id())
            ->where('mail_id', $id)
            ->update(['is_favorite' => $new, 'updated_at' => now()]);

        return back()->with('success', 'Favorite updated.');
    }

    // Move to trash
    public function destroy($id)
    {
        $pivot = DB::table('mail_user')
            ->where('user_id', Auth::id())
            ->where('mail_id', $id)
            ->where('folder', 'inbox')   // <-- only inbox copy
            ->first();

        if (! $pivot) abort(403);

        DB::table('mail_user')
            ->where('user_id', Auth::id())
            ->where('mail_id', $id)
            ->where('folder', 'inbox')
            ->update(['is_deleted' => true, 'updated_at' => now()]);

        return back()->with('success', 'Moved to Trash.');
    }

    // Restore from trash
    public function restore($id)
    {
        $pivot = DB::table('mail_user')
            ->where('user_id', Auth::id())
            ->where('mail_id', $id)
            ->first();

        if (! $pivot) abort(403);

        DB::table('mail_user')
            ->where('user_id', Auth::id())
            ->where('mail_id', $id)
            ->update(['is_deleted' => false, 'updated_at' => now()]);

        return back()->with('success', 'Mail restored.');
    }

    // Force delete
    public function forceDelete($id)
    {
        DB::table('mail_user')
            ->where('user_id', Auth::id())
            ->where('mail_id', $id)
            ->delete();

        $exists = DB::table('mail_user')->where('mail_id', $id)->exists();
        if (! $exists) {
            Mail::destroy($id);
        }

        return back()->with('success', 'Mail deleted permanently.');
    }
}
