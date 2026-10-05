<!DOCTYPE html>
<html lang="en" style="scroll-behavior:smooth;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        jakarta: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    colors: {
                        fashion: {
                            950: '#0c0a09',
                            900: '#1c1917',
                            800: '#292524',
                            700: '#44403c',
                            400: '#fbbf24',
                            300: '#fcd34d'
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.9s cubic-bezier(.2,.7,.2,1) forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'float-rev': 'float 7s ease-in-out infinite reverse',
                        'pulse-soft': 'pulseSoft 3s ease-in-out infinite',
                        'shimmer': 'shimmer 4s linear infinite',
                        'spin-slow': 'spin 28s linear infinite',
                        'marquee': 'marquee 28s linear infinite',
                        'drift': 'drift 14s ease-in-out infinite',
                        'sheen': 'sheen 3.5s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(30px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        float: {
                            '0%,100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-14px)'
                            }
                        },
                        pulseSoft: {
                            '0%,100%': {
                                opacity: '0.4'
                            },
                            '50%': {
                                opacity: '0.9'
                            }
                        },
                        shimmer: {
                            '0%': {
                                backgroundPosition: '0% center'
                            },
                            '100%': {
                                backgroundPosition: '200% center'
                            }
                        },
                        marquee: {
                            '0%': {
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                transform: 'translateX(-50%)'
                            }
                        },
                        drift: {
                            '0%,100%': {
                                transform: 'translate(0,0) scale(1)'
                            },
                            '50%': {
                                transform: 'translate(40px,-30px) scale(1.15)'
                            }
                        },
                        sheen: {
                            '0%': {
                                transform: 'translateX(-120%) skewX(-20deg)'
                            },
                            '60%,100%': {
                                transform: 'translateX(320%) skewX(-20deg)'
                            }
                        },
                    }
                }
            }
        }
    </script>
</head>

