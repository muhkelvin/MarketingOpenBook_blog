@extends('layouts.app')

@section('title', 'Categories - MarketJourney')
@section('meta_description', 'Explore articles by category')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $category)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="font-playfair text-2xl text-secondary mb-2">
                    {{ $category->name }}
                </h2>
                <p class="text-darkgray/90 mb-4">
                    {{ $category->articles_count }} articles
                </p>
                <a href="{{ route('tag.show',$category->slug) }}" class="text-accent hover:text-sage transition-colors">
                    View Articles →
                </a>
            </div>
        @endforeach
    </div>
@endsection
