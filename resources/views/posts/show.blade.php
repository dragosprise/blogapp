<x-layouts.public-app>
    <div class="mb-6">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to all posts
        </a>
    </div>

    <!-- Article -->
    <article class="bg-white rounded-lg shadow-sm border p-8">
        <!-- Article Header -->
        <header class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                    {{ $post->created_at->format('F d, Y') }}
                </time>
                <span class="mx-2">•</span>
                <span>5 min read</span>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center space-x-2 mb-6">
                @foreach ($post->tags as $tag)
                    <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        </header>

        <!-- Article Content -->
        <div class="prose prose-lg max-w-none">
            {{ $post->post }}
        </div>



        <!-- Comments Content -->
        @auth
            <section id="comment-form" class="mt-12 bg-white shadow-lg rounded-lg p-8 border">
                <h3 class="text-xl font-bold mb-6 text-gray-800">Lasă un comentariu</h3>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="space-y-4">
                    @csrf

                    <div>
            <textarea name="body"
                      rows="4"
                      class="w-full border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('body') border-red-500 @enderror"
                      placeholder="Scrie comentariul tău aici...">{{ old('body') }}</textarea>

                        @error('body')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 w-full md:w-auto">
                        Publică Comentariu
                    </button>
                </form>
            </section>
        @endauth

        @guest
            <div class="mt-12 p-8 bg-yellow-50 border-2 border-yellow-200 rounded-lg text-center">
                <p class="text-lg text-yellow-800 mb-4">Trebuie să fii logat pentru a comenta</p>
                <a href="{{ route('login') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-6 rounded-lg">
                    Conectează-te
                </a>
            </div>
        @endguest
        <section class="mt-16">
            <h2 class="text-2xl font-bold mb-8">Comentarii ({{ $post->comments->count() }})</h2>

            @forelse($post->comments()->with('user')->latest()->get() as $comment)
                <article class="bg-gray-50 border-l-4 border-blue-500 p-6 mb-6 rounded-r-lg">
                    <div class="flex items-start space-x-4">
                        {{-- Avatar --}}
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                            {{ substr($comment->user->name ?? 'Anonim', 0, 2) }}
                        </div>

                        <div class="flex-1">
                            <header class="flex items-center justify-between mb-2">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $comment->user->name ?? 'Utilizator șters' }}</h4>
                                    <time class="text-sm text-gray-500">{{ $comment->created_at->format('d M Y, H:i') }}</time>
                                </div>

                                @auth
                                    @if(auth()->id() === $comment->user_id)
                                        <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                           class="text-sm text-blue-600 hover:underline">Editează</a>
                                    @endif
                                @endauth
                            </header>

                            <p class="text-gray-800 leading-relaxed">{{ $comment->body }}</p>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-gray-500 text-center py-12">Încă nu sunt comentarii. Fii primul!</p>
            @endforelse
        </section>

        <!-- Article Footer -->
        <footer class="mt-12 pt-8 border-t">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <p class="font-medium text-gray-900">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $post->user->email }}</p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </button>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </button>
                </div>
            </div>
        </footer>
    </article>
</x-layouts.public-app>
