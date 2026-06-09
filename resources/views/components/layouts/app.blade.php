@props([
    'title' => 'Core Memoir',
    'guest' => false,
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#f8f3ee] text-[#2d1a00]" style="font-family: Arial, Helvetica, sans-serif;">
    <header style="background:#f4ede5; width:100%; border-bottom:1px solid #d8cabe;">
        <style>
            .cm-navbar {
                max-width: 1050px;
                min-height: 118px;
                margin: 0 auto;
                padding: 0 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 40px;
            }

            .cm-navbar.guest-only {
                justify-content: center;
            }

            .cm-brand {
                display: flex;
                align-items: center;
                gap: 18px;
                text-decoration: none;
                flex-shrink: 0;
            }

            .cm-logo {
                height: 48px;
                width: auto;
                object-fit: contain;
            }

            .cm-brand-text {
                font-family: Georgia, 'Times New Roman', serif;
                font-size: 31px;
                font-weight: 400;
                letter-spacing: -0.02em;
                color: #8b6f58;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .cm-nav-links {
                display: flex;
                align-items: center;
                gap: 68px;
                color: #8b6f58;
                font-size: 19px;
                white-space: nowrap;
            }

            .cm-nav-links a {
                color: #8b6f58;
                text-decoration: none;
            }

            .cm-nav-links a.active {
                text-decoration: underline;
                text-underline-offset: 4px;
            }

            @media (max-width: 900px) {
                .cm-navbar {
                    max-width: 100%;
                    min-height: auto;
                    padding: 18px 18px 16px;
                    flex-direction: column;
                    justify-content: center;
                    gap: 16px;
                }

                .cm-logo {
                    height: 42px;
                }

                .cm-brand-text {
                    font-size: 24px;
                }

                .cm-nav-links {
                    width: 100%;
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 10px;
                    font-size: 15px;
                    text-align: center;
                    white-space: normal;
                }

                .cm-nav-links a {
                    border: 1px solid #d8cabe;
                    border-radius: 999px;
                    padding: 10px 12px;
                    background: #f8f3ee;
                }

                .cm-nav-links a.active {
                    background: #704500;
                    color: white;
                    text-decoration: none;
                    border-color: #704500;
                }
            }

            @media (max-width: 420px) {
                .cm-logo {
                    height: 36px;
                }

                .cm-brand-text {
                    font-size: 20px;
                }
            }
        </style>

        <div class="cm-navbar {{ $guest ? 'guest-only' : '' }}">
            <a href="/" class="cm-brand">
                <img
                    src="/images/core-memoir-logo.png"
                    alt="Core Memoir logo"
                    class="cm-logo"
                >

                <span class="cm-brand-text">
                    CORE MEMOIR
                </span>
            </a>

            @unless ($guest)
                <nav class="cm-nav-links">
                    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                    <a href="/#how">How It Works</a>
                    <a href="/#gallery">Public Gallery</a>
                    <a href="/#contact">Contact Us</a>
                </nav>
            @endunless
        </div>
    </header>

    {{ $slot }}
</body>
</html>