<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" w-full bg-gradient-to-b from-gray-800 to-[#0a0a0a] min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-black shadow-sm border-b">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold">
                        <span class="text-red-600">Karting</span>
                        <span class="text-white">Romania</span>
                    </a>
                </div>
                <div class="flex space-x-8 mx-auto">
                    <a href="{{ route('home') }}"
                        class="nav-link">Acasă</a>
                    <a href="{{ route('posts.index') }}"
                       class="nav-link">
                        Știri
                    </a>
                    <a href="{{ route('races.index') }}"
                       class="nav-link">Curse</a>

                    <a href="{{ route('about') }}"
                        class="nav-link">Despre</a>
                </div>
                <div class="flex justify-between items-center h-16">
                    @auth
                        @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link"> Admin Panel</a>
                    @endrole
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="nav-link flex items-center bg-transparent border-none cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    @else
                <a href="{{route('login')}}"
                 class="nav-link">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="nav-link">Register</a>
                    @endif
                    @endauth

            </div>
        </div>
        </div></nav>

    <!-- Main Content -->
    <div class="min-h-screen ">


        @if (isset($hero))
            {{ $hero }}
        @endif
    <main class="px-4 sm:px-6 lg:px-8 py-8">

        {{ $slot }}
    </main>
    </div>
    <!-- Footer -->
    <footer class="bg-black border-t mt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-white">
                <p>&copy; {{ date('Y') }} Karting Romania</p>
            </div>
        </div>
    </footer>
</body>

</html>
