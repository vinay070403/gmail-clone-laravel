@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reset Password</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('reset.submit') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>New Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</div>
@endsection