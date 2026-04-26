<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ToolVerse | Specialized Web Utilities</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out backwards;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen">
    <div class="container mx-auto px-4 py-12 max-w-7xl">
        <div class="mb-6 flex justify-end gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-lg bg-white/10 px-4 py-2 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg bg-white/10 px-4 py-2 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-lg bg-white/10 px-4 py-2 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                    Login
                </a>
            @endauth
        </div>

        <!-- Header Section -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-block bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-4">
                <span class="text-white/90 text-sm font-medium">✨ Premium Tool Collection ✨</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold bg-gradient-to-r from-white via-purple-200 to-pink-200 bg-clip-text text-transparent mb-4">
                ToolVerse Hub
            </h1>
            <p class="text-purple-200 text-lg max-w-2xl mx-auto">
                Curated web utilities for developers, creators, and power users
            </p>
        </div>

        <!-- Stats Bar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12 animate-fade-in">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center">
                <div class="text-white/70 text-sm mb-1">Total Tools</div>
                <div class="text-white text-3xl font-bold">5</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center">
                <div class="text-white/70 text-sm mb-1">Instant Access</div>
                <div class="text-white text-3xl font-bold">24/7</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center">
                <div class="text-white/70 text-sm mb-1">Privacy Focused</div>
                <div class="text-white text-3xl font-bold">✓</div>
            </div>
        </div>

        <!-- Tools Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $tools = [
                    [
                        'slug' => '5e-hp-tracker',
                        'name' => 'D&D 5e Hit Point Calculator',
                        'url' => 'https://5ehptracker.online',
                        'description' => 'A Dungeons & Dragons 5th Edition hit point calculator with average, minimum, and maximum HP totals plus level-by-level breakdowns.',
                        'icon' => '🎲',
                        'category' => 'Gaming',
                        'color' => 'from-orange-500 to-red-600',
                    ],
                    [
                        'slug' => 'bpm-tap-tempo',
                        'name' => 'BPM Tap Tempo Tool',
                        'url' => 'https://bpmtaptempo.online',
                        'description' => 'A BPM tap tempo tool for musicians and producers with metronome options, accuracy analysis, and history tracking.',
                        'icon' => '🎵',
                        'category' => 'Music',
                        'color' => 'from-green-500 to-emerald-600',
                    ],
                    [
                        'slug' => 'edu-calculator-hub',
                        'name' => 'Education Calculator Hub',
                        'url' => 'https://edu-calculator-hub.online',
                        'description' => 'A collection of US education calculators including GPA, SAT/ACT prediction, admissions, scholarships, tuition, and planning tools.',
                        'icon' => '📚',
                        'category' => 'Education',
                        'color' => 'from-blue-500 to-cyan-600',
                    ],
                    [
                        'slug' => 'aghslabore',
                        'name' => 'AGHS Labore',
                        'url' => 'https://aghslabore.pk',
                        'description' => 'Professional laboratory services and solutions provider with comprehensive testing capabilities.',
                        'icon' => '🔬',
                        'category' => 'Science',
                        'color' => 'from-purple-500 to-pink-600',
                    ],
                    [
                        'slug' => 'json-into-toon',
                        'name' => 'JSON Into TOON Converter',
                        'url' => 'https://json-into-toon.site',
                        'description' => 'A browser-based converter for JSON and TOON formats with lossless conversion and privacy-focused processing.',
                        'icon' => '🔄',
                        'category' => 'Development',
                        'color' => 'from-indigo-500 to-purple-600',
                    ],
                ];
            @endphp

            @foreach ($tools as $index => $tool)
                @php
                    $delayClass = '';
                    if ($index === 0) $delayClass = 'card-delay-1';
                    elseif ($index === 1) $delayClass = 'card-delay-2';
                    elseif ($index === 2) $delayClass = 'card-delay-3';
                    elseif ($index === 3) $delayClass = 'card-delay-4';
                    elseif ($index === 4) $delayClass = 'card-delay-5';
                @endphp
                <div class="group animate-fade-in-up {{ $delayClass }}">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 h-full flex flex-col">
                        <!-- Gradient Bar -->
                        <div class="h-2 bg-gradient-to-r {{ $tool['color'] }}"></div>
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <!-- Icon and Category -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-5xl">{{ $tool['icon'] }}</div>
                                <span class="text-xs font-semibold px-3 py-1 bg-gradient-to-r {{ $tool['color'] }} bg-clip-text text-transparent border border-gray-200 rounded-full">
                                    {{ $tool['category'] }}
                                </span>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-xl font-bold text-gray-800 mb-3">
                                {{ $tool['name'] }}
                            </h2>
                            
                            <!-- Description -->
                            <p class="text-gray-600 text-sm leading-relaxed mb-4 flex-1">
                                {{ $tool['description'] }}
                            </p>
                            
                            <!-- URL Preview -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                <div class="flex items-start gap-2">
                                    <span class="text-gray-500 text-xs font-semibold mt-0.5">🔗</span>
                                    <div class="flex-1">
                                        <div class="text-gray-400 text-xs mb-1">Direct URL</div>
                                        <code class="text-xs text-purple-600 break-all">{{ $tool['url'] }}</code>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Button - Direct link to tool URL -->
                            <a href="{{ $tool['url'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center justify-center gap-2 bg-gradient-to-r {{ $tool['color'] }} text-white font-semibold py-3 px-4 rounded-xl hover:shadow-lg transition-all duration-300 hover:gap-3 group">
                                <span>Launch Tool</span>
                                <span class="text-lg transition-transform duration-300 group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Footer -->
        <div class="mt-16 pt-8 border-t border-white/20 text-center">
            <p class="text-purple-200 text-sm">
                © {{ date('Y') }} ToolVerse Hub | Secure Direct Access | All tools are independently operated
            </p>
            <p class="text-purple-300/70 text-xs mt-2">
                ✨ Click any card to access the tool directly ✨
            </p>
        </div>
    </div>

    <style>
        .card-delay-1 { animation-delay: 0.1s; }
        .card-delay-2 { animation-delay: 0.2s; }
        .card-delay-3 { animation-delay: 0.3s; }
        .card-delay-4 { animation-delay: 0.4s; }
        .card-delay-5 { animation-delay: 0.5s; }
    </style>
</body>
</html>
