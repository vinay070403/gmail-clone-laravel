<!-- resources/views/inbox.blade.php -->
@extends('app')

@section('title', 'Inbox')

@section('content')
<h1>Inbox</h1>

@forelse($mails as $mail)
<div class="mail-row" style="display:flex;justify-content:space-between;align-items:center;position:relative;padding:8px;border-bottom:1px solid #eee;">

    <div style="flex:1;">
        <span class="mail-subject">{{ $mail->subject }}</span>
        <span class="mail-snippet">{{ \Illuminate\Support\Str::limit($mail->body, 50) }}</span>
    </div>

    <div style="display:flex;align-items:center;gap:10px;">
        {{-- Delete button (hidden until hover) --}}
        <form action="{{ route('mail.delete', $mail->id) }}" method="POST" class="delete-form" style="margin:0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">🗑</button>
        </form>

        {{-- ⭐ Favorite toggle --}}
        <form action="{{ route('mail.favorite', $mail->id) }}" method="POST" style="display:inline;margin:0;">
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
<p>No mails found in your inbox.</p>
@endforelse

{{-- Hover styles --}}
<style>
    /* Hide delete button by default and show on row hover.
   Kept minimal so other styles remain unaffected. */
    .delete-btn {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        color: #888;
        padding: 0;
        margin-right: 6px;
    }

    .mail-row:hover .delete-btn {
        display: inline-block;
    }

    .delete-btn:hover {
        color: red;
    }
</style>
@endsection