<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">Simple Blog</a>
                </div>
                <div class="flex space-x-8 mx-auto">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="{{ route('about') }}"
                        class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium">About</a>
                </div>
                <div>
                    @auth <form method="POST" action="{{ route('logout') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium ml-auto>
                        @csrf
                        @role('admin')
                        <a href="/admin">Admin Panel</a>
                        @endrole
                        <button href="{{route('logout')}}"
                           class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium ml-auto">Logout</button>
                    @else
                <a href="{{route('login')}}"
                 class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium ml-auto">Login</a>
                    <a href="{{route('register')}}"
                       class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium ml-auto">Register</a>
                    @endauth

            </div>
        </div>
        </div></nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Simple Blog</p>
            </div>
        </div>
    </footer>
</body>

</html>
