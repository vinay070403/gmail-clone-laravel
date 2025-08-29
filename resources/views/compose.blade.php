@extends('app')

@section('content')
<div class="compose-container minimized" id="composeBox">
    <div class="compose-box">
        <div class="compose-header">
            <span>New Message</span>
            <div class="header-actions">
                <button type="button" class="minimize-btn" id="minimizeBtn">_</button>
                <button type="button" class="maximize-btn" id="maximizeBtn">□</button>
                <button type="button" class="close-btn" id="closeBtn">&times;</button>
            </div>
        </div>

        <form action="{{ route('compose.send') }}" method="POST" class="compose-form">
            @csrf

            <input type="email" name="receiver_email" placeholder="To" required class="compose-input">
            <input type="text" name="subject" placeholder="Subject" required class="compose-input">
            <textarea name="body" rows="8" placeholder="Message..." required class="compose-textarea"></textarea>

            <div class="compose-footer">
                <button type="submit" class="send-btn">Send</button>
                <button type="button" class="discard-btn" id="discardBtn">Discard</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const composeBox = document.getElementById('composeBox');
        const minimizeBtn = document.getElementById('minimizeBtn');
        const maximizeBtn = document.getElementById('maximizeBtn');
        const closeBtn = document.getElementById('closeBtn');
        const discardBtn = document.getElementById('discardBtn');

        minimizeBtn.addEventListener('click', () => {
            composeBox.classList.toggle('minimized');
        });

        maximizeBtn.addEventListener('click', () => {
            composeBox.classList.toggle('maximized');
        });

        closeBtn.addEventListener('click', () => {
            composeBox.style.display = 'none';
        });

        discardBtn.addEventListener('click', () => {
            composeBox.style.display = 'none';
        });
    });
</script>
@endsection