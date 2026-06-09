@php
    $uploadedCount = $guestPhotoCount ?? 0;
    $limit = $event->photo_limit ?? 0;
    $remaining = max($limit - $uploadedCount, 0);

    $revealAt = $event->reveal_at ? \Carbon\Carbon::parse($event->reveal_at) : null;
    $albumUnlocked = !$revealAt || now()->greaterThanOrEqualTo($revealAt);
@endphp

<x-layouts.app title="{{ $event->name }} - Core Memoir" :guest="true">
    <main class="min-h-screen px-[4vw] py-10 md:py-16">
        <div class="mx-auto max-w-[760px]">
            <section class="rounded-[34px] bg-[#927a67] p-8 text-white shadow-xl md:p-10">
                <p class="text-[14px] font-black uppercase tracking-[0.28em] text-white/80">
                    Event Camera
                </p>

                <h1 class="mt-4 [font-family:Georgia,'Times_New_Roman',serif] text-[52px] font-normal leading-[0.95] md:text-[76px]">
                    {{ $event->name }}
                </h1>

                <p class="mt-4 text-[20px] font-black text-white/90">
                    {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('F d, Y') : 'Event date not set' }}
                </p>

                @if ($event->caption)
                    <p class="mt-5 max-w-2xl text-[20px] leading-[1.4] text-white/85">
                        {{ $event->caption }}
                    </p>
                @endif
            </section>

            <section class="mt-8 rounded-[34px] bg-[#efe8df] p-8 shadow-xl md:p-10">
                <div class="h-[2px] w-[70px] bg-[#9b7445]"></div>

                <h2 class="mt-8 [font-family:Georgia,'Times_New_Roman',serif] text-[46px] font-normal leading-[0.95] text-black md:text-[64px]">
                    Capture a Memory
                </h2>

                <p class="mt-4 text-[20px] leading-[1.4] text-[#9b7445]">
                    Tap the camera button and take one meaningful photo.
                </p>

                @if (session('success'))
                    <div class="mt-6 rounded-[24px] border border-green-300 bg-green-50 p-5 text-[18px] text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-[24px] border border-red-300 bg-red-50 p-5 text-[18px] text-red-700">
                        <ul class="list-disc pl-6">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('events.photos.upload', $event->code) }}" enctype="multipart/form-data" class="mt-8">
                    @csrf

                    <label class="text-[18px] font-black text-[#704500]">
                        Your Name
                    </label>

                    <input
                        type="text"
                        name="guest_name"
                        placeholder="Optional"
                        class="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none placeholder:text-[#9b7445]/60 focus:border-[#704500]"
                    >

                    <label class="mt-8 flex min-h-[170px] cursor-pointer flex-col items-center justify-center rounded-[34px] bg-[#704500] px-6 text-white shadow-xl transition hover:bg-[#583600] {{ $remaining <= 0 ? 'pointer-events-none opacity-50' : '' }}">
                        <span class="text-[54px]">📷</span>

                        <span class="mt-4 text-[28px] font-black">
                            Open Camera
                        </span>

                        <span class="mt-2 text-[16px] text-white/75">
                            {{ $remaining <= 0 ? 'Photo limit reached' : 'Use your phone camera only' }}
                        </span>

                        <input
                            type="file"
                            name="photo"
                            accept="image/*"
                            capture="environment"
                            class="hidden"
                            onchange="this.form.submit()"
                        >
                    </label>
                </form>
            </section>

            <section class="mt-8 rounded-[34px] bg-[#efe8df] p-8 shadow-xl md:p-10">
                <div class="h-[2px] w-[70px] bg-[#9b7445]"></div>

                <h2 class="mt-8 [font-family:Georgia,'Times_New_Roman',serif] text-[46px] font-normal leading-[0.95] text-black md:text-[64px]">
                    Event Album
                </h2>

                @if (!$albumUnlocked)
                    <div class="mt-8 rounded-[30px] bg-[#927a67] p-8 text-white">
                        <p class="text-[44px] leading-none">🔒</p>

                        <h3 class="mt-5 text-[28px] font-black">
                            Album Locked
                        </h3>

                        <p class="mt-3 max-w-xl text-[19px] leading-[1.4] text-white/80">
                            The album will open after the reveal date and time.
                        </p>

                        <p class="mt-4 text-[18px] font-black text-white">
                            Reveal: {{ $revealAt->format('F d, Y h:i A') }}
                        </p>

                        <button
                            type="button"
                            disabled
                            class="mt-6 h-[64px] w-full rounded-full bg-white/20 px-8 text-[20px] font-black text-white/60"
                        >
                            View Album Locked
                        </button>
                    </div>
                @else
                    <a
                        href="{{ route('events.album', $event->code) }}"
                        class="mt-8 flex h-[76px] w-full items-center justify-center rounded-full bg-[#704500] px-8 text-[24px] font-black text-white shadow-xl transition hover:bg-[#583600]"
                    >
                        View Album
                    </a>
                @endif
            </section>
        </div>
    </main>
</x-layouts.app>