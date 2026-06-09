import React, { useEffect, useMemo, useRef, useState } from 'react';
import { createRoot } from 'react-dom/client';
import '../css/app.css';

function getCsrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');
}

async function readJsonResponse(response) {
    const contentType = response.headers.get('content-type');

    if (contentType && contentType.includes('application/json')) {
        return await response.json();
    }

    const htmlError = await response.text();
    console.error('Laravel returned HTML:', htmlError);

    throw new Error('Finish all information');
}

const eventTemplates = [
    {
        id: 'wedding',
        name: 'Wedding',
        description: 'Elegant wedding style using soft whites, flowers, and romantic details.',
        pexelsQuery: 'wedding white flowers elegant bridal roses',
        previewClass: 'bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50 border-rose-300',
        pageClass: 'bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50 text-rose-950',
        cardClass: 'bg-white/75 border-rose-200 backdrop-blur',
        mutedTextClass: 'text-rose-700',
        accentTextClass: 'text-rose-500',
        buttonClass: 'bg-rose-500 text-white hover:bg-rose-400',
        inputClass: 'bg-white/80 border-rose-200 text-rose-950 focus:border-rose-400',
    },
    {
        id: 'birthday',
        name: 'Birthday',
        description: 'Colorful birthday party style with bright, fun celebration energy.',
        pexelsQuery: 'birthday party balloons cake colorful celebration',
        previewClass: 'bg-gradient-to-br from-purple-700 via-pink-600 to-yellow-400 border-pink-300',
        pageClass: 'bg-gradient-to-br from-purple-700 via-pink-600 to-yellow-400 text-white',
        cardClass: 'bg-white/20 border-white/30 backdrop-blur',
        mutedTextClass: 'text-white/80',
        accentTextClass: 'text-yellow-200',
        buttonClass: 'bg-yellow-300 text-purple-950 hover:bg-yellow-200',
        inputClass: 'bg-white/20 border-white/30 text-white placeholder:text-white/60 focus:border-yellow-200',
    },
    {
        id: 'graduation',
        name: 'Graduation',
        description: 'Graduation memory style with navy, gold, diploma, and achievement colors.',
        pexelsQuery: 'graduation diploma cap and gown university',
        previewClass: 'bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 border-yellow-400',
        pageClass: 'bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white',
        cardClass: 'bg-slate-900/80 border-yellow-400/30 backdrop-blur',
        mutedTextClass: 'text-slate-300',
        accentTextClass: 'text-yellow-300',
        buttonClass: 'bg-yellow-400 text-slate-950 hover:bg-yellow-300',
        inputClass: 'bg-slate-950 border-yellow-400/20 text-white focus:border-yellow-300',
    },
    {
        id: 'christening',
        name: 'Christening',
        description: 'Soft white and gentle family style for baptism and christening events.',
        pexelsQuery: 'christening baptism baby white flowers',
        previewClass: 'bg-gradient-to-br from-sky-50 via-white to-stone-100 border-sky-200',
        pageClass: 'bg-gradient-to-br from-sky-50 via-white to-stone-100 text-slate-900',
        cardClass: 'bg-white/80 border-sky-100 backdrop-blur',
        mutedTextClass: 'text-slate-600',
        accentTextClass: 'text-sky-500',
        buttonClass: 'bg-sky-500 text-white hover:bg-sky-400',
        inputClass: 'bg-white/80 border-sky-200 text-slate-900 focus:border-sky-400',
    },
    {
        id: 'baby-shower',
        name: 'Baby Shower',
        description: 'Soft pastel event style for baby showers and family celebrations.',
        pexelsQuery: 'baby shower pastel balloons baby party',
        previewClass: 'bg-gradient-to-br from-pink-100 via-blue-50 to-yellow-50 border-pink-200',
        pageClass: 'bg-gradient-to-br from-pink-100 via-blue-50 to-yellow-50 text-slate-900',
        cardClass: 'bg-white/75 border-pink-200 backdrop-blur',
        mutedTextClass: 'text-slate-600',
        accentTextClass: 'text-pink-500',
        buttonClass: 'bg-pink-500 text-white hover:bg-pink-400',
        inputClass: 'bg-white/80 border-pink-200 text-slate-900 focus:border-pink-400',
    },
    {
        id: 'debut',
        name: 'Debut',
        description: 'Elegant and feminine style for debut celebrations and formal parties.',
        pexelsQuery: 'debut party elegant dress celebration lights',
        previewClass: 'bg-gradient-to-br from-fuchsia-900 via-pink-700 to-rose-300 border-pink-300',
        pageClass: 'bg-gradient-to-br from-fuchsia-900 via-pink-700 to-rose-300 text-white',
        cardClass: 'bg-white/20 border-white/25 backdrop-blur',
        mutedTextClass: 'text-white/80',
        accentTextClass: 'text-pink-100',
        buttonClass: 'bg-pink-200 text-fuchsia-950 hover:bg-pink-100',
        inputClass: 'bg-white/20 border-white/25 text-white placeholder:text-white/60 focus:border-pink-100',
    },
    {
        id: 'party',
        name: 'Party',
        description: 'High-energy party style with bright lights and celebration colors.',
        pexelsQuery: 'party lights celebration friends nightlife',
        previewClass: 'bg-gradient-to-br from-indigo-900 via-purple-700 to-pink-500 border-purple-300',
        pageClass: 'bg-gradient-to-br from-indigo-900 via-purple-700 to-pink-500 text-white',
        cardClass: 'bg-white/20 border-white/25 backdrop-blur',
        mutedTextClass: 'text-white/80',
        accentTextClass: 'text-pink-200',
        buttonClass: 'bg-pink-300 text-indigo-950 hover:bg-pink-200',
        inputClass: 'bg-white/20 border-white/25 text-white placeholder:text-white/60 focus:border-pink-200',
    },
    {
        id: 'concert',
        name: 'Concert',
        description: 'Stage lights and live event style for concerts and performances.',
        pexelsQuery: 'concert stage lights crowd music performance',
        previewClass: 'bg-gradient-to-br from-black via-purple-950 to-red-700 border-red-400',
        pageClass: 'bg-gradient-to-br from-black via-purple-950 to-red-700 text-white',
        cardClass: 'bg-black/40 border-white/20 backdrop-blur',
        mutedTextClass: 'text-white/75',
        accentTextClass: 'text-red-300',
        buttonClass: 'bg-red-500 text-white hover:bg-red-400',
        inputClass: 'bg-black/40 border-white/20 text-white placeholder:text-white/60 focus:border-red-300',
    },
    {
        id: 'beach',
        name: 'Beach',
        description: 'Fresh tropical beach style with ocean, sand, and summer colors.',
        pexelsQuery: 'beach ocean sand tropical summer',
        previewClass: 'bg-gradient-to-br from-cyan-300 via-sky-200 to-amber-100 border-cyan-300',
        pageClass: 'bg-gradient-to-br from-cyan-300 via-sky-200 to-amber-100 text-slate-900',
        cardClass: 'bg-white/60 border-white/50 backdrop-blur',
        mutedTextClass: 'text-slate-700',
        accentTextClass: 'text-cyan-700',
        buttonClass: 'bg-cyan-600 text-white hover:bg-cyan-500',
        inputClass: 'bg-white/70 border-cyan-200 text-slate-900 focus:border-cyan-500',
    },
    {
        id: 'garden',
        name: 'Garden',
        description: 'Natural garden event style with greenery and soft outdoor tones.',
        pexelsQuery: 'garden party greenery flowers outdoor event',
        previewClass: 'bg-gradient-to-br from-green-900 via-emerald-600 to-lime-200 border-emerald-300',
        pageClass: 'bg-gradient-to-br from-green-900 via-emerald-600 to-lime-200 text-white',
        cardClass: 'bg-white/20 border-white/25 backdrop-blur',
        mutedTextClass: 'text-white/80',
        accentTextClass: 'text-lime-200',
        buttonClass: 'bg-lime-300 text-green-950 hover:bg-lime-200',
        inputClass: 'bg-white/20 border-white/25 text-white placeholder:text-white/60 focus:border-lime-200',
    },
    {
        id: 'luxury',
        name: 'Luxury',
        description: 'Premium black and gold style for formal and luxury events.',
        pexelsQuery: 'luxury event black gold elegant table',
        previewClass: 'bg-gradient-to-br from-black via-stone-900 to-yellow-700 border-yellow-400',
        pageClass: 'bg-gradient-to-br from-black via-stone-900 to-yellow-700 text-yellow-50',
        cardClass: 'bg-black/45 border-yellow-400/30 backdrop-blur',
        mutedTextClass: 'text-yellow-100/80',
        accentTextClass: 'text-yellow-300',
        buttonClass: 'bg-yellow-400 text-black hover:bg-yellow-300',
        inputClass: 'bg-black/40 border-yellow-400/30 text-yellow-50 focus:border-yellow-300',
    },
    {
        id: 'vintage',
        name: 'Vintage',
        description: 'Warm old-camera style inspired by film, retro photos, and nostalgia.',
        pexelsQuery: 'vintage camera film old photos retro',
        previewClass: 'bg-gradient-to-br from-yellow-950 via-stone-900 to-black border-amber-600',
        pageClass: 'bg-gradient-to-br from-yellow-950 via-stone-900 to-black text-amber-50',
        cardClass: 'bg-black/40 border-amber-700/40 backdrop-blur',
        mutedTextClass: 'text-amber-100/80',
        accentTextClass: 'text-amber-300',
        buttonClass: 'bg-amber-500 text-black hover:bg-amber-400',
        inputClass: 'bg-black/40 border-amber-700/40 text-amber-50 focus:border-amber-400',
    },
    {
        id: 'minimal',
        name: 'Minimal',
        description: 'Clean white design for simple, modern, and quiet events.',
        pexelsQuery: 'minimal white event clean aesthetic',
        previewClass: 'bg-white border-slate-300',
        pageClass: 'bg-slate-100 text-slate-950',
        cardClass: 'bg-white border-slate-200',
        mutedTextClass: 'text-slate-600',
        accentTextClass: 'text-slate-950',
        buttonClass: 'bg-slate-950 text-white hover:bg-slate-800',
        inputClass: 'bg-white border-slate-300 text-slate-950 focus:border-slate-900',
    },
    {
        id: 'corporate',
        name: 'Corporate',
        description: 'Professional style for business events, company gatherings, and launches.',
        pexelsQuery: 'corporate event business conference professional',
        previewClass: 'bg-gradient-to-br from-slate-900 via-blue-900 to-slate-700 border-blue-300',
        pageClass: 'bg-gradient-to-br from-slate-900 via-blue-900 to-slate-700 text-white',
        cardClass: 'bg-white/15 border-white/20 backdrop-blur',
        mutedTextClass: 'text-slate-200',
        accentTextClass: 'text-blue-200',
        buttonClass: 'bg-blue-400 text-slate-950 hover:bg-blue-300',
        inputClass: 'bg-white/15 border-white/20 text-white placeholder:text-white/60 focus:border-blue-200',
    },
    {
        id: 'rustic',
        name: 'Rustic',
        description: 'Warm wood, brown, and outdoor rustic event style.',
        pexelsQuery: 'rustic wedding wood outdoor event lights',
        previewClass: 'bg-gradient-to-br from-stone-900 via-yellow-900 to-orange-300 border-orange-300',
        pageClass: 'bg-gradient-to-br from-stone-900 via-yellow-900 to-orange-300 text-white',
        cardClass: 'bg-black/30 border-orange-200/30 backdrop-blur',
        mutedTextClass: 'text-orange-50/80',
        accentTextClass: 'text-orange-200',
        buttonClass: 'bg-orange-300 text-stone-950 hover:bg-orange-200',
        inputClass: 'bg-black/30 border-orange-200/30 text-white placeholder:text-white/60 focus:border-orange-200',
    },
    {
        id: 'travel',
        name: 'Travel',
        description: 'Adventure and destination style for trips, travel parties, and tours.',
        pexelsQuery: 'travel adventure destination friends vacation',
        previewClass: 'bg-gradient-to-br from-blue-800 via-cyan-500 to-orange-200 border-cyan-300',
        pageClass: 'bg-gradient-to-br from-blue-800 via-cyan-500 to-orange-200 text-white',
        cardClass: 'bg-white/20 border-white/25 backdrop-blur',
        mutedTextClass: 'text-white/85',
        accentTextClass: 'text-orange-100',
        buttonClass: 'bg-orange-200 text-blue-950 hover:bg-orange-100',
        inputClass: 'bg-white/20 border-white/25 text-white placeholder:text-white/60 focus:border-orange-100',
    },
    {
        id: 'family',
        name: 'Family',
        description: 'Warm and cozy style for reunions, family days, and intimate gatherings.',
        pexelsQuery: 'family gathering happy people outdoor',
        previewClass: 'bg-gradient-to-br from-orange-100 via-amber-50 to-rose-100 border-orange-200',
        pageClass: 'bg-gradient-to-br from-orange-100 via-amber-50 to-rose-100 text-stone-900',
        cardClass: 'bg-white/70 border-orange-200 backdrop-blur',
        mutedTextClass: 'text-stone-600',
        accentTextClass: 'text-orange-600',
        buttonClass: 'bg-orange-500 text-white hover:bg-orange-400',
        inputClass: 'bg-white/75 border-orange-200 text-stone-900 focus:border-orange-400',
    },
    {
        id: 'night',
        name: 'Night',
        description: 'Dark neon style for evening parties, nightlife, and moody events.',
        pexelsQuery: 'night party neon lights city celebration',
        previewClass: 'bg-gradient-to-br from-black via-indigo-950 to-fuchsia-700 border-fuchsia-400',
        pageClass: 'bg-gradient-to-br from-black via-indigo-950 to-fuchsia-700 text-white',
        cardClass: 'bg-black/40 border-fuchsia-400/30 backdrop-blur',
        mutedTextClass: 'text-white/75',
        accentTextClass: 'text-fuchsia-300',
        buttonClass: 'bg-fuchsia-500 text-white hover:bg-fuchsia-400',
        inputClass: 'bg-black/40 border-fuchsia-400/30 text-white placeholder:text-white/60 focus:border-fuchsia-300',
    },
    {
        id: 'flowers',
        name: 'Flowers',
        description: 'Floral, soft, and romantic style for gentle event galleries.',
        pexelsQuery: 'flowers bouquet floral event soft aesthetic',
        previewClass: 'bg-gradient-to-br from-pink-100 via-rose-50 to-green-100 border-pink-200',
        pageClass: 'bg-gradient-to-br from-pink-100 via-rose-50 to-green-100 text-rose-950',
        cardClass: 'bg-white/70 border-pink-200 backdrop-blur',
        mutedTextClass: 'text-rose-700',
        accentTextClass: 'text-pink-500',
        buttonClass: 'bg-pink-500 text-white hover:bg-pink-400',
        inputClass: 'bg-white/75 border-pink-200 text-rose-950 focus:border-pink-400',
    },
    {
        id: 'gold',
        name: 'Gold',
        description: 'Gold celebration style for premium, formal, and milestone events.',
        pexelsQuery: 'gold celebration luxury party elegant',
        previewClass: 'bg-gradient-to-br from-yellow-100 via-yellow-400 to-yellow-900 border-yellow-500',
        pageClass: 'bg-gradient-to-br from-yellow-100 via-yellow-400 to-yellow-900 text-stone-950',
        cardClass: 'bg-white/45 border-yellow-200 backdrop-blur',
        mutedTextClass: 'text-stone-800',
        accentTextClass: 'text-yellow-800',
        buttonClass: 'bg-stone-950 text-yellow-100 hover:bg-stone-800',
        inputClass: 'bg-white/65 border-yellow-300 text-stone-950 focus:border-yellow-700',
    },
];

