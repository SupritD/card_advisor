<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-sm bg-white shadow-lg rounded p-6">
    <h2 class="text-xl font-semibold mb-4 text-center">Admin Register</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.register.post') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2"
                   required autofocus>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <!-- Confirm -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-black py-2 rounded hover:bg-green-700">
            Register
        </button>
    </form>
</div>

</body>
</html>
