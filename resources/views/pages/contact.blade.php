@extends('layouts.app')

@section('title', 'Contact - MarketJourney')
@section('meta_description', 'Get in touch with MarketJourney team for collaborations, inquiries, or feedback')

@section('content')
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-16">
        <div class="grid lg:grid-cols-2 gap-16">
            <!-- Contact Form -->
            <div class="lg:pr-12">
                <header class="mb-12">
                    <h1 class="font-playfair text-4xl lg:text-5xl text-secondary mb-4">
                        Let's Connect
                    </h1>
                    <p class="font-montserrat text-darkgray/80">
                        Have questions, suggestions, or partnership inquiries? We're all ears.
                    </p>
                </header>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div>
                        <label class="font-montserrat block text-secondary mb-2">Full Name</label>
                        <input type="text" name="name"
                               class="w-full p-4 bg-white border-2 border-sage/20 rounded-lg focus:border-accent focus:ring-0"
                               placeholder="John Doe" required>
                    </div>

                    <div>
                        <label class="font-montserrat block text-secondary mb-2">Email Address</label>
                        <input type="email" name="email"
                               class="w-full p-4 bg-white border-2 border-sage/20 rounded-lg focus:border-accent focus:ring-0"
                               placeholder="hello@example.com" required>
                    </div>

                    <div>
                        <label class="font-montserrat block text-secondary mb-2">Message</label>
                        <textarea name="message" rows="5"
                                  class="w-full p-4 bg-white border-2 border-sage/20 rounded-lg focus:border-accent focus:ring-0"
                                  placeholder="Your message..." required></textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-accent text-white font-montserrat font-bold py-4 px-8 rounded-lg hover:brightness-125 transition-colors">
                        Send Message
                    </button>

                </form>
            </div>

            <!-- Contact Info -->
            <div class="lg:pl-12">
                <div class="bg-sage/10 rounded-2xl p-8 lg:p-12 h-full">
                    <h2 class="font-playfair text-3xl text-secondary mb-8">Other Ways to Reach Us</h2>

                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-accent text-white p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-montserrat font-semibold text-secondary mb-2">Email</h3>
                                <p class="text-darkgray/80">muhkelvin36@gmail.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-accent text-white p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-montserrat font-semibold text-secondary mb-2">Office</h3>
                                <p class="text-darkgray/80">
                                    Indonesia<br>
                                    jambi City, 36123
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-accent text-white p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-montserrat font-semibold text-secondary mb-2">Phone</h3>
                                <p class="text-darkgray/80">+62 89526323412</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
