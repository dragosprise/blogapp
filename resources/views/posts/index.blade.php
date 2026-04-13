<x-layouts.public-app>
    <x-slot name="hero">
        <section class="relative w-full overflow-hidden bg-black">
            <div class="absolute inset-0">
                <img
                    src="{{ asset('images/poza3.png') }}"
                    alt=""
                    class="h-full w-full object-cover opacity-30 blur-[1px]"
                >
                <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/60 to-black"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 sm:py-16">
                <div class="max-w-3xl">
                    <p class="text-xs tracking-[0.3em] text-red-500/90 uppercase">Karting Romania</p>
                    <h1 class="mt-2 text-5xl sm:text-6xl font-extrabold tracking-tight text-white">
                        NEWS
                    </h1>
                    <p class="mt-4 text-sm sm:text-base text-gray-300">
                        Latest karting news, race reports and analysis from Romania
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    @php
        $fallbackImage = asset('images/poza2.webp');

        $postImage = function ($post) use ($fallbackImage) {
            if (!$post || empty($post->image)) {
                return $fallbackImage;
            }

            // Admin uploads live under storage/app/public/uploads and are served via /storage/uploads/*
            return asset('storage/uploads/' . $post->image);
        };

        $excerpt = function ($post, $len = 120) {
            $text = $post?->excerpt ?? null;
            if (!$text) {
                $text = $post?->post ?? '';
            }

            return \Illuminate\Support\Str::limit(strip_tags((string) $text), $len);
        };
    @endphp

    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
                @if ($featuredPost)
                    <article class="group relative overflow-hidden rounded-xl border border-gray-800 bg-[#0e0e0e]">
                        <a href="{{ route('posts.show', $featuredPost->id) }}" class="block">
                            <div class="relative aspect-[16/9]">
                                <img
                                    src="{{ $postImage($featuredPost) }}"
                                    alt="{{ $featuredPost->title }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>

                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-6">
                                    <div class="flex items-center gap-2 text-[10px] uppercase tracking-widest text-gray-200">
                                        <span class="inline-flex items-center gap-2">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                                            {{ $featuredPost->category->name ?? 'News' }}
                                        </span>
                                        <span class="text-gray-500">|</span>
                                        <time class="text-gray-300" datetime="{{ $featuredPost->created_at->format('Y-m-d') }}">
                                            {{ $featuredPost->created_at->format('M d, Y') }}
                                        </time>
                                    </div>
                                    <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold uppercase italic tracking-tight text-white">
                                        {{ $featuredPost->title }}
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-300">
                                        {{ $excerpt($featuredPost, 150) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </article>
                @endif

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($posts as $post)
                        <article class="group overflow-hidden rounded-xl border border-gray-800 bg-[#101010] hover:border-red-600/70 transition-colors">
                            <a href="{{ route('posts.show', $post->id) }}" class="block">
                                <div class="relative aspect-[16/10]">
                                    <img
                                        src="{{ $postImage($post) }}"
                                        alt="{{ $post->title }}"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.04]"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>
                                    <div class="absolute left-3 top-3">
                                        <span class="inline-flex items-center rounded bg-red-600 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">
                                            {{ $post->category->name ?? 'News' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h3 class="text-sm font-extrabold uppercase italic tracking-tight text-white leading-snug">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="mt-2 text-xs text-gray-300 line-clamp-3">
                                        {{ $excerpt($post, 110) }}
                                    </p>

                                    <div class="mt-3 flex items-center justify-between text-[10px] uppercase tracking-widest text-gray-500">
                                        <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </time>
                                        <span class="text-red-500 font-bold">Read</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <section class="rounded-xl border border-gray-800 bg-[#0f0f0f] overflow-hidden">
                    <div class="border-b border-gray-800 px-5 py-4">
                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">
                            <span class="text-red-600">#</span> Trending
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-800">
                        @foreach ($trendingPosts as $tp)
                            <a href="{{ route('posts.show', $tp->id) }}" class="group flex gap-3 px-5 py-4 hover:bg-white/5">
                                <img
                                    src="{{ $postImage($tp) }}"
                                    alt=""
                                    class="h-12 w-16 rounded-md object-cover border border-gray-800"
                                >
                                <div class="min-w-0">
                                    <p class="truncate text-[11px] font-extrabold uppercase italic tracking-tight text-gray-100 group-hover:text-white">
                                        {{ $tp->title }}
                                    </p>
                                    <p class="mt-1 text-[10px] uppercase tracking-widest text-gray-500">
                                        {{ $tp->category->name ?? 'News' }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

{{--                <section class="rounded-xl border border-gray-800 bg-[#0f0f0f] overflow-hidden">--}}
{{--                    <div class="border-b border-gray-800 px-5 py-4">--}}
{{--                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">--}}
{{--                            <span class="text-red-600">#</span> Categories--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                    <div class="px-5 py-4 space-y-2">--}}
{{--                        @forelse ($categories as $cat)--}}
{{--                            <div class="flex items-center justify-between text-sm">--}}
{{--                                <span class="text-gray-200 uppercase tracking-wide text-[11px] font-bold">--}}
{{--                                    {{ $cat->name }}--}}
{{--                                </span>--}}
{{--                                <span class="text-[10px] text-gray-500">--}}
{{--                                    {{ $cat->posts_count }}--}}
{{--                                </span>--}}
{{--                            </div>--}}
{{--                        @empty--}}
{{--                            <p class="text-sm text-gray-400">No categories.</p>--}}
{{--                        @endforelse--}}
{{--                    </div>--}}
{{--                </section>--}}

                <section class="rounded-xl border border-gray-800 bg-[#0f0f0f] overflow-hidden">
                    <div class="border-b border-gray-800 px-5 py-4">
                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">
                            <span class="text-red-600">#</span> Upcoming Race
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="overflow-hidden rounded-lg border border-gray-800 bg-black/40">
                            <img src="{{ asset('images/poza.png') }}" alt="" class="h-36 w-full object-cover opacity-90">
                            <div class="p-4">
                                <p class="text-[10px] uppercase tracking-widest text-red-500 font-bold">Next</p>
                                <p class="mt-1 text-sm font-extrabold uppercase italic tracking-tight text-white">
                                    Romanian Championship
                                </p>
                                <p class="mt-1 text-xs text-gray-400">
                                    Calendar and details coming soon.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

{{--                <section class="rounded-xl border border-gray-800 bg-[#0f0f0f] overflow-hidden">--}}
{{--                    <div class="border-b border-gray-800 px-5 py-4">--}}
{{--                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">--}}
{{--                            <span class="text-red-600">#</span> Tags--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                    <div class="p-5 flex flex-wrap gap-2">--}}
{{--                        @forelse ($tags as $tag)--}}
{{--                            <span class="inline-flex items-center gap-2 rounded-full border border-gray-800 bg-white/5 px-3 py-1 text-[11px] text-gray-200">--}}
{{--                                <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>--}}
{{--                                {{ $tag->name }}--}}
{{--                            </span>--}}
{{--                        @empty--}}
{{--                            <p class="text-sm text-gray-400">No tags.</p>--}}
{{--                        @endforelse--}}
{{--                    </div>--}}
{{--                </section>--}}
            </aside>
        </div>
    </div>
</x-layouts.public-app>