const photoFrames = [
    {
        id: 'clean',
        name: 'Clean Border',
        description: 'Simple rounded photo border.',
        className: 'rounded-2xl border border-white/10 bg-white/5 p-1',
        imageClass: 'rounded-xl',
    },
    {
        id: 'polaroid',
        name: 'Polaroid',
        description: 'White instant-camera style frame.',
        className: 'rounded-md bg-white p-3 pb-10 shadow-2xl rotate-[-1deg]',
        imageClass: 'rounded-sm',
    },
    {
        id: 'film',
        name: 'Film Strip',
        description: 'Dark film-inspired photo border.',
        className: 'rounded-xl border-4 border-black bg-black p-2 shadow-2xl',
        imageClass: 'rounded-md',
    },
    {
        id: 'gold',
        name: 'Gold Frame',
        description: 'Premium gold event border.',
        className: 'rounded-2xl border-4 border-yellow-400 bg-yellow-100 p-2 shadow-2xl',
        imageClass: 'rounded-xl',
    },
    {
        id: 'soft',
        name: 'Soft Rounded',
        description: 'Soft elegant rounded frame.',
        className: 'rounded-[2rem] border border-rose-200 bg-white/70 p-2 shadow-xl',
        imageClass: 'rounded-[1.5rem]',
    },
    {
        id: 'neon',
        name: 'Neon Glow',
        description: 'Bright glowing neon frame.',
        className: 'rounded-2xl border-2 border-fuchsia-400 bg-black p-2 shadow-[0_0_28px_rgba(217,70,239,0.55)]',
        imageClass: 'rounded-xl',
    },
    {
        id: 'journal',
        name: 'Journal Style',
        description: 'Scrapbook-style border for soft memory galleries.',
        className: 'rounded-xl border border-stone-300 bg-[#fff8e8] p-3 shadow-xl rotate-[1deg]',
        imageClass: 'rounded-lg',
    },
];

