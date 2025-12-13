<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-sm bg-white shadow-lg rounded p-6">
    <h2 class="text-xl font-semibold mb-4 text-center">Admin Login</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2"
                   required autofocus>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-black py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>
</div>

</body>
</html>
