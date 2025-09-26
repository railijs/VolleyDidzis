<!-- Update Password (VolleyLV style) -->
<form method="post" action="{{ route('password.update') }}" class="space-y-6 form-skin">
    @csrf
    @method('put')

    <!-- Current Password -->
    <div>
        <label for="current_password">Pašreizējā parole</label>
        <div class="relative mt-2">
            <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200" />
            <button type="button" class="abs-toggle" onclick="togglePw('current_password', this)">Rādīt</button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <!-- New Password -->
    <div>
        <label for="password">Jaunā parole</label>
        <div class="relative mt-2">
            <input id="password" name="password" type="password" autocomplete="new-password"
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200"
                oninput="pwStrength(this.value)" />
            <button type="button" class="abs-toggle" onclick="togglePw('password', this)">Rādīt</button>
        </div>

        <!-- Strength meter -->
        <div class="mt-2">
            <div class="h-2 w-full bg-gray-200/80 rounded-full overflow-hidden">
                <div id="pw-bar" class="h-2 w-0 bg-red-400 transition-all"></div>
            </div>
            <p id="pw-hint" class="mt-1 text-xs text-gray-500">
                Ieteikums: ≥12 simboli, lielie/mazie burti, cipari un simboli.
            </p>
        </div>

        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation">Apstiprināt paroli</label>
        <div class="relative mt-2">
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200" />
            <button type="button" class="abs-toggle" onclick="togglePw('password_confirmation', this)">Rādīt</button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- Actions -->
    <div class="flex justify-end">
        <button type="submit" class="btn-red rounded-full px-5 py-2 font-semibold shadow">
            Atjaunot paroli
        </button>
    </div>
</form>

{{-- Tiny helpers (no dependencies) --}}
<script>
    // Positioning class for small toggle button
    (function ensureToggleStyle() {
        const css = `
        .abs-toggle{
            position:absolute; right:.5rem; top:50%; transform:translateY(-50%);
            font-size:.8rem; color:#b91c1c; font-weight:700; padding:.15rem .5rem;
            border-radius:9999px; background:#fee2e2; transition:.2s;
        }
        .abs-toggle:hover{ background:#fecaca; }
        `;
        const s = document.createElement('style');
        s.textContent = css;
        document.head.appendChild(s);
    })();

    function togglePw(id, btn) {
        const el = document.getElementById(id);
        if (!el) return;
        el.type = (el.type === 'password') ? 'text' : 'password';
        btn.textContent = (el.type === 'password') ? 'Rādīt' : 'Slēpt';
    }

    function pwStrength(v) {
        const bar = document.getElementById('pw-bar');
        const hint = document.getElementById('pw-hint');
        if (!bar || !hint) return;

        let score = 0;
        if (v.length >= 12) score++;
        if (/[a-z]/.test(v) && /[A-Z]/.test(v)) score++;
        if (/\d/.test(v)) score++;
        if (/[^\w\s]/.test(v)) score++; // symbols

        const widths = ['0%', '25%', '50%', '75%', '100%'];
        const colors = ['#fca5a5', '#f87171', '#fb923c', '#fde047', '#22c55e']; // red→amber→green
        bar.style.width = widths[score];
        bar.style.backgroundColor = colors[score];

        const tips = [
            'Parole ir tukša.',
            'Vāja parole. Pievieno garumu.',
            'Vidēja parole. Pievieno lielos/mazos burtus.',
            'Gandrīz gatavs. Pievieno ciparus/simbolus.',
            'Spēcīga parole!'
        ];
        hint.textContent = tips[score];
    }
</script>
