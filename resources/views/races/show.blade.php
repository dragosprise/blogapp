<x-layouts.public-app>
    @php
        $fallback = asset('images/poza2.webp');
        $img = $race->image;
        if (!$img) {
            $imgUrl = $fallback;
        } elseif (str_contains($img, '/')) {
            $imgUrl = asset($img);
        } else {
            $imgUrl = asset('storage/uploads/' . $img);
        }
    @endphp

    <article class="mx-auto max-w-5xl overflow-hidden rounded-xl border border-gray-800 bg-[#0f0f0f]">
        <div class="relative aspect-[16/9]">
            <img src="{{ $imgUrl }}" alt="" class="h-full w-full object-cover opacity-95">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
                <p class="text-xs uppercase tracking-widest text-red-500 font-bold">
                    {{ $race->competition->name ?? 'Race' }}
                </p>
                <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold uppercase italic tracking-tight text-white">
                    {{ $race->title }}
                </h1>
                <p class="mt-2 text-sm text-gray-300">
                    <time datetime="{{ $race->starts_at->format('Y-m-d') }}">{{ $race->starts_at->format('M d, Y') }}</time>
                    @if ($race->ends_at)
                        <span class="text-gray-600 px-2">|</span>
                        <time datetime="{{ $race->ends_at->format('Y-m-d') }}">{{ $race->ends_at->format('M d, Y') }}</time>
                    @endif
                </p>
            </div>
        </div>

        <div class="p-6 space-y-3 text-gray-200">
            @if ($race->venue || $race->city)
                <p class="text-sm text-gray-300">
                    <span class="text-gray-500 uppercase tracking-widest text-[11px]">Locație</span><br>
                    {{ trim(($race->venue ?? '') . ', ' . ($race->city ?? ''), ', ') }}
                </p>
            @endif

            @if ($race->classes)
                <p class="text-sm text-gray-300">
                    <span class="text-gray-500 uppercase tracking-widest text-[11px]">Clase</span><br>
                    {{ $race->classes }}
                </p>
            @endif

            <p class="text-sm text-gray-300">
                <span class="text-gray-500 uppercase tracking-widest text-[11px]">Status</span><br>
                {{ $race->status }}
            </p>

            <div class="pt-4 flex flex-wrap gap-3">
                @if ($race->tickets_url)
                    <a
                        href="{{ $race->tickets_url }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center justify-center rounded-md bg-red-600 px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-white hover:bg-red-500"
                    >
                        Buy tickets
                    </a>
                @endif

                @if ($race->details_url)
                    <a
                        href="{{ $race->details_url }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center justify-center rounded-md border border-gray-800 bg-black/40 px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-gray-200 hover:bg-white/5"
                    >
                        Official details
                    </a>
                @endif

                <a
                    href="{{ route('races.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-gray-800 bg-black/40 px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-gray-200 hover:bg-white/5"
                >
                    Înapoi la calendar
                </a>
            </div>
        </div>
    </article>
</x-layouts.public-app>

