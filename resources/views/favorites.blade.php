@extends('app')

@section('title', 'Favorites')

@section('content')

<h1>Favorites</h1>

@forelse($mails as $mail)
<div class="mail-row">
    <div>
        <span class="mail-subject">{{ $mail->subject }}</span>
        <span class="mail-snippet">- {{ \Illuminate\Support\Str::limit($mail->body, 50) }}</span>
    </div>
    <div class="mail-date">{{ $mail->created_at->format('d M Y H:i') }}</div>
</div>
@empty
<p>No favorite mails found.</p>
@endforelse
@endsection