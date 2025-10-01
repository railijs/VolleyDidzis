<x-app-layout>
    {{-- HERO --}}
    <section class="relative mt-20 mb-8 overflow-hidden">
        <div class="absolute inset-0">
            <div class="h-40 sm:h-48 bg-gradient-to-r from-red-700 via-red-600 to-red-500"></div>
            <div class="absolute -top-10 -right-12 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 w-56 h-56 rounded-full bg-white/10 blur-2xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-40 sm:h-48 flex items-end">
            <div class="pb-5">
                <p class="text-red-100/90 text-[11px] font-bold uppercase tracking-[0.22em]">Turnīri</p>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">Izveidot turnīru</h1>
                <p class="text-red-100/95 text-sm mt-1">Aizpildi laukus zemāk. * lauki ir obligāti.</p>
            </div>
        </div>
    </section>

    {{-- PAGE BODY --}}
    <div class="relative bg-gradient-to-b from-white via-red-50/30 to-white pb-16">
        <style>
            .glass {
                background: rgba(255, 255, 255, .88);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(148, 163, 184, .35);
                border-radius: 1rem;
                box-shadow: 0 10px 20px rgba(0, 0, 0, .06);
                transition: border-color .25s, box-shadow .25s, transform .25s
            }

            .glass:hover {
                border-color: rgba(148, 163, 184, .55);
                box-shadow: 0 16px 32px rgba(0, 0, 0, .08);
                transform: translateY(-2px)
            }

            .form-skin label {
                color: #111827;
                font-weight: 600;
                font-size: .9rem
            }

            .form-skin input,
            .form-skin select,
            .form-skin textarea {
                width: 100%;
                border: 1px solid #e5e7eb;
                border-radius: .75rem;
                padding: .65rem .9rem;
                background: #fff;
                color: #111827;
                outline: none;
                box-shadow: 0 1px 2px rgba(0, 0, 0, .02) inset;
                transition: border-color .18s, box-shadow .18s
            }

            .form-skin input:focus,
            .form-skin select:focus,
            .form-skin textarea:focus {
                border-color: #fca5a5;
                box-shadow: 0 0 0 3px rgba(252, 165, 165, .35)
            }

            .hint {
                font-size: .8rem;
                color: #6b7280
            }

            .danger {
                color: #b91c1c
            }
        </style>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- TOP-LEVEL ERRORS (SERVER) --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    <div class="font-semibold mb-1">Lūdzu pārskati ievadīto informāciju:</div>
                    <ul class="list-disc ms-5 text-sm">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Alpine state BEFORE form --}}
            <script>
                window.tournamentForm = function() {
                    return {
                        name: @json(old('name', '')),
                        gender: @json(old('gender_type', '')),
                        teamSize: @json(old('team_size', 6)),
                        maxTeams: @json(old('max_teams', 8)),
                        minBoys: @json(old('min_boys', 0)),
                        minGirls: @json(old('min_girls', 0)),
                        desc: @json(old('description', '')),
                        descLimit: 2000,
                        submitting: false,

                        get mixSum() {
                            return (Number(this.minBoys) || 0) + (Number(this.minGirls) || 0)
                        },
                        get mixOverflow() {
                            return this.gender === 'mix' && this.mixSum > (Number(this.teamSize) || 0)
                        },
                        get descCount() {
                            return (this.desc || '').length
                        },

                        clampMix(which) {
                            const size = Number(this.teamSize) || 0;
                            if (which === 'boys') this.minBoys = Math.max(0, Math.min(Number(this.minBoys) || 0, size));
                            if (which === 'girls') this.minGirls = Math.max(0, Math.min(Number(this.minGirls) || 0, size));
                        },
                        onTeamSizeChanged() {
                            this.clampMix('boys');
                            this.clampMix('girls');
                        },

                        allowSubmit() {
                            // client-side quick guard (do not block server validation unless truly impossible)
                            if (this.gender === 'mix' && this.mixOverflow) return false;
                            return true;
                        },
                        handleSubmit(ev) {
                            // NEVER prevent default if allowed; just toggle state
                            if (!this.allowSubmit()) {
                                ev.preventDefault();
                                return;
                            }
                            this.submitting = true;
                            // As a safety, force-submit in case anything swallows the click
                            ev.target.submit();
                        }
                    }
                }
            </script>

            {{-- FORM CARD --}}
            <form id="createTournamentForm" method="POST" action="{{ route('tournaments.store') }}"
                class="glass p-6 sm:p-8 form-skin" x-data="tournamentForm()" x-on:submit="handleSubmit($event)"
                novalidate>
                @csrf

                {{-- NOSAUKUMS --}}
                <div class="mb-5">
                    <label for="name">Nosaukums *</label>
                    <input id="name" name="name" type="text" x-model="name"
                        placeholder="Piem., Rīgas pludmales volejbola kauss" class="mt-2" maxlength="255"
                        autocomplete="off">
                    @error('name')
                        <p class="mt-1 text-sm danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- APRAKSTS --}}
                <div class="mb-5">
                    <label for="description">Apraksts</label>
                    <textarea id="description" name="description" rows="4" x-model="desc"
                        placeholder="Īss turnīra apraksts, noteikumi, reģistrācijas norise u.c." maxlength="2000" class="mt-2"></textarea>
                    <div class="flex items-center justify-between mt-1">
                        <span class="hint">Maks. 2000 rakstzīmes</span>
                        <span class="hint" x-text="descCount + ' / ' + descLimit"></span>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DATUMI --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="start_date">Sākuma datums *</label>
                        <input id="start_date" name="start_date" type="date" min="{{ date('Y-m-d') }}"
                            value="{{ old('start_date') }}" class="mt-2">
                        @error('start_date')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date">Beigu datums *</label>
                        <input id="end_date" name="end_date" type="date" min="{{ date('Y-m-d') }}"
                            value="{{ old('end_date') }}" class="mt-2">
                        @error('end_date')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- VIETA / MAX KOMANDAS --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="location">Vieta *</label>
                        <input id="location" name="location" type="text" value="{{ old('location') }}"
                            class="mt-2" placeholder="Piem., Rīga, Mežaparks">
                        <p class="hint mt-1">Jābūt reālai vietai (ne tikai cipari).</p>
                        @error('location')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="max_teams">Maks. komandu skaits *</label>
                        <input id="max_teams" name="max_teams" type="number" min="2" max="100"
                            x-model.number="maxTeams" value="{{ old('max_teams', 8) }}" class="mt-2">
                        @error('max_teams')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- SPĒLĒTĀJI / DZIMUMS --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="team_size">Spēlētāji komandā *</label>
                        <input id="team_size" name="team_size" type="number" min="4" max="12"
                            x-model.number="teamSize" @input="onTeamSizeChanged()" class="mt-2"
                            value="{{ old('team_size', 6) }}">
                        <p class="hint mt-1">Tipiski 4–6 laukuma spēlētāji.</p>
                        @error('team_size')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender_type">Dzimuma tips *</label>
                        <select id="gender_type" name="gender_type" x-model="gender" class="mt-2 pr-10">
                            <option value="">— izvēlies —</option>
                            <option value="men" {{ old('gender_type') === 'men' ? 'selected' : '' }}>Vīrieši
                            </option>
                            <option value="women" {{ old('gender_type') === 'women' ? 'selected' : '' }}>Sievietes
                            </option>
                            <option value="mix" {{ old('gender_type') === 'mix' ? 'selected' : '' }}>Mix</option>
                        </select>
                        @error('gender_type')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- MIX PARAMETRI --}}
                <div x-show="gender==='mix'" x-transition class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="min_boys">Min. puiši laukumā</label>
                        <input id="min_boys" name="min_boys" type="number" min="1" :max="teamSize"
                            x-model.number="minBoys" @input="clampMix('boys')" class="mt-2"
                            value="{{ old('min_boys', 1) }}">
                        @error('min_boys')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="min_girls">Min. meitenes laukumā</label>
                        <input id="min_girls" name="min_girls" type="number" min="1" :max="teamSize"
                            x-model.number="minGirls" @input="clampMix('girls')" class="mt-2"
                            value="{{ old('min_girls', 1) }}">
                        @error('min_girls')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-2" x-show="mixOverflow">
                        <p class="mt-1 text-sm danger">
                            Min. puiši + min. meitenes nedrīkst pārsniegt kopējo spēlētāju skaitu.
                        </p>
                    </div>
                </div>

                {{-- VECUMA IEROBEŽOJUMI --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="min_age">Minimālais vecums</label>
                        <input id="min_age" name="min_age" type="number" min="0" max="100"
                            value="{{ old('min_age') }}" class="mt-2">
                        @error('min_age')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="max_age">Maksimālais vecums</label>
                        <input id="max_age" name="max_age" type="number" min="0" max="100"
                            value="{{ old('max_age') }}" class="mt-2">
                        @error('max_age')
                            <p class="mt-1 text-sm danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- IETEIKUMI / NOTEIKUMI --}}
                <div class="mb-6">
                    <label for="recommendations">Ieteikumi / noteikumi (neobligāti)</label>
                    <textarea id="recommendations" name="recommendations" rows="3" class="mt-2"
                        placeholder="Piem., apģērba noteikumi, punktu skaitīšana, sākuma laiks u.c.">{{ old('recommendations') }}</textarea>
                    @error('recommendations')
                        <p class="mt-1 text-sm danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-2 font-semibold transition">
                        Atcelt
                    </a>
                    <button type="submit" :disabled="submitting"
                        class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold px-6 py-2.5 shadow transition">
                        <span x-show="!submitting">Izveidot turnīru</span>
                        <span x-show="submitting" class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke="currentColor"
                                    stroke-width="4" />
                            </svg>
                            Tiek nosūtīts…
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
