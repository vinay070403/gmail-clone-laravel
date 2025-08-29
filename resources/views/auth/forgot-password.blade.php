<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            padding: 24px;
            max-width: 480px;
            margin: 0 auto;
        }

        .error {
            color: #b00020;
            font-size: 14px;
            margin-top: 4px;
        }

        .flash {
            background: #d1fae5;
            border: 1px solid #10b981;
            padding: 10px;
            margin-bottom: 12px;
        }

        label {
            display: block;
            margin-top: 12px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
        }

        button {
            margin-top: 16px;
            padding: 10px 14px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Reset Password</h1>

    @if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="flash">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('reset.direct.submit') }}">
        @csrf

        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" maxlength="150" required>
        </label>

        <label>New Password
            <input type="password" name="password" required>
        </label>

        <label>Confirm Password
            <input type="password" name="password_confirmation" required>
        </label>

        <button type="submit">Reset Password</button>
    </form>

    <p style="margin-top:12px;">Remembered password?
        <a href="{{ route('auth.login.show') }}">Login</a>
    </p>
</body>

</html>