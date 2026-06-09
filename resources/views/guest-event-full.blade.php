<x-layouts.app title="Event Full - Core Memoir" :guest="true">
    <main class="min-h-screen px-[4vw] py-16">
        <div class="mx-auto max-w-[720px]">
            <section class="rounded-[34px] bg-[#927a67] p-8 text-center text-white shadow-xl md:p-10">
                <p class="text-[52px] leading-none">🔒</p>

                <h1 class="mt-6 [font-family:Georgia,'Times_New_Roman',serif] text-[48px] font-normal leading-[0.95] md:text-[68px]">
                    Event Guest Limit Reached
                </h1>

                <p class="mt-6 text-[20px] leading-[1.4] text-white/85">
                    This event is already full. The creator allowed only
                    <span class="font-black">{{ $event->guest_limit }}</span>
                    guests to access this QR event.
                </p>

                <a
                    href="/"
                    class="mt-8 inline-flex h-[62px] items-center justify-center rounded-full bg-white px-8 text-[18px] font-black text-[#704500] hover:bg-[#f8f3ee]"
                >
                    Back Home
                </a>
            </section>
        </div>
    </main>
</x-layouts.app>