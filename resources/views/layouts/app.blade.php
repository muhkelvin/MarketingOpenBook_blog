<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Marketing Blog')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Professional marketing insights and strategies')">
    <meta name="keywords" content="@yield('meta_keywords', 'marketing, blog, digital strategy')">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('icon.jpg') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-playfair {
            font-family: 'Playfair Display', serif;
            letter-spacing: -0.025em;
        }
        .font-montserrat {
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.01em;
        }
    </style>

    @yield('schema')

</head>

<body class="bg-primary text-darkgray font-lora antialiased">
<!-- Header -->
<header class="bg-secondary fixed w-full top-0 z-50 shadow-sm"
        x-data="{ isOpen: false, showBorder: false }"
        @scroll.window="showBorder = window.scrollY > 50">
    <div class="container mx-auto px-4 lg:px-8">
        <nav class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}"
               class="font-playfair text-3xl font-semibold text-white hover:text-accent transition-colors italic">
                Marketing<span class="text-accent">OpenBook</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex space-x-10">
                <a href="{{ route('home') }}"
                   class="font-montserrat text-lg font-medium text-white/90 hover:text-accent px-2 py-1.5 border-b-2 border-transparent hover:border-accent transition-all">
                    Home
                </a>
                <a href="{{ route('articles.index') }}"
                   class="font-montserrat text-lg font-medium text-white/90 hover:text-accent px-2 py-1.5 border-b-2 border-transparent hover:border-accent transition-all">
                    Articles
                </a>
                <a href="{{ route('category.index') }}"
                   class="font-montserrat text-lg font-medium text-white/90 hover:text-accent px-2 py-1.5 border-b-2 border-transparent hover:border-accent transition-all">
                    Categories
                </a>
                <a href="{{ route('about') }}"
                   class="font-montserrat text-lg font-medium text-white/90 hover:text-accent px-2 py-1.5 border-b-2 border-transparent hover:border-accent transition-all">
                    About
                </a>
                <a href="{{ route('contact') }}"
                   class="font-montserrat text-lg font-medium text-white/90 hover:text-accent px-2 py-1.5 border-b-2 border-transparent hover:border-accent transition-all">
                    Contact
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="isOpen = !isOpen" class="lg:hidden text-white hover:text-accent transition-colors">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        </nav>

        <!-- Mobile Menu -->
        <div class="lg:hidden relative">
            <div x-show="isOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 class="absolute w-full bg-secondary/95 backdrop-blur-sm py-5 space-y-4 rounded-b-lg shadow-xl">
                <a href="{{ route('home') }}"
                   class="block px-6 py-3 text-lg font-medium text-white hover:bg-secondary/80 transition-colors">
                    Home
                </a>
                <a href="{{ route('articles.index') }}"
                   class="block px-6 py-3 text-lg font-medium text-white hover:bg-secondary/80 transition-colors">
                    Articles
                </a>
                <a href="{{ route('category.index') }}"
                   class="block px-6 py-3 text-lg font-medium text-white hover:bg-secondary/80 transition-colors">
                    Categories
                </a>
                <a href="{{ route('about') }}"
                   class="block px-6 py-3 text-lg font-medium text-white hover:bg-secondary/80 transition-colors">
                    About
                </a>
                <a href="{{ route('contact') }}"
                   class="block px-6 py-3 text-lg font-medium text-white hover:bg-secondary/80 transition-colors">
                    Contact
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="h-[3px] bg-gradient-to-r from-accent to-sage transition-opacity duration-300"
         :class="showBorder ? 'opacity-100' : 'opacity-0'"></div>
</header>
<!-- Main Content -->
<main class="container mx-auto pt-28 pb-12 px-4 lg:px-8">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-secondary text-white mt-20 border-t-8 border-accent/20">
    <div class="container mx-auto px-4 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
            <!-- Brand Section -->
            <div class="space-y-6">
                <h3 class="font-playfair text-3xl font-semibold text-accent italic">
                    Marketing<span class="text-white">OpenBook</span>
                </h3>
                <p class="font-montserrat text-base leading-relaxed opacity-90">
                    Your premier destination for cutting-edge marketing insights.<br>
                    Bridging theory and practice in digital strategy.
                </p>
            </div>

            <!-- Navigation Links - Manual Links -->
            <div class="lg:pl-8">
                <h4 class="font-playfair text-xl font-semibold mb-6 text-accent">Explore</h4>
                <nav class="space-y-4">
                    <a href="{{ route('home') }}"
                       class="font-montserrat text-base hover:text-accent transition-colors flex items-center group">
                        <span class="w-3 h-3 bg-accent rounded-full mr-3 transition-transform group-hover:scale-125"></span>
                        Home
                    </a>
                    <a href="{{ route('category.index') }}"
                       class="font-montserrat text-base hover:text-accent transition-colors flex items-center group">
                        <span class="w-3 h-3 bg-accent rounded-full mr-3 transition-transform group-hover:scale-125"></span>
                        Categories
                    </a>
                    <a href="{{ route('about') }}"
                       class="font-montserrat text-base hover:text-accent transition-colors flex items-center group">
                        <span class="w-3 h-3 bg-accent rounded-full mr-3 transition-transform group-hover:scale-125"></span>
                        About
                    </a>
                    <a href="{{ route('contact') }}"
                       class="font-montserrat text-base hover:text-accent transition-colors flex items-center group">
                        <span class="w-3 h-3 bg-accent rounded-full mr-3 transition-transform group-hover:scale-125"></span>
                        Contact
                    </a>
                </nav>
            </div>

            <!-- Newsletter -->
            <div class="lg:pl-8">
                <h4 class="font-playfair text-xl font-semibold mb-6 text-accent">Stay Updated</h4>

                @if(session('subscribe_success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('subscribe_success') }}
                    </div>
                @endif

                <form action="{{ route('subscribe.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="relative">
                        <input type="email"
                               name="email"
                               class="w-full p-4 font-montserrat text-sm bg-secondary/20 border-2 border-gray-600 rounded-xl focus:outline-none focus:border-accent placeholder-gray-400"
                               placeholder="Enter your email" required>
                        <button type="submit"
                                class="absolute right-2 top-2 bg-accent hover:bg-accent/90 text-secondary font-montserrat font-bold py-2 px-6 rounded-lg transition-colors">
                            Join
                        </button>
                    </div>
                    <p class="font-montserrat text-sm opacity-75">
                        Get exclusive marketing insights delivered to your inbox.
                    </p>
                </form>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-600/50 mt-16 pt-8">
            <div class="flex flex-col lg:flex-row items-center justify-between text-base">
                <p class="opacity-75 text-center mb-4 lg:mb-0 font-montserrat">
                    © {{ date('Y') }} MarketingOpenBooks. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-accent transition-colors font-medium">Privacy</a>
                    <a href="#" class="hover:text-accent transition-colors font-medium">Terms</a>
                    <a href="#" class="hover:text-accent transition-colors font-medium">Contact</a>
                </div>
            </div>
        </div>
    </div>
</footer>



<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'GA_MEASUREMENT_ID');
</script>

<!-- Alpine.js Script -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script async src="//s.imgur.com/min/embed.js" charset="utf-8"></script>

</body>
</html>