const fontStyles = [
    { id: 'modern', name: 'Modern', className: 'font-sans' },
    { id: 'elegant', name: 'Elegant', className: 'font-serif' },
    { id: 'bold', name: 'Bold', className: 'font-black tracking-tight' },
    { id: 'classic', name: 'Classic', className: 'font-serif tracking-wide' },
    { id: 'handwritten', name: 'Handwritten', className: 'font-serif italic' },
];

function findTemplate(id) {
    return eventTemplates.find((template) => template.id === id) || eventTemplates[0];
}

function findFrame(id) {
    return photoFrames.find((frame) => frame.id === id) || photoFrames[1];
}

function findFont(id) {
    return fontStyles.find((font) => font.id === id) || fontStyles[0];
}

function formatEventDate(dateValue) {
    if (!dateValue) return 'Event date not set';

    return new Date(dateValue).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}

function formatRevealDate(dateValue) {
    if (!dateValue) return 'No reveal date set';

    return new Date(dateValue).toLocaleString(undefined, {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
    });
}

function CustomStyleDropdown({
    label,
    items,
    selectedId,
    onSelect,
    renderPreview,
    renderOption,
}) {
    const [open, setOpen] = useState(false);
    const selectedItem = items.find((item) => item.id === selectedId) || items[0];

    return (
        <div className="relative">
            <label className="text-[18px] font-black text-[#704500]">
                {label}
            </label>

            <button
                type="button"
                onClick={() => setOpen((current) => !current)}
                className="mt-3 w-full rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-5 text-left text-[#704500] outline-none transition hover:border-[#704500]"
            >
                {renderPreview(selectedItem)}

                <div className="mt-4 flex items-center justify-between gap-4">
                    <div>
                        <p className="text-[20px] font-black">
                            {selectedItem.name}
                        </p>

                        {selectedItem.description && (
                            <p className="mt-1 text-[16px] leading-[1.35] text-[#9b7445]">
                                {selectedItem.description}
                            </p>
                        )}
                    </div>

                    <span className="text-[30px] leading-none text-[#704500]">
                        {open ? '⌃' : '⌄'}
                    </span>
                </div>
            </button>

            {open && (
                <div className="absolute left-0 right-0 top-full z-40 mt-3 max-h-[520px] overflow-y-auto rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] p-3 shadow-2xl">
                    <div className="grid gap-3">
                        {items.map((item) => (
                            <button
                                type="button"
                                key={item.id}
                                onClick={() => {
                                    onSelect(item.id);
                                    setOpen(false);
                                }}
                                className={`rounded-[22px] border p-4 text-left transition ${
                                    selectedId === item.id
                                        ? 'border-[#704500] bg-[#704500] text-white'
                                        : 'border-[#d8cabe] bg-[#fff8f3] text-[#704500] hover:border-[#704500]'
                                }`}
                            >
                                {renderOption(item, selectedId === item.id)}
                            </button>
                        ))}
                    </div>
                </div>
            )}
        </div>
    );
}

function TemplatePreview({ item }) {
    return (
        <div className={`h-24 rounded-[20px] border ${item.previewClass}`} />
    );
}

function FramePreview({ item }) {
    return (
        <div className="flex h-[150px] items-center justify-center rounded-[22px] bg-[#e8dbcf]">
            <div className={item.className}>
                <div className={`h-20 w-28 bg-gradient-to-br from-slate-300 to-slate-500 ${item.imageClass}`} />
            </div>
        </div>
    );
}

function FontPreview({ item }) {
    return (
        <div className="rounded-[22px] bg-[#e8dbcf] px-6 py-5">
            <p className={`text-[46px] text-[#704500] ${item.className}`}>
                Aa
            </p>
        </div>
    );
}

function App() {
    const path = window.location.pathname;

    if (path.startsWith('/e/')) {
        return <GuestEventPage />;
    }

    if (path.startsWith('/create')) {
        return <CreateEventPage />;
    }

    return <LandingPage />;
}

