<x-layouts.public-app>
    <x-slot name="hero">
        <section class="relative w-full h-[70vh] overflow-hidden">
            <img src="{{asset('images/poza3.png')}}" class="absolute inset-0 w-full h-full object-cover object-[0px_-200px]  shadow-2xl" alt="Karting">

            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                <h1 class="text-5xl font-extrabold text-white italic tracking-tighter uppercase">
                    Viteză. Adrenalină. <span class="text-red-600">Karting.</span>
                </h1>
                <p class="mt-4 text-xl text-gray-200">Cele mai noi știri din lumea kartingului românesc.</p>
            </div>
        </section>
    </x-slot>

    <div class="max-w-full mx-auto px-4 py-12 bg-[#0a0a0a]">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <div>
                <h2 class="text-white font-bold mb-6 uppercase border-l-4 border-red-600 pl-3">
                    Latest <span class="text-red-600">News</span>
                </h2>

                <div class="space-y-6">
                    @foreach ($posts->take(2) as $post)
                        <article class="flex bg-[#1a1a1a] border border-gray-800 rounded-md overflow-hidden hover:border-red-600 transition-all h-40">
                            <div class="w-1/3">
                                @if ($post->image)
                                    <img src="{{ asset('storage/uploads/' . $post->image) }}" class="h-full w-full object-cover" alt="{{ $post->title }}">
                                @endif
                            </div>
                            <div class="w-2/3 p-4 flex flex-col justify-between">
                                <h3 class="text-white font-bold uppercase italic text-sm leading-tight">
                                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-400 text-xs line-clamp-2">
                                    {{ $post->excerpt ?? Str::limit($post->post, 60) }}
                                </p>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-gray-500 text-[10px]">{{ $post->created_at->format('M d, Y') }}</span>
                                    <span class="text-red-600 font-bold">»</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="text-white font-bold mb-6 uppercase border-l-4 border-red-600 pl-3">
                    Featured <span class="text-red-600">Articles</span>
                </h2>

                <div class="space-y-6">
                    {{-- Sărim peste primele 2 și luăm următoarele 2 --}}
                    @foreach ($posts->skip(2)->take(2) as $post)
                        <article class="flex bg-[#1a1a1a] border border-gray-800 rounded-md overflow-hidden hover:border-red-600 transition-all h-40">
                            <div class="w-1/3">
                                @if ($post->image)
                                    <img src="{{ asset('storage/uploads/' . $post->image) }}" class="h-full w-full object-cover" alt="{{ $post->title }}">
                                @endif
                            </div>
                            <div class="w-2/3 p-4 flex flex-col justify-between">
                                <h3 class="text-white font-bold uppercase italic text-sm leading-tight">
                                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-400 text-xs line-clamp-2">
                                    {{ $post->excerpt ?? Str::limit($post->post, 60) }}
                                </p>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-gray-500 text-[10px]">{{ $post->created_at->format('M d, Y') }}</span>
                                    <span class="text-red-600 font-bold">»</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
{{--    <div class="mt-8">--}}
{{--        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">--}}
{{--            View all posts →--}}
{{--        </a>--}}
{{--    </div>--}}

</x-layouts.public-app>
