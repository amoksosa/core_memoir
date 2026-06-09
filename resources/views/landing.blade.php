<x-layouts.app title="Core Memoir">
    <main>
        <section class="relative min-h-screen overflow-hidden bg-[#fff8f3]">
            <div class="mx-auto grid min-h-screen max-w-[1800px] items-center px-[6vw] py-20 lg:grid-cols-[1fr_720px] xl:grid-cols-[1fr_820px]">
                <div class="relative z-20 max-w-[980px]">
                    <h1 class="[font-family:Georgia,'Times_New_Roman',serif] text-[64px] font-normal leading-[0.82] tracking-[-0.055em] text-black sm:text-[88px] md:text-[118px] lg:text-[130px] xl:text-[150px]">
                        The Digital
                        <br>
                        Disposable Camera
                    </h1>

                    <div class="mt-12 text-[#704500]">
                        <p class="text-[25px] font-black uppercase leading-[1.25] md:text-[30px]">
                            Collect every perspective.
                        </p>

                        <p class="mt-1 text-[25px] font-black uppercase leading-[1.25] md:text-[30px]">
                            Give your guests 25 meaningful exposures.
                        </p>

                        <p class="mt-3 max-w-[830px] text-[24px] leading-[1.25] md:text-[30px]">
                            Not all meaningful moments are captured by the photographer.
                            <br>
                            Some are captured by the people who matter most.
                        </p>

                        <div class="mt-10">
                            <p class="text-[27px] font-black uppercase md:text-[31px]">
                                Core Memoir
                            </p>

                            <p class="mt-1 text-[24px] italic leading-[1.25] md:text-[30px]">
                                Every Guest. Every Perspective. One Memory.
                            </p>
                        </div>

                        <div class="mt-12 flex flex-col gap-6 sm:flex-row">
                            <a
                                href="/create"
                                class="inline-flex h-[74px] min-w-[260px] items-center justify-center rounded-full bg-[#704500] px-10 text-[24px] text-white transition hover:bg-[#583600]"
                            >
                                Event Access
                            </a>

                            <a
                                href="#contact"
                                class="inline-flex h-[74px] min-w-[260px] items-center justify-center rounded-full bg-[#e8dbcf] px-10 text-[24px] text-[#4a2b00] transition hover:bg-[#d9c8b8]"
                            >
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 hidden h-full items-center justify-end lg:flex">
                    <img
                        src="{{ asset('images/core-memoir-hero.png') }}"
                        alt="Core Memoir hero"
                        class="absolute right-[-7vw] top-1/2 w-[900px] max-w-none -translate-y-1/2 object-contain xl:w-[1050px]"
                    >
                </div>

                <img
                    src="{{ asset('images/core-memoir-hero.png') }}"
                    alt="Core Memoir hero mobile"
                    class="relative z-10 mx-auto mt-12 block w-full max-w-[620px] object-contain lg:hidden"
                >
            </div>
        </section>

        <section id="how" class="bg-[#f8f3ee] px-[3vw] py-24 md:py-28">
            <div class="mx-auto max-w-[1800px]">
                <h2 class="[font-family:Georgia,'Times_New_Roman',serif] text-[58px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[92px] xl:text-[118px]">
                    How It Works for Guests
                </h2>

                <p class="mt-8 text-[22px] leading-[1.4] text-[#9b7445] md:text-[28px]">
                    A three-step process designed for the modern guest to capture the magic of your event.
                </p>

                <div class="mt-16 grid gap-8 xl:grid-cols-3">
                    <div class="min-h-[360px] rounded-[34px] bg-[#efe8df] px-11 py-10 text-[#8a5a12]">
                        <div class="h-[2px] w-[68px] bg-[#9b7445]"></div>

                        <h3 class="mt-10 text-[34px] font-black md:text-[42px]">
                            Scan the Code
                        </h3>

                        <p class="mt-8 text-[22px] leading-[1.42] text-[#9b7445] md:text-[24px]">
                            Guests scan the unique <span class="font-black">QR code</span> provided at your event.
                        </p>
                    </div>

                    <div class="min-h-[360px] rounded-[34px] bg-[#efe8df] px-11 py-10 text-[#8a5a12]">
                        <div class="h-[2px] w-[68px] bg-[#9b7445]"></div>

                        <h3 class="mt-10 text-[34px] font-black md:text-[42px]">
                            Access
                        </h3>

                        <p class="mt-8 text-[22px] leading-[1.42] text-[#9b7445] md:text-[24px]">
                            Guests can choose a nickname. No account registration required.
                        </p>
                    </div>

                    <div class="min-h-[360px] rounded-[34px] bg-[#efe8df] px-11 py-10 text-[#8a5a12]">
                        <div class="h-[2px] w-[68px] bg-[#9b7445]"></div>

                        <h3 class="mt-10 text-[34px] font-black md:text-[42px]">
                            Take the 25 Snaps
                        </h3>

                        <p class="mt-8 text-[22px] leading-[1.42] text-[#9b7445] md:text-[24px]">
                            Guests capture up to <span class="font-black">25 meaningful moments</span>.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[#f8f3ee] px-[3vw] py-20 md:py-24">
            <div class="mx-auto max-w-[1550px]">
                <div class="rounded-[30px] bg-[#927a67] px-10 py-12 text-white md:px-20 md:py-14">
                    <h2 class="[font-family:Georgia,'Times_New_Roman',serif] text-[56px] font-normal leading-[0.9] tracking-[-0.04em] md:text-[84px] xl:text-[100px]">
                        Why only 25 shots?
                    </h2>

                    <p class="mt-7 max-w-[980px] text-[24px] leading-[1.28] text-white md:text-[30px] xl:text-[32px]">
                        Core Memoir is inspired by the charm of disposable cameras.
                        With only 25 exposures,
                        <span class="font-black">
                            guests become more intentional about the moments they capture, resulting in more meaningful, authentic memories instead of hundreds of forgotten photos.
                        </span>
                    </p>
                </div>

                <div class="mt-16 px-0 md:px-16">
                    <h2 class="[font-family:Georgia,'Times_New_Roman',serif] text-[64px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[100px] xl:text-[112px]">
                        Good to know
                    </h2>

                    <div class="mt-12 grid gap-8 lg:grid-cols-[1.25fr_0.85fr]">
                        <div class="rounded-[28px] bg-[#efe8df] px-10 py-9 text-[#704500] md:px-16 md:py-11">
                            <h3 class="text-[28px] font-black leading-tight md:text-[34px]">
                                Your event, your rules
                            </h3>

                            <p class="mt-6 max-w-[900px] text-[21px] leading-[1.45] text-[#9b7445] md:text-[23px]">
                                Take control of how your gallery comes to life. Choose a signature style for every photo, decide how many guests can join, and set how many photos each guest can capture.
                            </p>
                        </div>

                        <div class="grid gap-6">
                            <div class="rounded-[28px] bg-[#efe8df] px-10 py-6 text-[#704500] md:px-12">
                                <h3 class="text-[27px] font-normal leading-tight md:text-[31px]">
                                    Are photos downloadable?
                                </h3>

                                <p class="mt-2 text-[20px] leading-snug text-[#9b7445] md:text-[22px]">
                                    Yes, download all with just one click!
                                </p>
                            </div>

                            <div class="rounded-[28px] bg-[#efe8df] px-10 py-6 text-[#704500] md:px-12">
                                <h3 class="text-[27px] font-normal leading-tight md:text-[31px]">
                                    Want to know more?
                                </h3>

                                <a
                                    href="#contact"
                                    class="mt-2 inline-block text-[20px] leading-snug text-[#9b7445] underline md:text-[22px]"
                                >
                                    Send us a message now!
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="gallery" class="bg-[#fff8f3] px-[6vw] py-24">
            <div class="mx-auto max-w-[1720px]">
                <div class="grid gap-8 lg:grid-cols-[1fr_360px] lg:items-end">
                    <h2 class="[font-family:Georgia,'Times_New_Roman',serif] text-[58px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[96px]">
                        Weddings,
                        <br>
                        Christening, Birthdays,
                        <br>
                        All Core Memories.
                    </h2>

                    <div class="flex gap-5 lg:justify-end">
                        <button
                            type="button"
                            class="h-16 w-16 rounded-full border border-[#704500] text-[28px] text-[#704500] hover:bg-[#704500] hover:text-white"
                        >
                            ←
                        </button>

                        <button
                            type="button"
                            class="h-16 w-16 rounded-full border border-[#704500] text-[28px] text-[#704500] hover:bg-[#704500] hover:text-white"
                        >
                            →
                        </button>
                    </div>
                </div>

                <div class="mt-16 grid gap-10 md:grid-cols-3">
                    <div class="rotate-[-2deg] bg-[#f9efe5] p-4 pb-14 shadow-[18px_18px_0px_rgba(112,69,0,0.18)]">
                        <div class="aspect-[4/5] overflow-hidden bg-[#e8dbcf]">
                            <img
                                src="{{ asset('images/gallery-1.png') }}"
                                alt="Core memory 01"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <p class="mt-5 text-center text-[28px] font-black text-[#704500]">
                            01
                        </p>
                    </div>

                    <div class="rotate-[1.5deg] bg-[#f9efe5] p-4 pb-14 shadow-[18px_18px_0px_rgba(112,69,0,0.18)]">
                        <div class="aspect-[4/5] overflow-hidden bg-[#e8dbcf]">
                            <img
                                src="{{ asset('images/gallery-2.png') }}"
                                alt="Core memory 02"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <p class="mt-5 text-center text-[28px] font-black text-[#704500]">
                            02
                        </p>
                    </div>

                    <div class="rotate-[-1deg] bg-[#f9efe5] p-4 pb-14 shadow-[18px_18px_0px_rgba(112,69,0,0.18)]">
                        <div class="aspect-[4/5] overflow-hidden bg-[#e8dbcf]">
                            <img
                                src="{{ asset('images/gallery-3.png') }}"
                                alt="Core memory 03"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <p class="mt-5 text-center text-[28px] font-black text-[#704500]">
                            03
                        </p>
                    </div>
                </div>

                <div class="mt-16 flex flex-col gap-5 sm:flex-row">
                    <a
                        href="/create"
                        class="inline-flex h-[68px] min-w-[240px] items-center justify-center rounded-full bg-[#704500] px-8 text-[22px] text-white hover:bg-[#583600]"
                    >
                        View Public Gallery
                    </a>

                    <a
                        href="/create"
                        class="inline-flex h-[68px] min-w-[220px] items-center justify-center rounded-full bg-[#e8dbcf] px-8 text-[22px] text-[#704500] hover:bg-[#d9c8b8]"
                    >
                        View Events
                    </a>
                </div>
            </div>
        </section>

        <section id="contact" class="bg-[#1b130b] px-[6vw] py-24 text-white">
            <div class="mx-auto grid max-w-[1720px] gap-12 lg:grid-cols-[1.1fr_0.9fr]">
                <div>
                    <h2 class="[font-family:Georgia,'Times_New_Roman',serif] text-[58px] font-normal leading-[0.9] md:text-[96px]">
                        Let&apos;s create
                        <br>
                        core memoir,
                        <br>
                        contact us now
                    </h2>
                </div>

                <div class="text-[23px] leading-[1.65] text-white/80">
                    <p>Facebook /corememoir</p>
                    <p>Instagram @corememoir</p>
                    <p>Tiktok @corememoir</p>
                    <p>Mobile 0998534020</p>

                    <p class="mt-20 text-[15px] uppercase tracking-[0.18em] text-white/45">
                        © 2026 CoreMemoir. All rights reserved.
                    </p>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>