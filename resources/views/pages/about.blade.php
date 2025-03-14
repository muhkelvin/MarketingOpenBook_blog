@extends('layouts.app')

@section('title', 'About - MarketJourney')
@section('meta_description', 'Learn more about MarketJourney and our mission in digital marketing education')

@section('content')
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
        <header class="mb-16 text-center">
            <h1 class="font-playfair text-4xl lg:text-5xl text-secondary mb-6">
                Shaping the Future of
                <span class="text-accent">Marketing Education</span>
            </h1>
            <p class="font-montserrat text-darkgray/80 text-lg max-w-3xl mx-auto">
                Bridging the gap between academic theory and real-world digital marketing practice
            </p>
        </header>

        <div class="grid lg:grid-cols-2 gap-16 mb-24">
            <div class="space-y-6">
                <h2 class="font-playfair text-3xl text-secondary mb-4">Our Story</h2>
                <p class="font-lora text-darkgray/90 leading-relaxed">
                    Founded in 2025, MarketJourney emerged from a simple yet powerful idea - to create a platform
                    where marketing professionals and enthusiasts can access practical, up-to-date industry knowledge.
                    What started as a small blog has grown into a comprehensive resource hub trusted by thousands.
                </p>
            </div>

            <div class="bg-sage/10 rounded-2xl p-8 lg:p-12">
                <img src="{{ asset('icon.jpg') }}" alt="Our Team"
                     class="rounded-xl shadow-lg w-full h-64 object-cover">
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-12 text-center">
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="text-accent text-4xl mb-4">100</div>
                <h3 class="font-playfair text-xl text-secondary mb-2">Published Articles</h3>
                <p class="text-darkgray/80">Deep-dive analyses and practical guides</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="text-accent text-4xl mb-4">98%</div>
                <h3 class="font-playfair text-xl text-secondary mb-2">Positive Feedback</h3>
                <p class="text-darkgray/80">From our growing community</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="text-accent text-4xl mb-4">1000</div>
                <h3 class="font-playfair text-xl text-secondary mb-2">Monthly Readers</h3>
                <p class="text-darkgray/80">Engaged marketing professionals</p>
            </div>
        </div>
    </div>
@endsection
