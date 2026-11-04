<!DOCTYPE html>
<html lang="en">

<head>
    @vite('resources/css/app.css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body class="p-6 overflow-y-auto flex flex-col bg-[#D9A976] h-screen justify-center items-center">
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-700 p-3 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow max-w-lg max-h-lg my-auto mx-auto">

        <h2 class="text-xl font-semibold mb-6">Login</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4 max-w-lg w-full mx-auto">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf

            <div>
                <label class="text-sm">Username</label>
                <input type="text" required name="username" value="{{ old('username') }}" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="text-sm">Password</label>
                <input type="password" required name="password" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <input type="checkbox" name="remember">
                <label class="text-sm">Ingat Saya</label>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Simpan
            </button>
        </form>

    </div>

</body>

</html>
