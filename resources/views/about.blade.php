<x-app-layout>
    <x-slot name="header">
        <h2 class="sr-only">Par VolleyLV</h2>
    </x-slot>

    <div class="relative">
        {{-- ============= Local Styles ============= --}}
        <style>
            .glass {
                background: rgba(255, 255, 255, .88);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(148, 163, 184, .35);
                border-radius: 1rem;
                box-shadow: 0 10px 20px rgba(0, 0, 0, .06);
                transition: border-color .25s ease, box-shadow .25s ease, transform .25s ease;
            }

            .glass:hover {
                border-color: rgba(148, 163, 184, .55);
                box-shadow: 0 16px 32px rgba(0, 0, 0, .08);
                transform: translateY(-2px);
            }

            .chip {
                display: inline-flex;
                align-items: center;
                gap: .5rem;
                padding: .5rem .9rem;
                font-weight: 700;
                font-size: .85rem;
                border-radius: 9999px;
                border: 1px solid #fecaca;
                color: #b91c1c;
                background: #fff;
                transition: background .2s ease, color .2s ease, border-color .2s ease;
            }

            .chip:hover {
                background: #fff1f2;
                border-color: #fca5a5;
            }

            .watermark {
                letter-spacing: -.02em;
                line-height: .9;
                user-select: none;
            }

            .blob {
                filter: blur(20px);
                opacity: .22;
            }

            @media (prefers-reduced-motion:no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(14px);
                    transition: opacity .6s ease, transform .6s ease
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none
                }

                .reveal {
                    opacity: 0;
                    transform: translateY(14px);
                }

                .reveal.in-view {
                    opacity: 1;
                    transform: none;
                    transition: opacity .7s ease, transform .7s ease;
                }

                .stagger>* {
                    opacity: 0;
                    transform: translateY(12px);
                }

                .loaded .stagger>* {
                    animation: staggerIn .55s ease forwards;
                }

                .loaded .stagger>*:nth-child(2) {
                    animation-delay: .06s
                }

                .loaded .stagger>*:nth-child(3) {
                    animation-delay: .12s
                }

                .loaded .stagger>*:nth-child(4) {
                    animation-delay: .18s
                }

                @keyframes staggerIn {
                    to {
                        opacity: 1;
                        transform: none
                    }
                }
            }
        </style>

        {{-- ============= HERO (kept, image replaced) ============= --}}
        <section class="relative h-[18rem] sm:h-[24rem] mt-16 overflow-hidden">
            <img src="https://i.tiesraides.lv/1200x0s/pictures/2025-06-06/852c_volejbols_latvija.jpg"
                alt="Latvijas volejbols" class="absolute inset-0 w-full h-full object-cover brightness-[.75]">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/45 to-black/10"></div>

            {{-- subtle blobs (kept) --}}
            <div class="pointer-events-none absolute inset-0">
                <div class="blob absolute -top-10 left-[10%] w-40 h-40 rounded-full bg-red-400/60"></div>
                <div class="blob absolute top-14 right-[6%] w-56 h-56 rounded-full bg-rose-500/60"></div>
                <div class="blob absolute -bottom-16 left-[38%] w-52 h-52 rounded-full bg-red-600/60"></div>
            </div>

            <div class="relative h-full flex flex-col items-center justify-center text-center px-6">
                <p class="text-red-200/95 text-[11px] font-bold uppercase tracking-[0.22em] fade-up">Par mums</p>
                <h1 class="mt-2 text-3xl sm:text-5xl font-extrabold text-white leading-tight fade-up">
                    VolleyLV
                </h1>
                <p class="mt-3 max-w-2xl text-sm sm:text-lg text-white/90 fade-up">
                    Turnīri, kalendārs un rezultāti vienuviet, lai spēlētāji, komandas un organizatori satiekas ātrāk.
                </p>


            </div>

            <div class="absolute inset-x-0 bottom-[-.22em] px-6 pointer-events-none">

            </div>
        </section>

        {{-- ============= BODY ============= --}}
        <div class="relative bg-gradient-to-b from-white via-red-50/30 to-white pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Story (text only) --}}
                <section id="story" class="mt-10 reveal">
                    <div class="glass p-6 sm:p-8">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="h-5 w-1.5 bg-red-600 rounded"></span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Mūsu stāsts</h2>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            VolleyLV radās ar vienkāršu mērķi, apvienot Latvijas volejbola entuziastus vienā vietā.
                            Mēs noņēmām lieko troksni: meklē turnīrus, piesakies komandai, seko līdzi progresam bez
                            jucekļa.
                        </p>
                        <p class="mt-3 text-gray-700 leading-relaxed">
                            Mūsu komanda tic, ka spēcīga kopiena sākas ar atklātību un vienkāršību. Tāpēc mēs
                            būvējam rīkus, kas ļauj koncentrēties uz spēli nevis birokrātiju.
                        </p>
                    </div>
                </section>



                {{-- Features (4 cards; removed “Statistika & rezultāti” and “Godīga spēle”) --}}
                <section id="features" class="mt-8 reveal">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="h-5 w-1.5 bg-red-600 rounded"></span>
                            <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900">Ko piedāvājam</h3>
                        </div>
                        <div class="hidden sm:flex gap-2">
                            <a href="{{ route('tournaments.calendar') }}" class="chip">Kalendārs</a>
                            <a href="{{ route('news.index') }}" class="chip">Ziņas</a>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 stagger">
                        <div class="glass p-5">
                            <div class="flex items-center gap-3">
                                <div class="rounded-xl bg-red-50 text-red-700 p-2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v3H2V6a2 2 0 0 1 2-2h1V3a1 1 0 1 1 2 0v1zM2 10h20v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10z" />
                                    </svg>
                                </div>
                                <h4 class="font-extrabold text-gray-900">Gudrs kalendārs</h4>
                            </div>
                            <p class="mt-2 text-sm text-gray-700">Tuvākie turnīri, vairāku dienu pasākumi, klikšķināmi
                                ieraksti.</p>
                        </div>

                        <div class="glass p-5">
                            <div class="flex items-center gap-3">
                                <div class="rounded-xl bg-red-50 text-red-700 p-2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M18 2a1 1 0 0 1 1 1v1h2a1 1 0 0 1 1 1v2a5 5 0 0 1-5 5h-1.1A5.002 5.002 0 0 1 13 16v2h3a1 1 0 1 1 0 2H8a1 1 0 1 1 0-2h3v-2a5.002 5.002 0 0 1-2.9-4H7a5 5 0 0 1-5-5V5a1 1 0 0 1 1-1h2V3a1 1 0 1 1 2 0v1h8V3a1 1 0 0 1 1-1zM4 7a3 3 0 0 0 3 3h1V5H4v2zm16-2h-4v5h1a3 3 0 0 0 3-3V5z" />
                                    </svg>
                                </div>
                                <h4 class="font-extrabold text-gray-900">Turnīru pārvaldība</h4>
                            </div>
                            <p class="mt-2 text-sm text-gray-700">Pieteikumi, komandas un norises statuss, pārskatāmi
                                un droši.</p>
                        </div>

                        <div class="glass p-5">
                            <div class="flex items-center gap-3">
                                <div class="rounded-xl bg-red-50 text-red-700 p-2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M7 7a4 4 0 1 1 8 0 4 4 0 0 1-8 0zm-5 13a7 7 0 0 1 14 0v1H2v-1zM17.5 7.5a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7zM22 21h-3a5 5 0 0 0-3.6-4.8 8.02 8.02 0 0 1 4.6-1.2A5 5 0 0 1 22 21z" />
                                    </svg>
                                </div>
                                <h4 class="font-extrabold text-gray-900">Komandas & pieteikumi</h4>
                            </div>
                            <p class="mt-2 text-sm text-gray-700">Viegla pieteikšanās, kapteiņi, komandu lielumi un
                                nosacījumi.</p>
                        </div>

                        <div class="glass p-5">
                            <div class="flex items-center gap-3">
                                <div class="rounded-xl bg-red-50 text-red-700 p-2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M4 5a2 2 0 0 0-2 2v10a3 3 0 0 0 3 3h15a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4zm1 2h14v11H5a1 1 0 0 1-1-1V7zm2 2h6v3H7V9zm0 4h6v3H7v-3z" />
                                    </svg>
                                </div>
                                <h4 class="font-extrabold text-gray-900">Ziņas & jaunumi</h4>
                            </div>
                            <p class="mt-2 text-sm text-gray-700">Aktualitātes no kopienas un turnīru organizatoriem.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- CTA --}}
                <section class="mt-10 reveal">
                    <div class="relative overflow-hidden rounded-2xl shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-red-600 to-red-500"></div>
                        <div
                            class="relative p-6 sm:p-8 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-extrabold">Pievienojies VolleyLV kopienai</h3>
                                <p class="text-white/90 mt-1">Atrast turnīru, pieteikties un sekot līdzi, tikai pāris
                                    klikšķi.</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('tournaments.calendar') }}"
                                    class="inline-flex items-center justify-center rounded-full bg-white text-red-700 font-semibold px-5 py-2 shadow hover:bg-red-50 transition">
                                    Skatīt kalendāru
                                </a>
                                <a href="{{ route('news.index') }}"
                                    class="inline-flex items-center justify-center rounded-full border border-white/70 text-white font-semibold px-5 py-2 hover:bg-white/10 transition">
                                    Lasīt ziņas
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    {{-- ============= Scripts (no libs) ============= --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });

        // reveal on scroll
        (function() {
            const els = Array.from(document.querySelectorAll('.reveal'));
            if (!('IntersectionObserver' in window) || !els.length) return;
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('in-view');
                        io.unobserve(e.target);
                    }
                });
            }, {
                rootMargin: '0px 0px -10% 0px',
                threshold: 0.08
            });
            els.forEach(el => io.observe(el));
        })();
    </script>
</x-app-layout>
