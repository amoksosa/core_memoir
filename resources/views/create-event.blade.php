<x-layouts.app title="Create Event - Core Memoir">
    <main class="px-[3vw] py-16">
        <div class="mx-auto max-w-[1200px]">
            <div class="grid gap-10 xl:grid-cols-[1fr_420px]">
                <div>
                    <p class="text-[18px] font-black uppercase tracking-[0.2em] text-[#704500]">
                        Event Access
                    </p>

                    <h1 class="mt-4 [font-family:Georgia,'Times_New_Roman',serif] text-[64px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[100px]">
                        Create Event
                        <br>
                        Design
                    </h1>

                    <p class="mt-6 max-w-[760px] text-[24px] leading-[1.35] text-[#9b7445]">
                        Choose your event style, photo border, font, and caption.
                        This will become the design guests see when they open your event camera.
                    </p>
                </div>

                <div class="rounded-[30px] bg-[#927a67] p-8 text-white">
                    <h2 class="[font-family:Georgia,'Times_New_Roman',serif] text-[46px] font-normal leading-[0.95]">
                        Core Memoir
                    </h2>

                    <p class="mt-5 text-[21px] leading-[1.4] text-white/85">
                        Every guest. Every perspective. One memory.
                    </p>

                    <a
                        href="/"
                        class="mt-8 inline-flex h-[58px] items-center justify-center rounded-full bg-white px-8 text-[18px] text-[#704500] hover:bg-[#f8f3ee]"
                    >
                        Back Home
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('events.store') }}" class="mt-16 space-y-8">
                @csrf

                <section class="rounded-[34px] bg-[#efe8df] p-8 md:p-10">
                    <div class="h-[2px] w-[70px] bg-[#9b7445]"></div>

                    <h2 class="mt-8 text-[36px] font-black tracking-[-0.03em] text-[#704500]">
                        Event Details
                    </h2>

                    @if ($errors->any())
                        <div class="mt-6 rounded-[24px] border border-red-300 bg-red-50 p-5 text-[18px] text-red-700">
                            <ul class="list-disc pl-6">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-8 grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="text-[18px] font-black text-[#704500]">
                                Event Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Example: John's Birthday"
                                class="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none placeholder:text-[#9b7445]/60 focus:border-[#704500]"
                                required
                            >
                        </div>

                        <div>
                            <label class="text-[18px] font-black text-[#704500]">
                                Event Date
                            </label>

                            <input
                                type="date"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                class="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none focus:border-[#704500]"
                            >
                        </div>

                        <div>
                            <label class="text-[18px] font-black text-[#704500]">
                                Photo Limit
                            </label>

                            <input
                                type="number"
                                name="photo_limit"
                                min="1"
                                max="500"
                                value="{{ old('photo_limit', 25) }}"
                                class="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none focus:border-[#704500]"
                                required
                            >
                        </div>

                        <div>
    <label class="text-[18px] font-black text-[#704500]">
        Guest Limit
    </label>

    <input
        type="number"
        name="guest_limit"
        min="1"
        max="1000"
        value="{{ old('guest_limit', 20) }}"
        placeholder="Example: 20"
        class="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none placeholder:text-[#9b7445]/60 focus:border-[#704500]"
        required
    >

    <p class="mt-2 text-[15px] text-[#9b7445]">
        Maximum number of guests who can access the QR event.
    </p>
