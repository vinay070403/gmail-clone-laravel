<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Gmail Clone' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .topbar {
            background: #f1f3f4;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .topbar h2 {
            margin: 0;
            font-size: 20px;
        }

        .sidebar {
            width: 200px;
            background: #f8f9fa;
            padding: 20px;
            height: 100vh;
            box-sizing: border-box;
            border-right: 1px solid #ddd;
            position: fixed;
            top: 50px;
            left: 0;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #202124;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background: #e8eaed;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

        .user-quote {
            font-size: 14px;
            color: #555;
            font-style: italic;
        }

        .logout-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            background: #e53935;
            color: #fff;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #c62828;
        }

        .logout-btn {
            background: #d93025;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .logout-btn:hover {
            background: #b31412;
        }

        .mail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .mail-row:hover {
            background: #f1f3f4;
        }

        .mail-subject {
            font-weight: bold;
            margin-right: 10px;
        }

        .mail-snippet {
            color: #555;
        }

        .mail-date {
            color: #777;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <h2>📧 Gmail Clone</h2>
        <div style="display:flex;align-items:center;gap:12px;">
            <span class="user-quote">
                Hey {{ Auth::user()->name }}, if you want to be free then...
            </span>
            <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="sidebar">
        <a href="{{ route('compose') }}">Compose</a>
        <a href="{{ route('inbox') }}">Inbox</a>
        <a href="{{ route('sent') }}">Sent</a>
        <a href="{{ route('favorites') }}">Favorites</a>
        <a href="{{ route('trash') }}">Trash</a>
    </div>

    <div class="content">
        @yield('content')
    </div>
    @yield('scripts')

</body>

</html>