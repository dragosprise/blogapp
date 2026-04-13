<x-layouts.public-app>
    <x-slot name="hero">
        <section class="relative w-full overflow-hidden bg-black">
            <div class="absolute inset-0">
                <img
                    src="{{ asset('images/poza3.png') }}"
                    alt=""
                    class="h-full w-full object-cover opacity-35 blur-[1px]"
                >
                <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/60 to-black"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14 sm:py-16">
                <div class="max-w-3xl">
                    <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight text-white">
                        CALENDARUL CURSELOR
                    </h1>
                    <p class="mt-4 text-sm sm:text-base text-gray-300">
                        Fii la curent cu următoarele competiții de karting din România.
                    </p>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
{{--                    <div class="flex items-center gap-6 text-xs uppercase tracking-widest text-gray-300/90">--}}
{{--                        <span class="relative text-white font-bold">--}}
{{--                            All--}}
{{--                            <span class="absolute -bottom-2 left-0 h-0.5 w-10 bg-red-600"></span>--}}
{{--                        </span>--}}
{{--                        <span class="text-gray-400">Races</span>--}}
{{--                        <span class="text-gray-400">Tech</span>--}}
{{--                        <span class="text-gray-400">Junior</span>--}}
{{--                    </div>--}}

                    <form method="GET" action="{{ route('races.index') }}" class="flex items-center gap-3">
                        <label for="year" class="text-xs uppercase tracking-widest text-gray-400">Year</label>
                        <select
                            id="year"
                            name="year"
                            class="bg-black/50 border border-gray-800 text-gray-200 text-sm rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600/40"
                            onchange="this.form.submit()"
                        >
                            @foreach ($years as $y)
                                <option value="{{ $y }}" @selected((int) $y === (int) $year)>{{ $y }}</option>
                            @endforeach
                            @if ($years->isEmpty())
                                <option value="{{ $year }}" selected>{{ $year }}</option>
                            @endif
                        </select>
                    </form>
                </div>
            </div>
        </section>
    </x-slot>

    @php
        $fallbackHero = asset('images/poza2.webp');

        $raceImage = function ($race) use ($fallbackHero) {
            if (!$race || empty($race->image)) {
                return $fallbackHero;
            }

            $img = (string) $race->image;

            // Allow storing public-relative paths like "images/foo.png".
            if (str_contains($img, '/')) {
                return asset($img);
            }

            // Default: storage/app/public/uploads/<filename>
            return asset('storage/uploads/' . $img);
        };

        $dateRange = function ($race) {
            $start = $race->starts_at;
            $end = $race->ends_at;
            if (!$end || $end->equalTo($start)) {
                return [
                    'month' => strtoupper($start->format('M')),
                    'days' => $start->format('d'),
                    'month2' => null,
                ];
            }

            if ($start->format('M') === $end->format('M')) {
                return [
                    'month' => strtoupper($start->format('M')),
                    'days' => $start->format('d') . '-' . $end->format('d'),
                    'month2' => null,
                ];
            }

            return [
                'month' => strtoupper($start->format('M')),
                'days' => $start->format('d') . '-' . $end->format('d'),
                'month2' => strtoupper($end->format('M')),
            ];
        };
    @endphp

    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-10">
                @foreach ($competitions as $competition)
                    @php
                        $races = $racesByCompetition->get($competition->id, collect());
                        $featured = $races->firstWhere('is_featured', true) ?? $races->first();
                        $rest = $featured ? $races->where('id', '!=', $featured->id)->values() : collect();
                    @endphp

                    <section class="space-y-4">
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <h2 class="text-white text-lg font-extrabold uppercase tracking-wide">
                                    {{ $competition->name }}
                                </h2>
                                @if ($competition->description)
                                    <p class="mt-1 text-sm text-gray-400">{{ $competition->description }}</p>
                                @endif
                            </div>
                            <span class="text-xs uppercase tracking-widest text-gray-500">
                                Curse viitoare în {{ $year }}
                            </span>
                        </div>

                        @if ($featured)
                            @php($dr = $dateRange($featured))
                            <article class="relative overflow-hidden rounded-xl border border-gray-800 bg-[#0e0e0e]">
                                <div class="relative aspect-[16/9]">
                                    <img
                                        src="{{ $raceImage($featured) }}"
                                        alt="{{ $featured->title }}"
                                        class="h-full w-full object-cover opacity-95"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>

                                    <div class="absolute left-5 top-5 rounded-lg bg-black/55 border border-gray-800 px-3 py-2 text-center">
                                        <div class="text-[10px] font-extrabold tracking-widest text-red-500">
                                            {{ $dr['month'] }}
                                        </div>
                                        <div class="mt-0.5 text-2xl font-extrabold text-white leading-none">
                                            {{ $dr['days'] }}
                                        </div>
                                        @if ($dr['month2'])
                                            <div class="mt-0.5 text-[10px] font-extrabold tracking-widest text-red-500">
                                                {{ $dr['month2'] }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-6">
                                        <h3 class="text-2xl sm:text-3xl font-extrabold uppercase italic tracking-tight text-white">
                                            {{ $featured->title }}
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-300">
                                            @if ($featured->venue || $featured->city)
                                                {{ trim(($featured->venue ?? '') . ', ' . ($featured->city ?? ''), ', ') }}
                                            @else
                                                Upcoming karting race.
                                            @endif
                                        </p>

                                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                            <div class="text-xs uppercase tracking-widest text-gray-500">
                                                <span class="text-red-500 font-bold">{{ $competition->slug }}</span>
                                                <span class="text-gray-700 px-2">|</span>
                                                <time datetime="{{ $featured->starts_at->format('Y-m-d') }}">
                                                    {{ $featured->starts_at->format('M d, Y') }}
                                                </time>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                @if ($featured->tickets_url)
                                                    <a
                                                        href="{{ $featured->tickets_url }}"
                                                        target="_blank"
                                                        rel="noopener"
                                                        class="inline-flex items-center justify-center rounded-md bg-red-600 px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-white hover:bg-red-500"
                                                    >
                                                        Buy tickets
                                                    </a>
                                                @endif
                                                <a
                                                    href="{{ route('races.show', $featured->id) }}"
                                                    class="inline-flex items-center justify-center rounded-md border border-gray-800 bg-black/40 px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-gray-200 hover:bg-white/5"
                                                >
                                                    Vezi detalii
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @else
                            <div class="rounded-xl border border-gray-800 bg-[#0f0f0f] p-6 text-gray-300">
                                Nu sunt curse pentru anul {{ $year }} încă.
                            </div>
                        @endif

                        @if ($rest->isNotEmpty())
                            <div class="space-y-3">
                                @foreach ($rest as $race)
                                    @php($dr = $dateRange($race))
                                    <article class="flex items-center justify-between gap-4 rounded-xl border border-gray-800 bg-[#0f0f0f] p-4 hover:border-red-600/60 transition-colors">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div class="w-20 text-center">
                                                <div class="text-[10px] font-extrabold tracking-widest text-red-500">
                                                    {{ $dr['month'] }}
                                                </div>
                                                <div class="text-xl font-extrabold text-white leading-none">
                                                    {{ $dr['days'] }}
                                                </div>
                                            </div>

                                            <div class="min-w-0">
                                                <p class="text-sm font-extrabold uppercase italic tracking-tight text-white truncate">
                                                    {{ $race->title }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-400 truncate">
                                                    {{ trim(($race->venue ?? '') . ', ' . ($race->city ?? ''), ', ') }}
                                                    @if ($race->classes)
                                                        <span class="text-gray-600 px-2">|</span>
                                                        {{ $race->classes }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 shrink-0">
                                            @if ($race->tickets_url)
                                                <a
                                                    href="{{ $race->tickets_url }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="inline-flex items-center gap-2 rounded-md border border-gray-800 bg-black/30 px-3 py-2 text-[11px] font-extrabold uppercase tracking-widest text-gray-200 hover:bg-white/5"
                                                >
                                                    Buy tickets
                                                </a>
                                            @endif
                                            <a
                                                href="{{ route('races.show', $race->id) }}"
                                                class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-[11px] font-extrabold uppercase tracking-widest text-gray-300 hover:text-white"
                                            >
                                                Vezi detalii
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endforeach
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <section class="rounded-xl border border-gray-800 bg-[#0f0f0f] overflow-hidden">
                    <div class="border-b border-gray-800 px-5 py-4">
                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">
                            <span class="text-red-600">#</span> Upcoming
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-800">
                        @forelse ($upcomingRaces as $r)
                            <a href="{{ route('races.show', $r->id) }}" class="group flex gap-3 px-5 py-4 hover:bg-white/5">
                                <img
                                    src="{{ $raceImage($r) }}"
                                    alt=""
                                    class="h-12 w-16 rounded-md object-cover border border-gray-800"
                                >
                                <div class="min-w-0">
                                    <p class="truncate text-[11px] font-extrabold uppercase italic tracking-tight text-gray-100 group-hover:text-white">
                                        {{ $r->title }}
                                    </p>
                                    <p class="mt-1 text-[10px] uppercase tracking-widest text-gray-500">
                                        {{ $r->competition->name ?? 'Race' }} | {{ $r->starts_at->format('M d') }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="px-5 py-4 text-sm text-gray-400">
                                No upcoming races.
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-xl border border-gray-800 bg-[#0f0f0f] overflow-hidden">
                    <div class="border-b border-gray-800 px-5 py-4">
                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">
                            <span class="text-red-600">#</span> Competitions
                        </h3>
                    </div>
                    <div class="px-5 py-4 space-y-2">
                        @foreach ($competitions as $c)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-200 uppercase tracking-wide text-[11px] font-bold">
                                    {{ $c->name }}
                                </span>
                                <span class="text-[10px] text-gray-500">
                                    {{ ($racesByCompetition->get($c->id, collect()))->count() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </section>
            </aside>
        </div>
    </div>
</x-layouts.public-app>