<body class="font-jakarta text-stone-100 antialiased"
    style="background:#0c0a09;font-family:'Plus Jakarta Sans',sans-serif;overflow-x:hidden;">

    <div id="progress" class="fixed top-0 left-0 z-[60] h-[3px]"
        style="width:0%;background:linear-gradient(90deg,#fbbf24,#fcd34d);box-shadow:0 0 12px rgba(251,191,36,.7);">
    </div>

    <header id="nav" class="fixed top-0 left-0 right-0 z-50"
        style="transition:all .4s ease;background:rgba(12,10,9,0);">
        <nav class="border-b"
            style="border-color:rgba(68,64,60,.5);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);background:rgba(28,25,23,.55);">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">

                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-xl bg-amber-400 flex items-center justify-center transition duration-300 group-hover:rotate-6"
                        style="box-shadow:0 8px 24px rgba(251,191,36,.25);">
                        <span class="text-stone-950 font-extrabold text-lg">FH</span>
                    </div>
                    <div>
                        <h1 class="font-extrabold tracking-tight text-xl">Fashion <span
                                class="text-amber-400">Hub</span></h1>
                        <p class="text-[10px] uppercase tracking-[0.25em] text-stone-500">Define Your Style</p>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#home" class="group relative text-sm text-stone-300 hover:text-white transition">Home
                        <span
                            class="absolute left-0 -bottom-2 h-[2px] w-0 bg-amber-400 transition-all duration-300 group-hover:w-full"></span></a>
                    <a href="#collection"
                        class="group relative text-sm text-stone-300 hover:text-white transition">Collection
                        <span
                            class="absolute left-0 -bottom-2 h-[2px] w-0 bg-amber-400 transition-all duration-300 group-hover:w-full"></span></a>
                    <a href="#about" class="group relative text-sm text-stone-300 hover:text-white transition">About
                        <span
                            class="absolute left-0 -bottom-2 h-[2px] w-0 bg-amber-400 transition-all duration-300 group-hover:w-full"></span></a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-stone-700 text-sm font-semibold text-stone-200 hover:bg-stone-800 hover:border-stone-600 transition duration-300">Login</a>
                    <a href="{{ route('register') }}"
                        class="relative overflow-hidden inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-amber-400 text-stone-950 text-sm font-bold hover:bg-amber-300 hover:-translate-y-0.5 transition duration-300"
                        style="box-shadow:0 8px 24px rgba(251,191,36,.25);">
                        <span class="absolute inset-y-0 left-0 w-1/3 animate-sheen"
                            style="background:linear-gradient(90deg,transparent,rgba(255,255,255,.55),transparent);"></span>
                        <span class="relative">Register</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="home" class="relative min-h-screen flex items-center overflow-hidden"
            style="background-image:linear-gradient(rgba(68,64,60,.10) 1px,transparent 1px),linear-gradient(90deg,rgba(68,64,60,.10) 1px,transparent 1px);background-size:50px 50px;">

            <div class="absolute rounded-full animate-drift pointer-events-none"
                style="top:-10%;left:-8%;width:520px;height:520px;background:radial-gradient(circle,rgba(251,191,36,.18),transparent 65%);filter:blur(40px);">
            </div>
            <div class="absolute rounded-full animate-drift pointer-events-none"
                style="bottom:-15%;right:5%;width:480px;height:480px;background:radial-gradient(circle,rgba(252,211,77,.12),transparent 65%);filter:blur(50px);animation-delay:-6s;">
            </div>

            <div id="spot" class="absolute inset-0 pointer-events-none"
                style="background:radial-gradient(500px circle at 70% 40%,rgba(251,191,36,.10),transparent 60%);transition:background .15s ease-out;">
            </div>

            <div class="absolute -top-40 -right-40 w-[520px] h-[520px] rounded-full border border-amber-400/10 animate-spin-slow pointer-events-none"
                style="border-style:dashed;"></div>
            <div
                class="absolute -bottom-60 -left-40 w-[520px] h-[520px] rounded-full border border-amber-400/10 animate-pulse-soft pointer-events-none">
            </div>

            <div class="absolute inset-0 pointer-events-none"
                style="background:radial-gradient(ellipse at center,transparent 40%,rgba(12,10,9,.85) 100%);"></div>

            <div class="relative max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-20 w-full">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="animate-fade-up inline-flex items-center gap-2 px-4 py-2 rounded-full border border-amber-400/20 bg-amber-400/5 text-amber-300 text-xs font-semibold uppercase tracking-[0.2em]"
                            style="opacity:0;">
                            <span class="relative flex w-2 h-2">
                                <span
                                    class="absolute inline-flex w-full h-full rounded-full bg-amber-400 animate-ping opacity-75"></span>
                                <span class="relative inline-flex w-2 h-2 rounded-full bg-amber-400"></span>
                            </span>
                            New Collection Available
                        </div>

                        <h2 class="animate-fade-up mt-7 text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-[1.05] tracking-tight"
                            style="opacity:0;animation-delay:.2s;">
                            Fashion<br>
                            <span class="animate-shimmer"
                                style="background:linear-gradient(90deg,#fbbf24,#fff7d6,#fcd34d,#fbbf24);background-size:200% auto;-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;color:transparent;">That
                                Defines</span><br>
                            You.
                        </h2>

                        <p class="animate-fade-up mt-7 max-w-xl text-lg leading-8 text-stone-400"
                            style="opacity:0;animation-delay:.4s;">
                            Discover a modern fashion experience built around your style. Explore premium products,
                            timeless designs, and pieces that make every look uniquely yours.
                        </p>

                        <div class="animate-fade-up mt-9 flex flex-wrap gap-4" style="opacity:0;animation-delay:.6s;">
                            <a href="{{ route('register') }}"
                                class="group relative overflow-hidden inline-flex items-center gap-3 px-7 py-4 rounded-xl bg-amber-400 text-stone-950 font-bold hover:bg-amber-300 hover:-translate-y-1 transition duration-300"
                                style="box-shadow:0 14px 40px rgba(251,191,36,.28);">
                                <span class="absolute inset-y-0 left-0 w-1/3 animate-sheen"
                                    style="background:linear-gradient(90deg,transparent,rgba(255,255,255,.6),transparent);"></span>
                                <span class="relative">Explore Fashion</span>
                                <span class="relative transition duration-300 group-hover:translate-x-1">→</span>
                            </a>
                            <a href="#collection"
                                class="inline-flex items-center px-7 py-4 rounded-xl border border-stone-700 text-stone-200 font-semibold hover:bg-stone-800 hover:border-amber-400/40 hover:-translate-y-1 transition duration-300"
                                style="background:rgba(28,25,23,.5);backdrop-filter:blur(8px);">View Collection</a>
                        </div>

                        <div class="animate-fade-up mt-12 flex flex-wrap gap-10 border-t border-stone-800 pt-8"
                            style="opacity:0;animation-delay:.8s;">
                            <div>
                                <p class="text-2xl font-extrabold text-white"><span data-count="100">0</span>+</p>
                                <p class="mt-1 text-xs text-stone-500">Fashion Products</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-white">Premium</p>
                                <p class="mt-1 text-xs text-stone-500">Quality Collection</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-white"><span data-count="24">0</span>/7</p>
                                <p class="mt-1 text-xs text-stone-500">Fashion Access</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative hidden lg:block" style="perspective:1200px;">
                        <div id="tilt" class="relative mx-auto w-full max-w-lg aspect-[4/5]"
                            style="transform-style:preserve-3d;transition:transform .2s ease-out;">

                            <div class="animate-float absolute inset-0 rounded-[2rem] border border-stone-700/80 overflow-hidden"
                                style="background:linear-gradient(160deg,#292524 0%,#1c1917 45%,#0c0a09 100%);box-shadow:0 0 0 1px rgba(251,191,36,.1),0 40px 100px rgba(0,0,0,.6),0 0 80px rgba(251,191,36,.08);">

                                <div class="absolute inset-0"
                                    style="background:linear-gradient(135deg,rgba(251,191,36,.18),transparent 55%,rgba(12,10,9,.9));">
                                </div>

                                <div class="absolute inset-y-0 left-0 w-1/4 animate-sheen"
                                    style="background:linear-gradient(90deg,transparent,rgba(252,211,77,.12),transparent);">
                                </div>

                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="font-extrabold leading-none select-none"
                                        style="font-size:190px;color:transparent;-webkit-text-stroke:1.5px rgba(251,191,36,.22);transform:translateZ(20px);">
                                        FH</div>
                                </div>

                                <div class="absolute inset-0 flex items-center justify-center"
                                    style="transform:translateZ(60px);">
                                    <div class="text-center relative z-10">
                                        <div class="relative w-24 h-24 mx-auto rounded-3xl bg-amber-400 flex items-center justify-center"
                                            style="box-shadow:0 20px 60px rgba(251,191,36,.45),inset 0 2px 0 rgba(255,255,255,.5);">
                                            <span
                                                class="absolute -inset-3 rounded-[2rem] border border-amber-400/30 animate-pulse-soft"></span>
                                            <span class="text-3xl font-extrabold text-stone-950">FH</span>
                                        </div>
                                        <h3 class="mt-6 text-3xl font-extrabold">Fashion Hub</h3>
                                        <p class="mt-2 text-sm text-stone-500">Style. Quality. You.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="animate-float-rev absolute top-8 -right-6 rounded-2xl px-4 py-3 border border-stone-700"
                                style="background:rgba(28,25,23,.75);backdrop-filter:blur(18px);box-shadow:0 20px 50px rgba(0,0,0,.5);transform:translateZ(90px);">
                                <p class="text-[10px] uppercase tracking-widest text-stone-500">Your Style</p>
                                <p class="mt-1 text-sm font-bold text-amber-400">Your Identity</p>
                            </div>

                            <div class="animate-float absolute bottom-8 -left-8 rounded-2xl px-5 py-4 border border-stone-700"
                                style="background:rgba(28,25,23,.75);backdrop-filter:blur(18px);box-shadow:0 20px 50px rgba(0,0,0,.5);transform:translateZ(80px);animation-delay:-2s;">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-stone-800 flex items-center justify-center text-amber-400">
                                        ✦</div>
                                    <div>
                                        <p class="text-xs text-stone-500">Fashion Hub</p>
                                        <p class="text-sm font-bold">Made for You</p>
                                    </div>
                                </div>
                            </div>

                            <div class="animate-float-rev absolute top-1/2 -left-10 rounded-full px-4 py-2 border border-amber-400/30 text-xs font-bold text-amber-300"
                                style="background:rgba(251,191,36,.08);backdrop-filter:blur(10px);transform:translateZ(50px);animation-delay:-4s;">
                                ★ Premium
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="#collection"
                class="absolute bottom-7 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-stone-600 hover:text-amber-400 transition">
                <span class="text-[9px] uppercase tracking-[0.3em]">Scroll</span>
                <span class="text-lg animate-bounce">↓</span>
            </a>
        </section>

        <section class="relative overflow-hidden border-y border-stone-800 py-5" style="background:#1c1917;">
            <div class="flex w-max animate-marquee whitespace-nowrap">
                @for ($i = 0; $i < 2; $i++)
                    <div
                        class="flex items-center gap-10 pr-10 text-sm font-semibold uppercase tracking-[0.3em] text-stone-500">
                        <span>Streetwear</span><span class="text-amber-400">✦</span>
                        <span>Formal</span><span class="text-amber-400">✦</span>
                        <span>Casual</span><span class="text-amber-400">✦</span>
                        <span>Accessories</span><span class="text-amber-400">✦</span>
                        <span>Footwear</span><span class="text-amber-400">✦</span>
                        <span>Seasonal</span><span class="text-amber-400">✦</span>
                    </div>
                @endfor
            </div>
        </section>

        <section id="collection" class="relative py-28 overflow-hidden" style="background:#0c0a09;">
            <div class="absolute left-1/2 top-0 -translate-x-1/2 w-[700px] h-[300px] pointer-events-none"
                style="background:radial-gradient(ellipse,rgba(251,191,36,.08),transparent 70%);"></div>

            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center" data-reveal>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">Explore Fashion</p>
                    <h2 class="mt-4 text-4xl sm:text-5xl font-extrabold tracking-tight">
                        Everything Starts <span class="text-amber-400">With Style.</span>
                    </h2>
                    <p class="mt-5 text-stone-400 leading-7">Fashion Hub brings your everyday fashion experience
                        together in one modern place.</p>
                </div>

                <div class="mt-16 grid md:grid-cols-3 gap-6">
                    @php
                        $cards = [
                            [
                                '✦',
                                'Premium Style',
                                'Discover carefully selected fashion pieces designed to elevate your everyday appearance.',
                            ],
                            [
                                '◇',
                                'Modern Collection',
                                'From timeless essentials to modern trends, find pieces that fit your personal fashion identity.',
                            ],
                            [
                                '❖',
                                'Made For You',
                                'Browse, save and shop looks that match your taste, anytime and from any device.',
                            ],
                        ];
                    @endphp
                    @foreach ($cards as $i => $c)
                        <div data-reveal data-delay="{{ $i * 150 }}"
                            class="group relative overflow-hidden rounded-2xl border border-stone-800 p-8 transition duration-500 hover:-translate-y-2 hover:border-amber-400/40"
                            style="background:linear-gradient(160deg,rgba(41,37,36,.7),rgba(28,25,23,.6));box-shadow:0 20px 50px rgba(0,0,0,.3);">
                            <div class="absolute -top-20 -right-20 w-48 h-48 rounded-full opacity-0 group-hover:opacity-100 transition duration-500"
                                style="background:radial-gradient(circle,rgba(251,191,36,.25),transparent 70%);"></div>
                            <div
                                class="relative w-14 h-14 rounded-2xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center transition duration-500 group-hover:bg-amber-400 group-hover:rotate-12 group-hover:scale-110">
                                <span
                                    class="text-2xl text-amber-400 transition duration-500 group-hover:text-stone-950">{{ $c[0] }}</span>
                            </div>
                            <h3 class="relative mt-7 text-xl font-bold">{{ $c[1] }}</h3>
                            <p class="relative mt-3 text-sm leading-7 text-stone-500">{{ $c[2] }}</p>
                            <div
                                class="absolute bottom-0 left-0 h-[2px] w-0 bg-amber-400 transition-all duration-500 group-hover:w-full">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="about" class="relative py-28 border-t border-stone-800" style="background:#1c1917;">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">
                <div data-reveal>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">About Fashion Hub</p>
                    <h2 class="mt-4 text-4xl sm:text-5xl font-extrabold tracking-tight">Built around how you dress.
                    </h2>
                    <p class="mt-6 text-stone-400 leading-8">We curate pieces that balance quality, comfort and
                        character, so your wardrobe feels personal instead of generic.</p>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    @php $stats = [[100, '+', 'Products'], [24, '/7', 'Access'], [50, '+', 'Styles'], [100, '%', 'Quality focus']]; @endphp
                    @foreach ($stats as $i => $s)
                        <div data-reveal data-delay="{{ $i * 120 }}"
                            class="rounded-2xl border border-stone-800 p-6 text-center hover:border-amber-400/40 hover:-translate-y-1 transition duration-300"
                            style="background:rgba(12,10,9,.6);">
                            <p class="text-4xl font-extrabold text-amber-400"><span
                                    data-count="{{ $s[0] }}">0</span>{{ $s[1] }}</p>
                            <p class="mt-2 text-xs text-stone-500">{{ $s[2] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="relative py-28 overflow-hidden" style="background:#0c0a09;">
            <div class="absolute inset-0 pointer-events-none"
                style="background:radial-gradient(circle at center,rgba(251,191,36,.14),transparent 60%);"></div>
            <div data-reveal class="relative max-w-3xl mx-auto px-6 text-center">
                <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Ready to find your <span
                        class="text-amber-400">look?</span></h2>
                <p class="mt-5 text-stone-400">Create your free account and start exploring the collection today.</p>
                <a href="{{ route('register') }}"
                    class="relative overflow-hidden mt-9 inline-flex items-center gap-3 px-8 py-4 rounded-xl bg-amber-400 text-stone-950 font-bold hover:bg-amber-300 hover:-translate-y-1 transition duration-300"
                    style="box-shadow:0 14px 40px rgba(251,191,36,.3);">
                    <span class="absolute inset-y-0 left-0 w-1/3 animate-sheen"
                        style="background:linear-gradient(90deg,transparent,rgba(255,255,255,.6),transparent);"></span>
                    <span class="relative">Create account</span>
                </a>
            </div>
        </section>
    </main>

    <footer class="border-t border-stone-800 py-8 text-center text-xs text-stone-600" style="background:#0c0a09;">
        © {{ date('Y') }} Fashion Hub. All rights reserved.
    </footer>

    <script>
        document.querySelectorAll('[data-reveal]').forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = 'opacity .9s cubic-bezier(.2,.7,.2,1), transform .9s cubic-bezier(.2,.7,.2,1)';
            el.style.transitionDelay = (el.dataset.delay || 0) + 'ms';
        });

        function countUp(el) {
            var target = +el.dataset.count,
                start = null;

            function step(t) {
                if (!start) start = t;
                var p = Math.min((t - start) / 1600, 1);
                el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
                if (p < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (!e.isIntersecting) return;
                var el = e.target;
                if (el.hasAttribute('data-reveal')) {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                    el.querySelectorAll('[data-count]').forEach(countUp);
                }
                if (el.hasAttribute('data-count')) countUp(el);
                io.unobserve(el);
            });
        }, {
            threshold: 0.2
        });
        document.querySelectorAll('[data-reveal]').forEach(function(el) {
            io.observe(el);
        });
        document.querySelectorAll('#home [data-count]').forEach(function(el) {
            io.observe(el);
        });

        var nav = document.getElementById('nav'),
            bar = document.getElementById('progress');
        window.addEventListener('scroll', function() {
            var h = document.documentElement;
            bar.style.width = (h.scrollTop / (h.scrollHeight - h.clientHeight) * 100) + '%';
            nav.style.boxShadow = h.scrollTop > 20 ? '0 10px 40px rgba(0,0,0,.5)' : 'none';
        }, {
            passive: true
        });

        var hero = document.getElementById('home'),
            spot = document.getElementById('spot'),
            tilt = document.getElementById('tilt');
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            hero.addEventListener('mousemove', function(e) {
                var r = hero.getBoundingClientRect(),
                    x = e.clientX - r.left,
                    y = e.clientY - r.top;
                spot.style.background = 'radial-gradient(500px circle at ' + x + 'px ' + y +
                    'px, rgba(251,191,36,.12), transparent 60%)';
                var px = (e.clientX / window.innerWidth - 0.5),
                    py = (e.clientY / window.innerHeight - 0.5);
                tilt.style.transform = 'rotateY(' + (px * 14) + 'deg) rotateX(' + (-py * 14) + 'deg)';
            });
            hero.addEventListener('mouseleave', function() {
                tilt.style.transform = 'rotateY(0) rotateX(0)';
            });
        }
    </script>
</body>

</html>