function LandingPage() {
    return (
        <div className="min-h-screen overflow-x-hidden bg-[#fff8f3] text-[#1b130b] [font-family:Arial,Helvetica,sans-serif]">
            <header className="absolute left-0 top-0 z-50 w-full bg-[#f4ede5]">
                <div className="mx-auto flex h-[120px] max-w-[1720px] items-center justify-between px-[6vw]">
                    <a href="/" className="flex items-center gap-4">
                        <img
                            src="/images/core-memoir-logo.png"
                            alt="Core Memoir logo"
                            className="h-[58px] w-auto object-contain"
                        />

                        <span className="[font-family:Georgia,'Times_New_Roman',serif] text-[34px] font-normal uppercase tracking-[0.02em] text-[#8b6f58]">
                            CORE MEMOIR
                        </span>
                    </a>

                    <nav className="hidden items-center gap-[70px] text-[20px] font-normal text-[#8b6f58] md:flex">
                        <a href="/" className="underline underline-offset-4 hover:text-[#704500]">
                            Home
                        </a>

                        <a href="#how" className="hover:text-[#704500]">
                            How It Works
                        </a>

                        <a href="#gallery" className="hover:text-[#704500]">
                            Public Gallery
                        </a>

                        <a href="#contact" className="hover:text-[#704500]">
                            Contact Us
                        </a>
                    </nav>
                </div>
            </header>

            <main>
                <section className="relative min-h-screen overflow-hidden bg-[#fff8f3]">
                    <div className="mx-auto grid min-h-screen max-w-[1800px] items-center px-[6vw] pt-[150px] lg:grid-cols-[1fr_720px] xl:grid-cols-[1fr_820px]">
                        <div className="relative z-20 max-w-[980px] pb-16 pt-20">
                            <h1 className="[font-family:Georgia,'Times_New_Roman',serif] text-[64px] font-normal leading-[0.82] tracking-[-0.055em] text-black sm:text-[88px] md:text-[118px] lg:text-[130px] xl:text-[150px] 2xl:text-[165px]">
                                The Digital
                                <br />
                                Disposable Camera
                            </h1>

                            <div className="mt-16 text-[#704500]">
                                <p className="text-[25px] font-black uppercase leading-[1.25] tracking-[-0.015em] md:text-[30px]">
                                    Collect every perspective.
                                </p>

                                <p className="mt-1 text-[25px] font-black uppercase leading-[1.25] tracking-[-0.015em] md:text-[30px]">
                                    Give your guests 25 meaningful exposures.
                                </p>

                                <p className="mt-2 max-w-[830px] text-[24px] font-normal leading-[1.25] tracking-[-0.015em] md:text-[30px]">
                                    Not all meaningful moments are captured by the photographer.
                                    <br />
                                    Some are captured by the people who matter most.
                                </p>

                                <div className="mt-10">
                                    <p className="text-[27px] font-black uppercase tracking-[-0.02em] md:text-[31px]">
                                        Core Memoir
                                    </p>

                                    <p className="mt-1 text-[24px] italic leading-[1.25] md:text-[30px]">
                                        Every Guest. Every Perspective. One Memory.
                                    </p>
                                </div>

                                <div className="mt-12 flex flex-col gap-6 sm:flex-row">
                                    <a
                                        href="/create"
                                        className="inline-flex h-[74px] min-w-[260px] items-center justify-center rounded-full bg-[#704500] px-10 text-[24px] font-normal text-white transition hover:bg-[#583600]"
                                    >
                                        Event Access
                                    </a>

                                    <a
                                        href="#contact"
                                        className="inline-flex h-[74px] min-w-[260px] items-center justify-center rounded-full bg-[#e8dbcf] px-10 text-[24px] font-normal text-[#4a2b00] transition hover:bg-[#d9c8b8]"
                                    >
                                        Contact Us
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div className="relative z-10 hidden h-full items-center justify-end lg:flex">
                            <img
                                src="/images/core-memoir-hero.png"
                                alt="Core Memoir hero"
                                className="absolute right-[-7vw] top-1/2 w-[900px] max-w-none -translate-y-1/2 object-contain xl:w-[1050px] 2xl:w-[1160px]"
                            />
                        </div>

                        <img
                            src="/images/core-memoir-hero.png"
                            alt="Core Memoir hero mobile"
                            className="relative z-10 mx-auto mb-16 block w-full max-w-[620px] object-contain lg:hidden"
                        />
                    </div>
                </section>

                <section className="bg-[#1b130b] px-[6vw] py-8 text-white">
                    <div className="mx-auto flex max-w-[1720px] flex-col gap-4 md:flex-row md:items-center">
                        <a
                            href="/create"
                            className="inline-flex h-[58px] items-center justify-center rounded-full border border-white/25 px-10 text-[18px] transition hover:bg-white hover:text-[#1b130b]"
                        >
                            View Events
                        </a>

                        <a
                            href="#contact"
                            className="inline-flex h-[58px] items-center justify-center rounded-full border border-white/25 px-10 text-[18px] transition hover:bg-white hover:text-[#1b130b]"
                        >
                            Contact Us
                        </a>

                        <a
                            href="#how"
                            className="inline-flex h-[58px] items-center justify-center rounded-full border border-white/25 px-10 text-[18px] transition hover:bg-white hover:text-[#1b130b]"
                        >
                            How It Works
                        </a>
                    </div>
                </section>

                <section id="how" className="bg-[#f8f3ee] px-[3vw] py-24 md:py-28">
                    <div className="mx-auto max-w-[1800px]">
                        <div className="max-w-[1500px]">
                            <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[58px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[92px] xl:text-[118px]">
                                How It Works for Guests
                            </h2>

                            <p className="mt-8 text-[22px] leading-[1.4] text-[#9b7445] md:text-[28px]">
                                A three-step process designed for the modern guest to capture the magic of your event.
                            </p>
                        </div>

                        <div className="mt-16 grid gap-8 xl:grid-cols-3">
                            {[
                                {
                                    title: 'Scan the Code',
                                    body: (
                                        <>
                                            Guests scan the unique <span className="font-black">QR code</span>
                                            <br />
                                            provided at your event to join your
                                            <br />
                                            personal event gallery.
                                        </>
                                    ),
                                },
                                {
                                    title: 'Access',
                                    body: (
                                        <>
                                            Guests can choose a <span className="font-black">nickname</span> that will
                                            <br />
                                            be attached to their photos, allowing
                                            <br />
                                            event hosts to see who captured each
                                            <br />
                                            memory. Every guest is assigned a
                                            <br />
                                            unique <span className="font-black">Camera ID</span> for session recovery
                                            <br />
                                            and identification. No email, phone
                                            <br />
                                            number, or account registration is
                                            <br />
                                            required
                                        </>
                                    ),
                                },
                                {
                                    title: 'Take the 25 Snaps',
                                    body: (
                                        <>
                                            Guests capture up to <span className="font-black">25 meaningful</span>
                                            <br />
                                            <span className="font-black">moments</span> using their smartphones. Core
                                            <br />
                                            Memoir automatically collects and styles
                                            <br />
                                            every photo into one beautiful event
                                            <br />
                                            gallery.
                                        </>
                                    ),
                                },
                            ].map((item) => (
                                <div
                                    key={item.title}
                                    className="min-h-[460px] rounded-[34px] bg-[#efe8df] px-11 py-10 text-[#8a5a12]"
                                >
                                    <div className="h-[2px] w-[68px] bg-[#9b7445]" />

                                    <h3 className="mt-10 text-[34px] font-black leading-[1.05] tracking-[-0.03em] md:text-[42px]">
                                        {item.title}
                                    </h3>

                                    <p className="mt-8 max-w-[470px] text-[22px] leading-[1.42] text-[#9b7445] md:text-[24px]">
                                        {item.body}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                <section className="bg-[#f8f3ee] px-[3vw] py-20 md:py-24">
                    <div className="mx-auto max-w-[1550px]">
                        <div className="rounded-[30px] bg-[#927a67] px-12 py-12 text-white md:px-20 md:py-14">
                            <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[56px] font-normal leading-[0.9] tracking-[-0.04em] md:text-[84px] xl:text-[100px]">
                                Why only 25 shots?
                            </h2>

                            <p className="mt-7 max-w-[980px] text-[24px] leading-[1.28] text-white md:text-[30px] xl:text-[32px]">
                                Core Memoir is inspired by the charm of disposable cameras.
                                With only 25 exposures,{' '}
                                <span className="font-black">
                                    guests become more intentional about the moments they capture, resulting in more meaningful, authentic memories instead of hundreds of forgotten photos.
                                </span>
                            </p>
                        </div>

                        <div className="mt-16 px-0 md:px-16">
                            <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[64px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[100px] xl:text-[112px]">
                                Good to know
                            </h2>

                            <div className="mt-12 grid gap-8 lg:grid-cols-[1.25fr_0.85fr]">
                                <div className="rounded-[28px] bg-[#efe8df] px-10 py-9 text-[#704500] md:px-16 md:py-11">
                                    <h3 className="text-[28px] font-black leading-tight md:text-[34px]">
                                        Your event, your rules
                                    </h3>

                                    <p className="mt-6 max-w-[900px] text-[21px] leading-[1.45] text-[#9b7445] md:text-[23px]">
                                        Take control of how your gallery comes to life. Choose a signature style for every photo, decide whether your event is public or private, and set how many guests can join the experience.
                                    </p>
                                </div>

                                <div className="grid gap-6">
                                    <div className="rounded-[28px] bg-[#efe8df] px-10 py-6 text-[#704500] md:px-12">
                                        <h3 className="text-[27px] font-normal leading-tight md:text-[31px]">
                                            Are photos downloadable?
                                        </h3>

                                        <p className="mt-2 text-[20px] leading-snug text-[#9b7445] md:text-[22px]">
                                            Yes, download all with just one click!
                                        </p>
                                    </div>

                                    <div className="rounded-[28px] bg-[#efe8df] px-10 py-6 text-[#704500] md:px-12">
                                        <h3 className="text-[27px] font-normal leading-tight md:text-[31px]">
                                            Want to know more?
                                        </h3>

                                        <a
                                            href="#contact"
                                            className="mt-2 inline-block text-[20px] leading-snug text-[#9b7445] underline md:text-[22px]"
                                        >
                                            Send us a message now!
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="gallery" className="bg-[#fff8f3] px-[6vw] py-24">
                    <div className="mx-auto max-w-[1720px]">
                        <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[58px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[96px]">
                            Weddings,
                            <br />
                            Christening, Birthdays,
                            <br />
                            All Core Memories.
                        </h2>

                        <div className="mt-16 grid gap-10 md:grid-cols-3">
                            {[
                                { image: '/images/gallery-1.png', number: '01', rotate: 'rotate-[-2deg]' },
                                { image: '/images/gallery-2.png', number: '02', rotate: 'rotate-[1.5deg]' },
                                { image: '/images/gallery-3.png', number: '03', rotate: 'rotate-[-1deg]' },
                            ].map((item) => (
                                <div
                                    key={item.number}
                                    className={`${item.rotate} bg-[#f9efe5] p-4 pb-14 shadow-[18px_18px_0px_rgba(112,69,0,0.18)]`}
                                >
                                    <div className="aspect-[4/5] overflow-hidden bg-[#e8dbcf]">
                                        <img
                                            src={item.image}
                                            alt={`Core memory ${item.number}`}
                                            className="h-full w-full object-cover"
                                        />
                                    </div>

                                    <p className="mt-5 text-center text-[28px] font-black text-[#704500]">
                                        {item.number}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                <section id="contact" className="bg-[#1b130b] px-[6vw] py-24 text-white">
                    <div className="mx-auto grid max-w-[1720px] gap-12 lg:grid-cols-[1.1fr_0.9fr]">
                        <div>
                            <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[58px] font-normal leading-[0.9] tracking-[-0.05em] md:text-[96px]">
                                Let&apos;s create
                                <br />
                                core memoir,
                                <br />
                                contact us now
                            </h2>
                        </div>

                        <div className="text-[23px] leading-[1.65] text-white/80">
                            <p>Facebook /corememoir</p>
                            <p>Instagram @corememoir</p>
                            <p>Tiktok @corememoir</p>
                            <p>Mobile 0998534020</p>

                            <p className="mt-20 text-[15px] uppercase tracking-[0.18em] text-white/45">
                                © 2026 CoreMemoir. All rights reserved.
                            </p>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    );
}

function CreateEventPage() {
    const [name, setName] = useState('');
    const [eventDate, setEventDate] = useState('');
    const [photoLimit, setPhotoLimit] = useState(25);
    const [revealAt, setRevealAt] = useState('');
    const [caption, setCaption] = useState('');

    const [selectedTemplate, setSelectedTemplate] = useState('wedding');
    const [selectedFrame, setSelectedFrame] = useState('polaroid');
    const [selectedFont, setSelectedFont] = useState('modern');

    const [loading, setLoading] = useState(false);
    const [createdEvent, setCreatedEvent] = useState(null);
    const [error, setError] = useState('');

    const template = findTemplate(selectedTemplate);
    const frame = findFrame(selectedFrame);
    const font = findFont(selectedFont);

    async function createEvent(e) {
        e.preventDefault();

        setLoading(true);
        setError('');
        setCreatedEvent(null);

        try {
            const response = await fetch('/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify({
                    name,
                    event_date: eventDate || null,
                    photo_limit: photoLimit,
                    reveal_at: revealAt || null,

                    theme: selectedTemplate,
                    template: selectedTemplate,
                    photo_frame: selectedFrame,
                    font_style: selectedFont,
                    caption: caption || null,

                    background_image: null,
                    background_photographer: null,
                    background_photographer_url: null,
                }),
            });

            const data = await readJsonResponse(response);

            if (!response.ok) {
                throw new Error(data.message || 'Something went wrong.');
            }

            setCreatedEvent(data);
            setName('');
            setEventDate('');
            setPhotoLimit(25);
            setRevealAt('');
            setCaption('');
            setSelectedTemplate('wedding');
            setSelectedFrame('polaroid');
            setSelectedFont('modern');
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    }

    async function copyLink() {
        if (!createdEvent?.guest_link) return;

        await navigator.clipboard.writeText(createdEvent.guest_link);
        alert('Guest link copied!');
    }

    return (
        <div className="min-h-screen bg-[#f8f3ee] text-[#2d1a00] [font-family:Arial,Helvetica,sans-serif]">
            <header className="sticky left-0 top-0 z-50 w-full bg-[#f4ede5]">
                <div className="mx-auto flex h-[120px] max-w-[1720px] items-center justify-between px-[6vw]">
                    <a href="/" className="flex items-center gap-4">
                        <img
                            src="/images/core-memoir-logo.png"
                            alt="Core Memoir logo"
                            className="h-[58px] w-auto object-contain"
                        />

                        <span className="[font-family:Georgia,'Times_New_Roman',serif] text-[34px] font-normal uppercase tracking-[0.02em] text-[#8b6f58]">
                            CORE MEMOIR
                        </span>
                    </a>

                    <nav className="hidden items-center gap-[70px] text-[20px] font-normal text-[#8b6f58] md:flex">
                        <a href="/" className="hover:text-[#704500]">
                            Home
                        </a>

                        <a href="/#how" className="hover:text-[#704500]">
                            How It Works
                        </a>

                        <a href="/#gallery" className="hover:text-[#704500]">
                            Public Gallery
                        </a>

                        <a href="/#contact" className="hover:text-[#704500]">
                            Contact Us
                        </a>
                    </nav>
                </div>
            </header>

            <main className="px-[3vw] py-16">
                <div className="mx-auto max-w-[1650px]">
                    <div className="grid gap-10 xl:grid-cols-[1fr_480px]">
                        <div>
                            <p className="text-[18px] font-black uppercase tracking-[0.2em] text-[#704500]">
                                Event Access
                            </p>

                            <h1 className="mt-4 [font-family:Georgia,'Times_New_Roman',serif] text-[64px] font-normal leading-[0.9] tracking-[-0.05em] text-black md:text-[100px]">
                                Create Event
                                <br />
                                Design
                            </h1>

                            <p className="mt-6 max-w-[760px] text-[24px] leading-[1.35] text-[#9b7445]">
                                Choose your event style, photo border, font, and caption.
                                This will become the design guests see when they open your event camera.
                            </p>
                        </div>

                        <div className="rounded-[30px] bg-[#927a67] p-8 text-white">
                            <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[46px] font-normal leading-[0.95]">
                                Core Memoir
                            </h2>

                            <p className="mt-5 text-[21px] leading-[1.4] text-white/85">
                                Every guest. Every perspective. One memory.
                            </p>

                            <a
                                href="/"
                                className="mt-8 inline-flex h-[58px] items-center justify-center rounded-full bg-white px-8 text-[18px] text-[#704500] hover:bg-[#f8f3ee]"
                            >
                                Back Home
                            </a>
                        </div>
                    </div>

                    <div className="mt-16 grid gap-8 xl:grid-cols-[1fr_520px]">
                        <form onSubmit={createEvent} className="space-y-8">
                            <section className="rounded-[34px] bg-[#efe8df] p-8 md:p-10">
                                <div className="h-[2px] w-[70px] bg-[#9b7445]" />

                                <h2 className="mt-8 text-[36px] font-black tracking-[-0.03em] text-[#704500]">
                                    Event Details
                                </h2>

                                <div className="mt-8 grid gap-6 md:grid-cols-2">
                                    <div>
                                        <label className="text-[18px] font-black text-[#704500]">
                                            Event Name
                                        </label>
                                        <input
                                            type="text"
                                            value={name}
                                            onChange={(e) => setName(e.target.value)}
                                            placeholder="Example: John's Birthday"
                                            className="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none placeholder:text-[#9b7445]/60 focus:border-[#704500]"
                                        />
                                    </div>

                                    <div>
                                        <label className="text-[18px] font-black text-[#704500]">
                                            Event Date
                                        </label>
                                        <input
                                            type="date"
                                            value={eventDate}
                                            onChange={(e) => setEventDate(e.target.value)}
                                            className="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none focus:border-[#704500]"
                                        />
                                    </div>

                                    <div>
                                        <label className="text-[18px] font-black text-[#704500]">
                                            Photo Limit
                                        </label>
                                        <input
                                            type="number"
                                            min="1"
                                            max="500"
                                            value={photoLimit}
                                            onChange={(e) => setPhotoLimit(e.target.value)}
                                            className="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none focus:border-[#704500]"
                                        />
                                    </div>

                                    <div>
                                        <label className="text-[18px] font-black text-[#704500]">
                                            Reveal Date and Time
                                        </label>
                                        <input
                                            type="datetime-local"
                                            value={revealAt}
                                            onChange={(e) => setRevealAt(e.target.value)}
                                            className="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none focus:border-[#704500]"
                                        />
                                    </div>

                                    <div className="md:col-span-2">
                                        <label className="text-[18px] font-black text-[#704500]">
                                            Event Caption / Description
                                        </label>
                                        <textarea
                                            value={caption}
                                            onChange={(e) => setCaption(e.target.value)}
                                            placeholder="Capture memories from our special day."
                                            rows="5"
                                            className="mt-3 w-full resize-none rounded-[28px] border border-[#d8cabe] bg-[#f8f3ee] px-6 py-5 text-[18px] text-[#704500] outline-none placeholder:text-[#9b7445]/60 focus:border-[#704500]"
                                        />
                                    </div>
                                </div>
                            </section>

                            <section className="rounded-[34px] bg-[#efe8df] p-8 md:p-10">
                                <div className="h-[2px] w-[70px] bg-[#9b7445]" />

                                <h2 className="mt-8 text-[36px] font-black tracking-[-0.03em] text-[#704500]">
                                    Event Style
                                </h2>

                                <p className="mt-3 text-[20px] leading-[1.4] text-[#9b7445]">
                                    Choose the design options using visual dropdowns.
                                </p>

                                <div className="mt-8 grid gap-8">
                                    <CustomStyleDropdown
                                        label="Event Template"
                                        items={eventTemplates}
                                        selectedId={selectedTemplate}
                                        onSelect={setSelectedTemplate}
                                        renderPreview={(item) => <TemplatePreview item={item} />}
                                        renderOption={(item, isSelected) => (
                                            <>
                                                <TemplatePreview item={item} />

                                                <p className="mt-4 text-[20px] font-black">
                                                    {item.name}
                                                </p>

                                                <p
                                                    className={`mt-1 text-[16px] leading-[1.35] ${
                                                        isSelected ? 'text-white/80' : 'text-[#9b7445]'
                                                    }`}
                                                >
                                                    {item.description}
                                                </p>
                                            </>
                                        )}
                                    />

                                    <CustomStyleDropdown
                                        label="Photo Border"
                                        items={photoFrames}
                                        selectedId={selectedFrame}
                                        onSelect={setSelectedFrame}
                                        renderPreview={(item) => <FramePreview item={item} />}
                                        renderOption={(item, isSelected) => (
                                            <>
                                                <FramePreview item={item} />

                                                <p className="mt-4 text-[20px] font-black">
                                                    {item.name}
                                                </p>

                                                <p
                                                    className={`mt-1 text-[16px] leading-[1.35] ${
                                                        isSelected ? 'text-white/80' : 'text-[#9b7445]'
                                                    }`}
                                                >
                                                    {item.description}
                                                </p>
                                            </>
                                        )}
                                    />

                                    <CustomStyleDropdown
                                        label="Font Style"
                                        items={fontStyles}
                                        selectedId={selectedFont}
                                        onSelect={setSelectedFont}
                                        renderPreview={(item) => <FontPreview item={item} />}
                                        renderOption={(item) => (
                                            <>
                                                <FontPreview item={item} />

                                                <p className="mt-4 text-[20px] font-black">
                                                    {item.name}
                                                </p>
                                            </>
                                        )}
                                    />
                                </div>
                            </section>

                            {error && (
                                <div className="rounded-[24px] border border-red-300 bg-red-50 p-5 text-[18px] text-red-700">
                                    {error}
                                </div>
                            )}

                            <button
                                type="submit"
                                disabled={loading}
                                className="h-[72px] w-full rounded-full bg-[#704500] px-8 text-[22px] font-normal text-white transition hover:bg-[#583600] disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                {loading ? 'Creating...' : 'Create Event'}
                            </button>
                        </form>

                        <aside className="space-y-8">
                            <div className="sticky top-[150px] space-y-8">
                                <section className="rounded-[34px] bg-[#927a67] p-8 text-white">
                                    <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[48px] font-normal leading-[0.95]">
                                        Live Preview
                                    </h2>

                                    <div className={`mt-8 overflow-hidden rounded-[30px] border ${template.pageClass}`}>
                                        <div className="p-5">
                                            <div className={`rounded-[24px] border p-5 ${template.cardClass}`}>
                                                <p className={`text-xs font-black uppercase tracking-[0.25em] ${template.accentTextClass}`}>
                                                    Core Memoir
                                                </p>

                                                <h3 className={`mt-4 text-3xl ${font.className}`}>
                                                    {name || 'Your Event Name'}
                                                </h3>

                                                <p className={`mt-2 text-sm ${template.mutedTextClass}`}>
                                                    {formatEventDate(eventDate)}
                                                </p>

                                                <p className={`mt-4 text-sm ${template.mutedTextClass}`}>
                                                    {caption || 'Your event caption or description will appear here.'}
                                                </p>

                                                <div className="mt-5 grid grid-cols-2 gap-3">
                                                    <div className={frame.className}>
                                                        <div className={`aspect-square bg-gradient-to-br from-slate-300 to-slate-500 ${frame.imageClass}`} />
                                                    </div>

                                                    <div className={frame.className}>
                                                        <div className={`aspect-square bg-gradient-to-br from-pink-300 to-purple-500 ${frame.imageClass}`} />
                                                    </div>
                                                </div>

                                                <button
                                                    type="button"
                                                    className={`mt-5 w-full rounded-xl px-4 py-3 text-sm font-black ${template.buttonClass}`}
                                                >
                                                    Upload Photo
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section className="rounded-[34px] bg-[#efe8df] p-8 text-[#704500]">
                                    <h2 className="[font-family:Georgia,'Times_New_Roman',serif] text-[48px] font-normal leading-[0.95] text-black">
                                        Guest Link
                                    </h2>

                                    {!createdEvent && (
                                        <p className="mt-5 text-[19px] leading-[1.4] text-[#9b7445]">
                                            After creating an event, the guest link will appear here.
                                        </p>
                                    )}

                                    {createdEvent && (
                                        <div className="mt-6 space-y-5">
                                            <div className="rounded-[24px] bg-[#f8f3ee] p-5">
                                                <p className="text-[16px] font-black text-[#704500]">
                                                    Event Created Successfully
                                                </p>

                                                <h3 className="mt-2 text-[25px] font-black text-[#704500]">
                                                    {createdEvent.event.name}
                                                </h3>
                                            </div>

                                            <div>
                                                <p className="text-[17px] font-black text-[#704500]">
                                                    Share this link with guests
                                                </p>

                                                <input
                                                    readOnly
                                                    value={createdEvent.guest_link}
                                                    className="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[16px] text-[#704500] outline-none"
                                                />
                                            </div>

                                            <button
                                                type="button"
                                                onClick={copyLink}
                                                className="h-[60px] w-full rounded-full bg-[#704500] px-6 text-[18px] text-white hover:bg-[#583600]"
                                            >
                                                Copy Guest Link
                                            </button>

                                            <a
                                                href={createdEvent.guest_link}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="flex h-[60px] w-full items-center justify-center rounded-full bg-[#e8dbcf] px-6 text-[18px] text-[#704500] hover:bg-[#d9c8b8]"
                                            >
                                                Open Guest Page
                                            </a>
                                        </div>
                                    )}
                                </section>
                            </div>
                        </aside>
                    </div>
                </div>
            </main>
        </div>
    );
}

function GuestEventPage() {
    const eventCode = useMemo(() => {
        return window.location.pathname.split('/e/')[1];
    }, []);

    const albumInputRef = useRef(null);
    const cameraInputRef = useRef(null);

    const [event, setEvent] = useState(null);
    const [photos, setPhotos] = useState([]);
    const [guestName, setGuestName] = useState('');
    const [photo, setPhoto] = useState(null);
    const [preview, setPreview] = useState('');
    const [loading, setLoading] = useState(true);
    const [uploading, setUploading] = useState(false);
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');

    async function loadEvent() {
        setLoading(true);
        setError('');

        try {
            const response = await fetch(`/event-data/${eventCode}`, {
                headers: {
                    Accept: 'application/json',
                },
            });

            const data = await readJsonResponse(response);

            if (!response.ok) {
                throw new Error(data.message || 'Event not found.');
            }

            setEvent(data.event);
            setPhotos(data.photos || []);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        loadEvent();
    }, []);

    function handlePhotoChange(e) {
        const file = e.target.files[0];

        setPhoto(file || null);
        setSuccess('');
        setError('');

        if (file) {
            setPreview(URL.createObjectURL(file));
        } else {
            setPreview('');
        }
    }

    async function uploadPhoto(e) {
        e.preventDefault();

        if (!photo) {
            setError('Please take or choose a photo first.');
            return;
        }

        setUploading(true);
        setError('');
        setSuccess('');

        const formData = new FormData();
        formData.append('photo', photo);
        formData.append('guest_name', guestName);

        try {
            const response = await fetch(`/e/${eventCode}/photos`, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: formData,
            });

            const data = await readJsonResponse(response);

            if (!response.ok) {
                throw new Error(data.message || 'Upload failed.');
            }

            setPhotos((current) => [data.photo, ...current]);
            setPhoto(null);
            setPreview('');
            setGuestName('');
            setSuccess('Photo uploaded successfully!');

            if (albumInputRef.current) albumInputRef.current.value = '';
            if (cameraInputRef.current) cameraInputRef.current.value = '';
        } catch (err) {
            setError(err.message);
        } finally {
            setUploading(false);
        }
    }

    if (loading) {
        return (
            <div className="flex min-h-screen items-center justify-center bg-[#f8f3ee] text-[#704500]">
                <p className="text-[20px] font-black">Loading event...</p>
            </div>
        );
    }

    if (error && !event) {
        return (
            <div className="flex min-h-screen items-center justify-center bg-[#f8f3ee] px-4 text-[#704500]">
                <div className="max-w-md rounded-[34px] bg-[#efe8df] p-8 text-center">
                    <h1 className="[font-family:Georgia,'Times_New_Roman',serif] text-[46px] text-black">
                        Event Not Found
                    </h1>

                    <p className="mt-4 text-[18px] text-[#9b7445]">
                        {error}
                    </p>

                    <a
                        href="/"
                        className="mt-8 inline-flex h-[58px] items-center justify-center rounded-full bg-[#704500] px-8 text-[18px] text-white"
                    >
                        Back Home
                    </a>
                </div>
            </div>
        );
    }

    const frame = findFrame(event?.photo_frame || 'polaroid');
    const font = findFont(event?.font_style || 'modern');

    const uploadedCount = photos.length;
    const limit = event?.photo_limit || 0;
    const remaining = Math.max(limit - uploadedCount, 0);

    const revealDate = event?.reveal_at ? new Date(event.reveal_at) : null;
    const albumUnlocked = !revealDate || new Date() >= revealDate;
    const revealText = formatRevealDate(event?.reveal_at);

    return (
        <div className="min-h-screen bg-[#f8f3ee] text-[#2d1a00] [font-family:Arial,Helvetica,sans-serif]">
            <header className="sticky left-0 top-0 z-50 w-full bg-[#f4ede5]">
                <div className="mx-auto flex h-[100px] max-w-[1720px] items-center justify-between px-[6vw]">
                    <a href="/" className="flex items-center gap-4">
                        <img
                            src="/images/core-memoir-logo.png"
                            alt="Core Memoir logo"
                            className="h-[50px] w-auto object-contain"
                        />

                        <span className="[font-family:Georgia,'Times_New_Roman',serif] text-[28px] font-normal uppercase tracking-[0.02em] text-[#8b6f58]">
                            CORE MEMOIR
                        </span>
                    </a>
                </div>
            </header>

            <main className="px-[4vw] py-10 md:py-16">
                <div className="mx-auto max-w-[980px]">
                    <section className="rounded-[34px] bg-[#927a67] p-8 text-white md:p-10">
                        <p className="text-[14px] font-black uppercase tracking-[0.28em] text-white/80">
                            Event Camera
                        </p>

                        <h1 className={`mt-4 [font-family:Georgia,'Times_New_Roman',serif] text-[54px] font-normal leading-[0.95] md:text-[76px] ${font.className}`}>
                            {event.name}
                        </h1>

                        <p className="mt-4 text-[20px] font-black text-white/90">
                            {formatEventDate(event.event_date)}
                        </p>

                        {event.caption && (
                            <p className="mt-5 max-w-2xl text-[20px] leading-[1.4] text-white/85">
                                {event.caption}
                            </p>
                        )}

                        <div className="mt-8 grid gap-4 sm:grid-cols-3">
                            <div className="rounded-[24px] bg-white/15 p-5">
                                <p className="text-[12px] font-black uppercase tracking-[0.15em] text-white/70">
                                    Uploaded
                                </p>
                                <p className="mt-2 text-[32px] font-black">
                                    {uploadedCount}
                                </p>
                            </div>

                            <div className="rounded-[24px] bg-white/15 p-5">
                                <p className="text-[12px] font-black uppercase tracking-[0.15em] text-white/70">
                                    Limit
                                </p>
                                <p className="mt-2 text-[32px] font-black">
                                    {limit}
                                </p>
                            </div>

                            <div className="rounded-[24px] bg-white/15 p-5">
                                <p className="text-[12px] font-black uppercase tracking-[0.15em] text-white/70">
                                    Remaining
                                </p>
                                <p className="mt-2 text-[32px] font-black">
                                    {remaining}
                                </p>
                            </div>
                        </div>
                    </section>

                    <section className="mt-8 rounded-[34px] bg-[#efe8df] p-8 md:p-10">
                        <div className="h-[2px] w-[70px] bg-[#9b7445]" />

                        <h2 className="mt-8 [font-family:Georgia,'Times_New_Roman',serif] text-[48px] font-normal leading-[0.95] text-black md:text-[64px]">
                            Capture a Memory
                        </h2>

                        <p className="mt-4 text-[20px] leading-[1.4] text-[#9b7445]">
                            Take a photo using your camera or upload one from your device.
                        </p>

                        <form onSubmit={uploadPhoto} className="mt-8">
                            <label className="text-[18px] font-black text-[#704500]">
                                Your Name
                            </label>

                            <input
                                type="text"
                                value={guestName}
                                onChange={(e) => setGuestName(e.target.value)}
                                placeholder="Optional"
                                className="mt-3 h-[58px] w-full rounded-full border border-[#d8cabe] bg-[#f8f3ee] px-6 text-[18px] text-[#704500] outline-none placeholder:text-[#9b7445]/60 focus:border-[#704500]"
                            />

                            <input
                                ref={cameraInputRef}
                                type="file"
                                accept="image/*"
                                capture="environment"
                                onChange={handlePhotoChange}
                                className="hidden"
                            />

                            <input
                                ref={albumInputRef}
                                type="file"
                                accept="image/*"
                                onChange={handlePhotoChange}
                                className="hidden"
                            />

                            <div className="mt-8 grid gap-4 sm:grid-cols-2">
                                <button
                                    type="button"
                                    onClick={() => cameraInputRef.current?.click()}
                                    disabled={remaining <= 0}
                                    className="flex min-h-[130px] flex-col items-center justify-center rounded-[30px] bg-[#704500] px-6 text-white transition hover:bg-[#583600] disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    <span className="text-[38px]">📷</span>
                                    <span className="mt-3 text-[22px] font-black">
                                        Camera
                                    </span>
                                    <span className="mt-1 text-[15px] text-white/75">
                                        Take a photo now
                                    </span>
                                </button>

                                <button
                                    type="button"
                                    onClick={() => albumInputRef.current?.click()}
                                    disabled={remaining <= 0}
                                    className="flex min-h-[130px] flex-col items-center justify-center rounded-[30px] bg-[#e8dbcf] px-6 text-[#704500] transition hover:bg-[#d9c8b8] disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    <span className="text-[38px]">🖼️</span>
                                    <span className="mt-3 text-[22px] font-black">
                                        Upload Photo
                                    </span>
                                    <span className="mt-1 text-[15px] text-[#9b7445]">
                                        Choose from device
                                    </span>
                                </button>
                            </div>

                            {preview && (
                                <div className="mt-8 rounded-[30px] bg-[#f8f3ee] p-5">
                                    <p className="mb-4 text-[18px] font-black text-[#704500]">
                                        Preview
                                    </p>

                                    <div className="flex justify-center">
                                        <div className={frame.className}>
                                            <img
                                                src={preview}
                                                alt="Preview"
                                                className={`max-h-[420px] w-full object-contain ${frame.imageClass}`}
                                            />
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        disabled={uploading || remaining <= 0}
                                        className="mt-6 h-[64px] w-full rounded-full bg-[#704500] px-8 text-[20px] font-black text-white transition hover:bg-[#583600] disabled:cursor-not-allowed disabled:opacity-60"
                                    >
                                        {remaining <= 0
                                            ? 'Photo Limit Reached'
                                            : uploading
                                                ? 'Uploading...'
                                                : 'Submit Photo'}
                                    </button>
                                </div>
                            )}

                            {error && (
                                <div className="mt-6 rounded-[24px] border border-red-300 bg-red-50 p-5 text-[18px] text-red-700">
                                    {error}
                                </div>
                            )}

                            {success && (
                                <div className="mt-6 rounded-[24px] border border-green-300 bg-green-50 p-5 text-[18px] text-green-700">
                                    {success}
                                </div>
                            )}
                        </form>
                    </section>

                    <section className="mt-8 rounded-[34px] bg-[#efe8df] p-8 md:p-10">
                        <div className="h-[2px] w-[70px] bg-[#9b7445]" />

                        <h2 className="mt-8 [font-family:Georgia,'Times_New_Roman',serif] text-[48px] font-normal leading-[0.95] text-black md:text-[64px]">
                            Album
                        </h2>

                        {!albumUnlocked && (
                            <div className="mt-8 rounded-[30px] bg-[#927a67] p-8 text-white">
                                <p className="text-[44px] leading-none">🔒</p>

                                <h3 className="mt-5 text-[28px] font-black">
                                    Album Locked
                                </h3>

                                <p className="mt-3 max-w-xl text-[19px] leading-[1.4] text-white/80">
                                    The event album will be available after the reveal date and time.
                                </p>

                                <p className="mt-4 text-[18px] font-black text-white">
                                    Reveal: {revealText}
                                </p>

                                <button
                                    type="button"
                                    disabled
                                    className="mt-6 h-[62px] w-full rounded-full bg-white/20 px-8 text-[18px] font-black text-white/60"
                                >
                                    Album Locked
                                </button>
                            </div>
                        )}

                        {albumUnlocked && (
                            <>
                                <a
                                    href="#event-album"
                                    className="mt-8 inline-flex h-[64px] w-full items-center justify-center rounded-full bg-[#704500] px-8 text-[20px] font-black text-white transition hover:bg-[#583600]"
                                >
                                    Open Album
                                </a>

                                <div id="event-album" className="mt-8">
                                    {photos.length === 0 && (
                                        <p className="text-[19px] text-[#9b7445]">
                                            No photos uploaded yet.
                                        </p>
                                    )}

                                    {photos.length > 0 && (
                                        <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                                            {photos.map((item) => (
                                                <div key={item.id}>
                                                    <div className={frame.className}>
                                                        <img
                                                            src={item.image_url}
                                                            alt="Event upload"
                                                            className={`aspect-square w-full object-cover ${frame.imageClass}`}
                                                        />

                                                        {frame.id === 'polaroid' && (
                                                            <p className="mt-3 truncate text-center text-sm font-bold text-slate-700">
                                                                {item.guest_name || 'Guest'}
                                                            </p>
                                                        )}
                                                    </div>

                                                    {frame.id !== 'polaroid' && (
                                                        <p className="mt-2 truncate text-sm font-bold text-[#704500]">
                                                            {item.guest_name || 'Guest'}
                                                        </p>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    )}
                                </div>
                            </>
                        )}
                    </section>
                </div>
            </main>
        </div>
    );
}

createRoot(document.getElementById('app')).render(<App />);