</div>

                        <div>
                            <label class="text-[18px] font-black text-[#704500]">
                                Reveal Date and Time
                            </label>

                            <input
                                type="datetime-local"
                                name="reveal_at"
                                value="{{ old('reveal_at') }}"
                                class="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none focus:border-[#704500]"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[18px] font-black text-[#704500]">
                                Event Caption / Description
                            </label>

                            <textarea
                                name="caption"
                                rows="5"
                                placeholder="Capture memories from our special day."
                                class="mt-3 w-full resize-none rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] px-6 py-5 text-[18px] text-[#704500] outline-none placeholder:text-[#9b7445]/60 focus:border-[#704500]"
                            >{{ old('caption') }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="rounded-[34px] bg-[#efe8df] p-8 md:p-10">
                    <div class="h-[2px] w-[70px] bg-[#9b7445]"></div>

                    <h2 class="mt-8 text-[36px] font-black tracking-[-0.03em] text-[#704500]">
                        Event Style
                    </h2>

                    <p class="mt-3 text-[20px] leading-[1.4] text-[#9b7445]">
                        Choose the design using visual style dropdowns.
                    </p>

                    <input type="hidden" name="template" id="templateInput" value="{{ old('template', 'wedding') }}">
                    <input type="hidden" name="photo_frame" id="photoFrameInput" value="{{ old('photo_frame', 'polaroid') }}">
                    <input type="hidden" name="font_style" id="fontStyleInput" value="{{ old('font_style', 'modern') }}">

                    <div class="mt-8 grid gap-8">
                        <div class="relative style-dropdown" data-input="templateInput">
                            <label class="text-[18px] font-black text-[#704500]">
                                Event Template
                            </label>

                            <button
                                type="button"
                                class="style-toggle mt-3 w-full rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-5 text-left outline-none transition hover:border-[#704500]"
                            >
                                <div id="templateSelectedPreview" class="h-28 rounded-[22px] border border-rose-300 bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></div>
                            </button>

                            <div class="style-menu hidden mt-3 rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-4 shadow-2xl">
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                    <button type="button" data-value="wedding" data-preview="bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50 border-rose-300" class="style-option h-28 rounded-[22px] border border-rose-300 bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50"></button>
                                    <button type="button" data-value="birthday" data-preview="bg-gradient-to-br from-purple-700 via-pink-600 to-yellow-400 border-pink-300" class="style-option h-28 rounded-[22px] border border-pink-300 bg-gradient-to-br from-purple-700 via-pink-600 to-yellow-400"></button>
                                    <button type="button" data-value="graduation" data-preview="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 border-yellow-400" class="style-option h-28 rounded-[22px] border border-yellow-400 bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900"></button>
                                    <button type="button" data-value="christening" data-preview="bg-gradient-to-br from-sky-50 via-white to-stone-100 border-sky-200" class="style-option h-28 rounded-[22px] border border-sky-200 bg-gradient-to-br from-sky-50 via-white to-stone-100"></button>
                                    <button type="button" data-value="baby-shower" data-preview="bg-gradient-to-br from-pink-100 via-blue-50 to-yellow-50 border-pink-200" class="style-option h-28 rounded-[22px] border border-pink-200 bg-gradient-to-br from-pink-100 via-blue-50 to-yellow-50"></button>
                                    <button type="button" data-value="debut" data-preview="bg-gradient-to-br from-fuchsia-900 via-pink-700 to-rose-300 border-pink-300" class="style-option h-28 rounded-[22px] border border-pink-300 bg-gradient-to-br from-fuchsia-900 via-pink-700 to-rose-300"></button>
                                    <button type="button" data-value="party" data-preview="bg-gradient-to-br from-indigo-900 via-purple-700 to-pink-500 border-purple-300" class="style-option h-28 rounded-[22px] border border-purple-300 bg-gradient-to-br from-indigo-900 via-purple-700 to-pink-500"></button>
                                    <button type="button" data-value="concert" data-preview="bg-gradient-to-br from-black via-purple-950 to-red-700 border-red-400" class="style-option h-28 rounded-[22px] border border-red-400 bg-gradient-to-br from-black via-purple-950 to-red-700"></button>
                                    <button type="button" data-value="beach" data-preview="bg-gradient-to-br from-cyan-300 via-sky-200 to-amber-100 border-cyan-300" class="style-option h-28 rounded-[22px] border border-cyan-300 bg-gradient-to-br from-cyan-300 via-sky-200 to-amber-100"></button>
                                    <button type="button" data-value="garden" data-preview="bg-gradient-to-br from-green-900 via-emerald-600 to-lime-200 border-emerald-300" class="style-option h-28 rounded-[22px] border border-emerald-300 bg-gradient-to-br from-green-900 via-emerald-600 to-lime-200"></button>
                                    <button type="button" data-value="luxury" data-preview="bg-gradient-to-br from-black via-stone-900 to-yellow-700 border-yellow-400" class="style-option h-28 rounded-[22px] border border-yellow-400 bg-gradient-to-br from-black via-stone-900 to-yellow-700"></button>
                                    <button type="button" data-value="vintage" data-preview="bg-gradient-to-br from-yellow-950 via-stone-900 to-black border-amber-600" class="style-option h-28 rounded-[22px] border border-amber-600 bg-gradient-to-br from-yellow-950 via-stone-900 to-black"></button>
                                    <button type="button" data-value="minimal" data-preview="bg-white border-slate-300" class="style-option h-28 rounded-[22px] border border-slate-300 bg-white"></button>
                                    <button type="button" data-value="corporate" data-preview="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-700 border-blue-300" class="style-option h-28 rounded-[22px] border border-blue-300 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-700"></button>
                                    <button type="button" data-value="rustic" data-preview="bg-gradient-to-br from-stone-900 via-yellow-900 to-orange-300 border-orange-300" class="style-option h-28 rounded-[22px] border border-orange-300 bg-gradient-to-br from-stone-900 via-yellow-900 to-orange-300"></button>
                                    <button type="button" data-value="travel" data-preview="bg-gradient-to-br from-blue-800 via-cyan-500 to-orange-200 border-cyan-300" class="style-option h-28 rounded-[22px] border border-cyan-300 bg-gradient-to-br from-blue-800 via-cyan-500 to-orange-200"></button>
                                    <button type="button" data-value="family" data-preview="bg-gradient-to-br from-orange-100 via-amber-50 to-rose-100 border-orange-200" class="style-option h-28 rounded-[22px] border border-orange-200 bg-gradient-to-br from-orange-100 via-amber-50 to-rose-100"></button>
                                    <button type="button" data-value="night" data-preview="bg-gradient-to-br from-black via-indigo-950 to-fuchsia-700 border-fuchsia-400" class="style-option h-28 rounded-[22px] border border-fuchsia-400 bg-gradient-to-br from-black via-indigo-950 to-fuchsia-700"></button>
                                    <button type="button" data-value="flowers" data-preview="bg-gradient-to-br from-pink-100 via-rose-50 to-green-100 border-pink-200" class="style-option h-28 rounded-[22px] border border-pink-200 bg-gradient-to-br from-pink-100 via-rose-50 to-green-100"></button>
                                    <button type="button" data-value="gold" data-preview="bg-gradient-to-br from-yellow-100 via-yellow-400 to-yellow-900 border-yellow-500" class="style-option h-28 rounded-[22px] border border-yellow-500 bg-gradient-to-br from-yellow-100 via-yellow-400 to-yellow-900"></button>
                                </div>
                            </div>
                        </div>

                        <div class="relative style-dropdown" data-input="photoFrameInput">
                            <label class="text-[18px] font-black text-[#704500]">
                                Photo Border
                            </label>

                            <button
                                type="button"
                                class="style-toggle mt-3 w-full rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-5 text-left outline-none transition hover:border-[#704500]"
                            >
                                <div id="photoFrameSelectedPreview" class="flex h-[160px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                    <div class="rounded-md bg-white p-3 pb-10 shadow-2xl rotate-[-1deg]">
                                        <div class="h-20 w-28 rounded-sm bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                    </div>
                                </div>
                            </button>

                            <div class="style-menu hidden mt-3 rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-4 shadow-2xl">
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                    <button type="button" data-value="polaroid" class="frame-option flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                        <div class="rounded-md bg-white p-3 pb-10 shadow-2xl rotate-[-1deg]">
                                            <div class="h-16 w-24 rounded-sm bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                        </div>
                                    </button>

                                    <button type="button" data-value="clean" class="frame-option flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                        <div class="rounded-2xl border border-white/60 bg-white/30 p-1">
                                            <div class="h-20 w-28 rounded-xl bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                        </div>
                                    </button>

                                    <button type="button" data-value="film" class="frame-option flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                        <div class="rounded-xl border-4 border-black bg-black p-2 shadow-2xl">
                                            <div class="h-20 w-28 rounded-md bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                        </div>
                                    </button>

                                    <button type="button" data-value="gold" class="frame-option flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                        <div class="rounded-2xl border-4 border-yellow-400 bg-yellow-100 p-2 shadow-2xl">
                                            <div class="h-20 w-28 rounded-xl bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                        </div>
                                    </button>

                                    <button type="button" data-value="soft" class="frame-option flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                        <div class="rounded-[2rem] border border-rose-200 bg-white/70 p-2 shadow-xl">
                                            <div class="h-20 w-28 rounded-[1.5rem] bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                        </div>
                                    </button>

                                    <button type="button" data-value="neon" class="frame-option flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                        <div class="rounded-2xl border-2 border-fuchsia-400 bg-black p-2 shadow-[0_0_28px_rgba(217,70,239,0.55)]">
                                            <div class="h-20 w-28 rounded-xl bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                        </div>
                                    </button>

                                    <button type="button" data-value="journal" class="frame-option flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
                                        <div class="rounded-xl border border-stone-300 bg-[#fff8e8] p-3 shadow-xl rotate-[1deg]">
                                            <div class="h-20 w-28 rounded-lg bg-gradient-to-br from-slate-300 to-slate-500"></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="relative style-dropdown" data-input="fontStyleInput">
                            <label class="text-[18px] font-black text-[#704500]">
                                Font Style
                            </label>

                            <button
                                type="button"
                                class="style-toggle mt-3 w-full rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-5 text-left outline-none transition hover:border-[#704500]"
                            >
                                <div id="fontSelectedPreview" class="rounded-[22px] bg-[#e8dbcf] px-6 py-5">
                                    <p class="text-[54px] text-[#704500] font-sans">Aa</p>
                                </div>
                            </button>

                            <div class="style-menu hidden mt-3 rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-4 shadow-2xl">
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
                                    <button type="button" data-value="modern" data-font="font-sans" class="font-option rounded-[22px] bg-[#e8dbcf] px-6 py-5">
                                        <p class="text-[46px] text-[#704500] font-sans">Aa</p>
                                    </button>

                                    <button type="button" data-value="elegant" data-font="font-serif" class="font-option rounded-[22px] bg-[#e8dbcf] px-6 py-5">
                                        <p class="text-[46px] text-[#704500] font-serif">Aa</p>
                                    </button>

                                    <button type="button" data-value="bold" data-font="font-black tracking-tight" class="font-option rounded-[22px] bg-[#e8dbcf] px-6 py-5">
                                        <p class="text-[46px] text-[#704500] font-black tracking-tight">Aa</p>
                                    </button>

                                    <button type="button" data-value="classic" data-font="font-serif tracking-wide" class="font-option rounded-[22px] bg-[#e8dbcf] px-6 py-5">
                                        <p class="text-[46px] text-[#704500] font-serif tracking-wide">Aa</p>
                                    </button>

                                    <button type="button" data-value="handwritten" data-font="font-serif italic" class="font-option rounded-[22px] bg-[#e8dbcf] px-6 py-5">
                                        <p class="text-[46px] text-[#704500] font-serif italic">Aa</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <button
                    type="submit"
                    class="h-[72px] w-full rounded-full bg-[#704500] px-8 text-[22px] font-normal text-white transition hover:bg-[#583600]"
                >
                    Create Event
                </button>
            </form>
        </div>
    </main>

    <script>
        document.querySelectorAll('.style-toggle').forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const dropdown = toggle.closest('.style-dropdown');
                const menu = dropdown.querySelector('.style-menu');

                document.querySelectorAll('.style-menu').forEach((item) => {
                    if (item !== menu) item.classList.add('hidden');
                });

                menu.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('.style-option').forEach((option) => {
            option.addEventListener('click', () => {
                const dropdown = option.closest('.style-dropdown');
                const input = document.getElementById(dropdown.dataset.input);
                const preview = document.getElementById('templateSelectedPreview');

                input.value = option.dataset.value;
                preview.className = 'h-28 rounded-[22px] border ' + option.dataset.preview;

                dropdown.querySelector('.style-menu').classList.add('hidden');
            });
        });

        document.querySelectorAll('.frame-option').forEach((option) => {
            option.addEventListener('click', () => {
                const dropdown = option.closest('.style-dropdown');
                const input = document.getElementById(dropdown.dataset.input);
                const preview = document.getElementById('photoFrameSelectedPreview');

                input.value = option.dataset.value;
                preview.innerHTML = option.innerHTML;

                dropdown.querySelector('.style-menu').classList.add('hidden');
            });
        });

        document.querySelectorAll('.font-option').forEach((option) => {
            option.addEventListener('click', () => {
                const dropdown = option.closest('.style-dropdown');
                const input = document.getElementById(dropdown.dataset.input);
                const preview = document.getElementById('fontSelectedPreview');

                input.value = option.dataset.value;
                preview.innerHTML = `<p class="text-[54px] text-[#704500] ${option.dataset.font}">Aa</p>`;

                dropdown.querySelector('.style-menu').classList.add('hidden');
            });
        });

        document.addEventListener('click', (event) => {
            if (!event.target.closest('.style-dropdown')) {
                document.querySelectorAll('.style-menu').forEach((menu) => {
                    menu.classList.add('hidden');
                });
            }
        });
    </script>
</x-layouts.app>