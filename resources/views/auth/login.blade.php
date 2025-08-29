<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: system-ui, sans-serif;
            background: #f6f8fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: #fff;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 420px;
        }

        .card h1 {
            margin: 0 0 12px;
            font-size: 24px;
            font-weight: 600;
            color: #202124;
            text-align: center;
        }

        .card p.subtitle {
            text-align: center;
            margin-bottom: 24px;
            font-size: 14px;
            color: #5f6368;
        }

        label {
            font-size: 14px;
            color: #202124;
            display: block;
            margin-top: 16px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border: 1px solid #dadce0;
            border-radius: 6px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 1px #1a73e8;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 16px;
            font-size: 14px;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 12px;
            background: #1a73e8;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
        }

        button:hover {
            background: #1669c1;
        }

        .error {
            background: #fce8e6;
            border: 1px solid #ea4335;
            color: #ea4335;
            font-size: 14px;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 6px;
        }

        .flash {
            background: #e6ffed;
            border: 1px solid #34d399;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 6px;
            color: #065f46;
            font-size: 14px;
        }

        .links {
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
        }

        .links a {
            color: #1a73e8;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Login</h1>
        <p class="subtitle">Access your Gmail Clone</p>

        @if ($errors->any())
        <div class="error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="flash">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('auth.login.attempt') }}">
            @csrf

            <label>Email
                <input type="email" name="email" value="{{ old('email') }}" maxlength="150" required>
            </label>

            <label>Password
                <input type="password" name="password" required>
            </label>

            <label class="checkbox-label">
                <input type="checkbox" name="remember"> Remember me
            </label>

            <button type="submit">Login</button>
        </form>

        <div class="links">
            <a href="{{ route('reset.direct.form') }}">Forgot Password?</a>

        </div>

        <div class="links">
            Don’t have an account? <a href="{{ route('auth.register.show') }}">Register</a>
        </div>
    </div>
</body>

</html>