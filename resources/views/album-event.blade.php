@php
    $frame = $event->photo_frame ?? 'polaroid';

    $template = $event->template ?? 'wedding';

    $pageClass = match ($template) {
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
        'minimal' => 'bg-slate-100 text-slate-950',
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

<x-layouts.app title="{{ $event->name }} Album - Core Memoir" :guest="true">
    <main class="min-h-screen {{ $pageClass }} px-[4vw] py-10 md:py-16">
        <div class="mx-auto max-w-[1200px]">
            <section class="rounded-[34px] bg-white/25 p-8 shadow-xl backdrop-blur md:p-10">
                <p class="text-[14px] font-black uppercase tracking-[0.28em] opacity-70">
                    Core Memoir Album
                </p>

                <h1 class="mt-4 [font-family:Georgia,'Times_New_Roman',serif] text-[54px] font-normal leading-[0.95] md:text-[86px] {{ $fontClass }}">
                    {{ $event->name }}
                </h1>

                <p class="mt-4 text-[20px] font-black opacity-80">
                    {{ $photos->count() }} photos captured
                </p>

                <a
                    href="{{ route('events.guest', $event->code) }}"
                    class="mt-8 inline-flex h-[58px] items-center justify-center rounded-full bg-[#704500] px-8 text-[18px] font-black text-white hover:bg-[#583600]"
                >
                    Back to Camera
                </a>
            </section>

            <section class="mt-8 rounded-[34px] bg-white/25 p-8 shadow-xl backdrop-blur md:p-10">
                @if ($photos->count() === 0)
                    <p class="text-[20px] font-black opacity-80">
                        No photos uploaded yet.
                    </p>
                @else
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($photos as $photo)
                            <div>
                                <div class="
                                    @if ($frame === 'polaroid')
                                        rounded-md bg-white p-3 pb-10 shadow-2xl rotate-[-1deg]
                                    @elseif ($frame === 'film')
                                        rounded-xl border-4 border-black bg-black p-2 shadow-2xl
                                    @elseif ($frame === 'gold')
                                        rounded-2xl border-4 border-yellow-400 bg-yellow-100 p-2 shadow-2xl
                                    @elseif ($frame === 'soft')
                                        rounded-[2rem] border border-rose-200 bg-white/70 p-2 shadow-xl
                                    @elseif ($frame === 'neon')
                                        rounded-2xl border-2 border-fuchsia-400 bg-black p-2 shadow-[0_0_28px_rgba(217,70,239,0.55)]
                                    @elseif ($frame === 'journal')
                                        rounded-xl border border-stone-300 bg-[#fff8e8] p-3 shadow-xl rotate-[1deg]
                                    @else
                                        rounded-2xl border border-white/50 bg-white/20 p-1 shadow-xl
                                    @endif
                                ">
                                    <img
                                        src="{{ $photo->image_url }}"
                                        alt="Event upload"
                                        class="aspect-square w-full object-cover rounded-xl"
                                    >

                                    @if ($frame === 'polaroid')
                                        <p class="mt-3 truncate text-center text-sm font-bold text-slate-700">
                                            {{ $photo->guest_name ?: 'Guest' }}
                                        </p>
                                    @endif
                                </div>

                                @if ($frame !== 'polaroid')
                                    <p class="mt-3 truncate text-sm font-bold opacity-80">
                                        {{ $photo->guest_name ?: 'Guest' }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </main>
</x-layouts.app>