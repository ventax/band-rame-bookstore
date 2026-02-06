<!DOCTYPE html>
<html>

<head>
    <title>Test Profile Page</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f0f0f0;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 10px 0;
        }

        .success {
            background: #d4edda;
            border: 2px solid #28a745;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="box success">
        <h1>✓ TEST PROFILE PAGE LOADED!</h1>
        <p><strong>User:</strong> {{ $user->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
        <p><strong>Addresses:</strong> {{ $addresses->count() ?? 0 }}</p>
        <p><strong>Time:</strong> {{ now() }}</p>
    </div>

    <div class="box">
        <h2>Navigation Test</h2>
        <p><a href="{{ route('home') }}">← Back to Home</a></p>
    </div>

    <div class="box">
        <h2>Debug Info</h2>
        <p>Controller: ProfileController@edit</p>
        <p>View: profile.test</p>
        <p>Route: {{ route('profile.edit') }}</p>
    </div>
</body>

</html>
