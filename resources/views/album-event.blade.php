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
    <style>
        .cm-album-wrap {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .cm-photo-grid {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 8px !important;
            width: 100%;
        }

        .cm-photo-item {
            min-width: 0;
            width: 100%;
        }

        .cm-photo-frame {
            width: 100%;
            overflow: hidden;
        }

        .cm-photo-img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            display: block;
            border-radius: 6px;
        }

        .cm-photo-name {
            margin-top: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: center;
            font-size: 9px;
            font-weight: 800;
            line-height: 1.1;
        }

        @media (min-width: 768px) {
            .cm-photo-grid {
                gap: 24px !important;
            }

            .cm-photo-img {
                border-radius: 14px;
            }

            .cm-photo-name {
                margin-top: 12px;
                font-size: 15px;
            }
        }
    </style>

    <main class="min-h-screen {{ $pageClass }} px-3 py-6 md:px-[4vw] md:py-16">
        <div class="cm-album-wrap">
            <section class="rounded-[26px] bg-white/25 p-5 shadow-xl backdrop-blur md:rounded-[34px] md:p-10">
                <p class="text-[11px] font-black uppercase tracking-[0.22em] opacity-70 md:text-[14px] md:tracking-[0.28em]">
                    Core Memoir Album
                </p>

                <h1 class="mt-4 [font-family:Georgia,'Times_New_Roman',serif] text-[38px] font-normal leading-[0.95] md:text-[86px] {{ $fontClass }}">
                    {{ $event->name }}
                </h1>

                <p class="mt-4 text-[16px] font-black opacity-80 md:text-[20px]">
                    {{ $photos->count() }} photos captured
                </p>

                <a
                    href="{{ route('events.guest', $event->code) }}"
                    class="mt-6 inline-flex h-[48px] items-center justify-center rounded-full bg-[#704500] px-6 text-[14px] font-black text-white hover:bg-[#583600] md:mt-8 md:h-[58px] md:px-8 md:text-[18px]"
                >
                    Back to Camera
                </a>
            </section>

            <section class="mt-5 rounded-[26px] bg-white/25 p-3 shadow-xl backdrop-blur md:mt-8 md:rounded-[34px] md:p-8">
                @if ($photos->count() === 0)
                    <p class="p-4 text-[16px] font-black opacity-80 md:text-[20px]">
                        No photos uploaded yet.
                    </p>
                @else
                    <div class="cm-photo-grid">
                        @foreach ($photos as $photo)
                            <div class="cm-photo-item">
                                @if ($frame === 'polaroid')
                                    <div class="cm-photo-frame rotate-[-1deg] rounded-sm bg-white p-1 pb-4 shadow-lg md:rounded-md md:p-3 md:pb-10 md:shadow-2xl">
                                        <img
                                            src="{{ $photo->image_url }}"
                                            alt="Event upload"
                                            class="cm-photo-img"
                                        >

                                        <p class="cm-photo-name text-slate-700">
                                            {{ $photo->guest_name ?: 'Guest' }}
                                        </p>
                                    </div>
                                @elseif ($frame === 'film')
                                    <div class="cm-photo-frame rounded-md border-2 border-black bg-black p-1 shadow-lg md:rounded-xl md:border-4 md:p-2 md:shadow-2xl">
                                        <img
                                            src="{{ $photo->image_url }}"
                                            alt="Event upload"
                                            class="cm-photo-img"
                                        >
                                    </div>

                                    <p class="cm-photo-name opacity-80">
                                        {{ $photo->guest_name ?: 'Guest' }}
                                    </p>
                                @elseif ($frame === 'gold')
                                    <div class="cm-photo-frame rounded-md border-2 border-yellow-400 bg-yellow-100 p-1 shadow-lg md:rounded-2xl md:border-4 md:p-2 md:shadow-2xl">
                                        <img
                                            src="{{ $photo->image_url }}"
                                            alt="Event upload"
                                            class="cm-photo-img"
                                        >
                                    </div>

                                    <p class="cm-photo-name opacity-80">
                                        {{ $photo->guest_name ?: 'Guest' }}
                                    </p>
                                @elseif ($frame === 'soft')
                                    <div class="cm-photo-frame rounded-lg border border-rose-200 bg-white/70 p-1 shadow-lg md:rounded-[2rem] md:p-2 md:shadow-xl">
                                        <img
                                            src="{{ $photo->image_url }}"
                                            alt="Event upload"
                                            class="cm-photo-img"
                                        >
                                    </div>

                                    <p class="cm-photo-name opacity-80">
                                        {{ $photo->guest_name ?: 'Guest' }}
                                    </p>
                                @elseif ($frame === 'neon')
                                    <div class="cm-photo-frame rounded-md border border-fuchsia-400 bg-black p-1 shadow-[0_0_10px_rgba(217,70,239,0.45)] md:rounded-2xl md:border-2 md:p-2 md:shadow-[0_0_28px_rgba(217,70,239,0.55)]">
                                        <img
                                            src="{{ $photo->image_url }}"
                                            alt="Event upload"
                                            class="cm-photo-img"
                                        >
                                    </div>

                                    <p class="cm-photo-name opacity-80">
                                        {{ $photo->guest_name ?: 'Guest' }}
                                    </p>
                                @elseif ($frame === 'journal')
                                    <div class="cm-photo-frame rotate-[1deg] rounded-md border border-stone-300 bg-[#fff8e8] p-1 shadow-lg md:rounded-xl md:p-3 md:shadow-xl">
                                        <img
                                            src="{{ $photo->image_url }}"
                                            alt="Event upload"
                                            class="cm-photo-img"
                                        >
                                    </div>

                                    <p class="cm-photo-name opacity-80">
                                        {{ $photo->guest_name ?: 'Guest' }}
                                    </p>
                                @else
                                    <div class="cm-photo-frame rounded-md border border-white/50 bg-white/20 p-1 shadow-lg md:rounded-2xl md:shadow-xl">
                                        <img
                                            src="{{ $photo->image_url }}"
                                            alt="Event upload"
                                            class="cm-photo-img"
                                        >
                                    </div>

                                    <p class="cm-photo-name opacity-80">
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