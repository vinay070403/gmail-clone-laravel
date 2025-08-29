<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
</head>

<body>
    <h1>Reset Password</h1>

    @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div style="color:green;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('reset.direct.submit') }}">
        @csrf

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>New Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Reset Password</button>
    </form>
</body>

</html>