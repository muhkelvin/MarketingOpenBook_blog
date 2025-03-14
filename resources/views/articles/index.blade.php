@extends('layouts.app')

@section('title', 'Home - MarketJourney')
@section('meta_description', 'Latest marketing insights and strategies')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <article class="relative bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden">
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-accent/10 to-sage/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>

                @if($article->image)
                    <div class="relative h-60 overflow-hidden rounded-t-xl">
                        <img src="{{ $article->image }}" alt="{{ $article->title }}"
                             referrerpolicy="no-referrer"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary/40 to-transparent"></div>
                    </div>
                @endif

                <div class="p-6">
                    <header class="mb-4">
                        <div class="flex items-center justify-between mb-3">
                            @if($article->published_at)
                                <time class="text-sm text-darkgray/80 font-montserrat">
                                    {{ $article->published_at->isoFormat('MMM Do, YYYY') }}
                                </time>
                            @endif
                            <div class="flex space-x-2">
                                @foreach($article->tags->take(2) as $tag)
                                    <a href="{{ route('tag.show', $tag->slug) }}"
                                       class="px-3 py-1 text-xs font-montserrat bg-sage/10 text-secondary rounded-full hover:bg-sage/20 transition-colors">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <h2 class="font-playfair text-2xl text-secondary leading-tight mb-2 hover:text-accent transition-colors">
                            <a href="{{ route('articles.show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h2>
                    </header>

                    <p class="text-darkgray/90 leading-relaxed mb-4 font-lora line-clamp-3">
                        {{ $article->excerpt }}
                    </p>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('articles.show', $article->slug) }}"
                           class="relative z-10 inline-flex items-center text-accent hover:text-sage transition-colors font-medium">
                            Continue Reading
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <span class="text-sm text-darkgray/60 font-montserrat">
                    {{ $article->reading_time }} min read
                </span>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-16">
        {{ $articles->links() }}
    </div>
@endsection
