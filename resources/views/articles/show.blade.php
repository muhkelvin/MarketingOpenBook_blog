@extends('layouts.app')

@section('title', $article->meta_title ?? $article->title)
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->body), 150))

{{-- Pastikan layout Anda menyediakan yield('head') di bagian <head> --}}
@section('head')
    <script type="application/ld+json">
        {!! json_encode([
            "@context"      => "https://schema.org",
            "@type"         => "Article",
            "headline"      => $article->title,
            "description"   => $article->meta_description ?? Str::limit(strip_tags($article->body), 150),
            "image"         => $article->image,
            "datePublished" => $article->published_at->toIso8601String(),
            "dateModified" => $article->updated_at->toIso8601String(),
            "author"        => [
                "@type" => "Person",
                "name"  => 'Marketing Open Books'
            ],
            "publisher"     => [
                "@type" => "Organization",
                "name"  => "Marketing Open Books",
                "logo"  => [
                    "@type" => "ImageObject",
                    "url"   => asset('icon.jpg')
                ]
            ],
            "keywords"      => $article->tags->pluck('name')
        ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-12">
        <article class="max-w-4xl mx-auto">
            <!-- Article Header -->
            <header class="mb-16 text-center">
                <div class="mb-8 flex flex-wrap gap-3 justify-center">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}"
                           class="px-4 py-2 text-sm font-montserrat bg-sage/10 text-secondary rounded-full hover:bg-sage/20 transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                <h1 class="font-playfair text-4xl md:text-5xl lg:text-6xl text-secondary leading-tight mb-6">
                    {{ $article->title }}
                </h1>

                @if($article->published_at)
                    <div class="flex flex-col md:flex-row items-center justify-center md:space-x-6 space-y-3 md:space-y-0 text-darkgray/80 font-montserrat">
                        <div class="flex items-center">
                            <time>{{ $article->published_at->isoFormat('MMMM Do, YYYY') }}</time>
                            <span class="w-1 h-1 bg-accent rounded-full mx-3"></span>
                            <span>{{ $article->reading_time ?? '5' }} min read</span>
                        </div>
                        <span class="hidden md:inline-block text-sm">•</span>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $article->views ?? '0' }} views
                        </div>
                    </div>
                @endif
            </header>

            <!-- Featured Image -->
            @if($article->image)
                <figure class="relative mb-16 rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ $article->image }}" alt="{{ $article->title }}"
                         referrerpolicy="no-referrer"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-auto md:h-[400px] lg:h-[560px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-secondary/40 to-transparent opacity-50"></div>
                </figure>
            @endif

            <!-- Article Content -->
            <div class="prose prose-lg max-w-none lg:prose-xl font-lora text-darkgray prose-headings:font-playfair prose-headings:text-secondary prose-a:text-accent prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl prose-img:shadow-md">
                {!! $article->body !!}
            </div>

            <!-- Tags -->
            <div class="mt-12 flex flex-wrap gap-3">
                <span class="font-montserrat text-darkgray/80 mr-2">Tags:</span>
                @foreach($article->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}"
                       class="px-3 py-1 text-sm font-montserrat bg-sage/10 text-secondary rounded-full hover:bg-sage/20 transition-colors">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>

            <!-- Social Sharing -->
            <div class="mt-16 pt-12 border-t border-accent/20">
                <div class="flex flex-col items-center space-y-6">
                    <h3 class="font-playfair text-2xl text-secondary">Share this article</h3>
                    <div class="flex space-x-6">
                        <a href="https://twitter.com/share?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}"
                           class="p-3 rounded-full bg-sage/10 hover:bg-sage/20 transition-colors"
                           target="_blank" rel="noopener noreferrer" aria-label="Share on Twitter">
                            <svg class="w-6 h-6 text-accent" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                           class="p-3 rounded-full bg-sage/10 hover:bg-sage/20 transition-colors"
                           target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook">
                            <svg class="w-6 h-6 text-accent" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($article->title) }}"
                           class="p-3 rounded-full bg-sage/10 hover:bg-sage/20 transition-colors"
                           target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn">
                            <svg class="w-6 h-6 text-accent" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode(url()->current()) }}"
                           class="p-3 rounded-full bg-sage/10 hover:bg-sage/20 transition-colors"
                           target="_blank" rel="noopener noreferrer" aria-label="Share via Email">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                           class="p-3 rounded-full bg-sage/10 hover:bg-sage/20 transition-colors"
                           target="_blank" rel="noopener noreferrer" aria-label="Share on WhatsApp">
                            <svg class="w-6 h-6 text-accent" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div> <!-- Tutup Social Sharing -->

            <!-- Related Articles -->
            @if(isset($relatedArticles) && $relatedArticles->count() > 0)
                <div class="mt-20 pt-12 border-t border-accent/20">
                    <h3 class="font-playfair text-3xl text-secondary mb-8 text-center">You may also like</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($relatedArticles as $relatedArticle)
                            <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="group">
                                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden h-full flex flex-col">
                                    @if($relatedArticle->image)
                                        <div class="relative h-48 overflow-hidden">
                                            <img src="{{ $relatedArticle->image }}" alt="{{ $relatedArticle->title }}"
                                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-gradient-to-t from-secondary/40 to-transparent"></div>
                                        </div>
                                    @endif
                                    <div class="p-6">
                                        <h4 class="font-playfair text-xl text-secondary group-hover:text-accent transition-colors mb-2">
                                            {{ $relatedArticle->title }}
                                        </h4>
                                        <p class="text-sm text-darkgray/80 line-clamp-2">
                                            {{ $relatedArticle->excerpt }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <div class="mt-16 flex flex-col sm:flex-row justify-between items-center border-t border-accent/20 pt-8">
                @if(isset($previousArticle))
                    <a href="{{ route('articles.show', $previousArticle->slug) }}" class="flex items-center text-accent hover:text-sage transition-colors mb-4 sm:mb-0">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                        </svg>
                        Previous Article
                    </a>
                @else
                    <div></div>
                @endif

                <a href="{{ route('articles.index') }}" class="text-darkgray/60 hover:text-darkgray transition-colors mx-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </a>

                @if(isset($nextArticle))
                    <a href="{{ route('articles.show', $nextArticle->slug) }}" class="flex items-center text-accent hover:text-sage transition-colors">
                        Next Article
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                @else
                    <div></div>
                @endif
            </div>
        </article>
    </div>
@endsection
