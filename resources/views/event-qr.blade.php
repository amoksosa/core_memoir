@php
    $template = $event->template ?? 'wedding';

    $templateClass = match ($template) {
        'birthday' => 'bg-gradient-to-br from-purple-700 via-pink-600 to-yellow-400 text-white',
        'graduation' => 'bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white',
        'christening' => 'bg-gradient-to-br from-sky-50 via-white to-stone-100 text-slate-900',
        'baby-shower' => 'bg-gradient-to-br from-pink-100 via-blue-50 to-yellow-50 text-slate-900',
        'debut' => 'bg-gradient-to-br from-fuchsia-900 via-pink-700 to-rose-300 text-white',
        'party' => 'bg-gradient-to-br from-indigo-900 via-purple-700 to-pink-500 text-white',
        'concert' => 'bg-gradient-to-br from-black via-purple-950 to-red-700 text-white',
        'beach' => 'bg-gradient-to-br from-cyan-300 via-sky-200 to-amber-100 text-slate-900',
        'garden' => 'bg-gradient-to-br from-green-900 via-emerald-600 to-lime-200 text-white',
        'luxury' => 'bg-gradient-to-br from-black via-stone-900 to-yellow-700 text-yellow-50',
        'vintage' => 'bg-gradient-to-br from-yellow-950 via-stone-900 to-black text-amber-50',
        'minimal' => 'bg-white text-slate-950',
        'corporate' => 'bg-gradient-to-br from-slate-900 via-blue-900 to-slate-700 text-white',
        'rustic' => 'bg-gradient-to-br from-stone-900 via-yellow-900 to-orange-300 text-white',
        'travel' => 'bg-gradient-to-br from-blue-800 via-cyan-500 to-orange-200 text-white',
        'family' => 'bg-gradient-to-br from-orange-100 via-amber-50 to-rose-100 text-stone-900',
        'night' => 'bg-gradient-to-br from-black via-indigo-950 to-fuchsia-700 text-white',
        'flowers' => 'bg-gradient-to-br from-pink-100 via-rose-50 to-green-100 text-rose-950',
        'gold' => 'bg-gradient-to-br from-yellow-100 via-yellow-400 to-yellow-900 text-stone-950',
        default => 'bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50 text-rose-950',
    };

    $fontClass = match ($event->font_style ?? 'modern') {
        'elegant' => 'font-serif',
        'bold' => 'font-black tracking-tight',
        'classic' => 'font-serif tracking-wide',
        'handwritten' => 'font-serif italic',
        default => 'font-sans',
    };
@endphp

<x-layouts.app title="{{ $event->name }} QR - Core Memoir">
    <main class="min-h-screen bg-[#f8f3ee] px-[4vw] py-10 md:py-16">
        <div class="mx-auto flex max-w-[760px] justify-center">
            <div class="w-full rounded-[38px] bg-[#927a67] p-3 shadow-2xl md:p-4">
                <div class="overflow-hidden rounded-[34px] {{ $templateClass }} p-6 shadow-xl md:p-7">
                    <p class="text-[13px] font-black uppercase tracking-[0.28em] opacity-70">
                        Core Memoir
                    </p>

                    <h1 class="mt-4 [font-family:Georgia,'Times_New_Roman',serif] text-[44px] leading-[0.95] md:text-[64px] {{ $fontClass }}">
                        {{ $event->name }}
                    </h1>

                    <p class="mt-4 text-[16px] font-black opacity-90 md:text-[18px]">
                        {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('F d, Y') : 'Event date not set' }}
                    </p>

                    @if ($event->caption)
                        <p class="mt-5 text-[16px] leading-[1.45] opacity-90 md:text-[18px]">
                            {{ $event->caption }}
                        </p>
                    @endif

                    <div class="mt-8 rounded-[30px] bg-white p-6 md:p-8">
                        <div class="flex justify-center">
                            {!! QrCode::format('svg')
                                ->size(300)
                                ->margin(2)
                                ->generate($guestLink) !!}
                        </div>
                    </div>

                    <p class="mt-7 text-center text-[22px] font-black">
                        Scan to open camera
                    </p>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>