<!-- resources/views/sent.blade.php -->
@extends('app')

@section('title', 'Sent')

@section('content')
<h1>Sent</h1>

@forelse($mails as $mail)
<div class="mail-row" style="display:flex;justify-content:space-between;align-items:center;">
    <div>
        <span class="mail-subject">{{ $mail->subject }}</span>
        <span class="mail-snippet">{{ \Illuminate\Support\Str::limit($mail->body, 50) }}</span>
    </div>



    <div style="display:flex;align-items:center;gap:10px;">
        {{-- ⭐ Favorite toggle --}}
        <form action="{{ route('mail.favorite', $mail->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;font-size:18px;">
                @if($mail->is_favorite)
                ⭐
                @else
                ☆
                @endif
            </button>
        </form>

        {{-- Mail date --}}
        <span class="mail-date">{{ $mail->created_at->format('d M Y H:i') }}</span>
    </div>
</div>
@empty
<p>No mails found in your sent box.</p>
@endforelse
@endsection