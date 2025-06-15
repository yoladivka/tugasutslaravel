<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">
                    Sistem Manajemen Mahasiswa
                </h1>
                
                @auth
                    <p class="text-gray-600 mb-6">
                        Selamat datang, {{ auth()->user()->name }}!
                    </p>
                    <div class="space-y-3">
                        <a href="{{ route('dashboard') }}" 
                           class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block">
                            Ke Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <p class="text-gray-600 mb-6">
                        Silakan login untuk mengakses sistem
                    </p>
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" 
                           class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded block">
                            Daftar Sebagai Mahasiswa
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>