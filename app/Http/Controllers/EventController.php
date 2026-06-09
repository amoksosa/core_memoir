<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'photo_limit' => ['required', 'integer', 'min:1', 'max:500'],
            'guest_limit' => ['required', 'integer', 'min:1', 'max:1000'],
            'reveal_at' => ['nullable', 'date'],
            'template' => ['nullable', 'string', 'max:100'],
            'photo_frame' => ['nullable', 'string', 'max:100'],
            'font_style' => ['nullable', 'string', 'max:100'],
            'caption' => ['nullable', 'string', 'max:1000'],
        ]);

        $event = Event::create([
            'name' => $validated['name'],
            'code' => strtoupper(Str::random(8)),
            'event_date' => $validated['event_date'] ?? null,
            'photo_limit' => $validated['photo_limit'],
            'guest_limit' => $validated['guest_limit'],
            'reveal_at' => $validated['reveal_at'] ?? null,
            'is_active' => true,

            'theme' => $validated['template'] ?? 'wedding',
            'template' => $validated['template'] ?? 'wedding',
            'photo_frame' => $validated['photo_frame'] ?? 'polaroid',
            'font_style' => $validated['font_style'] ?? 'modern',
            'caption' => $validated['caption'] ?? null,

            'background_image' => null,
            'background_photographer' => null,
            'background_photographer_url' => null,
        ]);

        return redirect()
            ->route('events.guest', $event->code)
            ->with('success', 'Event created successfully.');
    }

    public function guestPage(Request $request, $code)
    {
        $event = Event::where('code', $code)->firstOrFail();

        $guestToken = $request->session()->get("event_guest_token_{$event->id}");

        if (!$guestToken) {
            if ($event->guests()->count() >= $event->guest_limit) {
                return view('guest-event-full', [
                    'event' => $event,
                ]);
            }

            $guestToken = (string) Str::uuid();

            EventGuest::create([
                'event_id' => $event->id,
                'guest_token' => $guestToken,
            ]);

            $request->session()->put("event_guest_token_{$event->id}", $guestToken);
        }

        $guest = EventGuest::where('event_id', $event->id)
            ->where('guest_token', $guestToken)
            ->first();

        if (!$guest) {
            if ($event->guests()->count() >= $event->guest_limit) {
                return view('guest-event-full', [
                    'event' => $event,
                ]);
            }

            $guest = EventGuest::create([
                'event_id' => $event->id,
                'guest_token' => $guestToken,
            ]);
        }

        $photos = $event->photos()
            ->latest()
            ->get();

        $guestPhotoCount = $event->photos()
            ->where('guest_token', $guestToken)
            ->count();

        return view('guest-event', [
            'event' => $event,
            'photos' => $photos,
            'guest' => $guest,
            'guestToken' => $guestToken,
            'guestPhotoCount' => $guestPhotoCount,
        ]);
    }

    public function albumPage($code)
    {
        $event = Event::where('code', $code)->firstOrFail();

        $photos = $event->photos()
            ->latest()
            ->get();

        return view('album-event', [
            'event' => $event,
            'photos' => $photos,
        ]);
    }

    public function uploadPhoto(Request $request, $code)
    {
        $event = Event::where('code', $code)->firstOrFail();

        $guestToken = $request->session()->get("event_guest_token_{$event->id}");

        if (!$guestToken) {
            return redirect()
                ->route('events.guest', $event->code)
                ->withErrors([
                    'photo' => 'Please access the event page first.',
                ]);
        }

        $guest = EventGuest::where('event_id', $event->id)
            ->where('guest_token', $guestToken)
            ->first();

        if (!$guest) {
            return redirect()
                ->route('events.guest', $event->code)
                ->withErrors([
                    'photo' => 'Guest access not found.',
                ]);
        }

        $request->validate([
            'photo' => ['required', 'image', 'max:5120'],
            'guest_name' => ['nullable', 'string', 'max:255'],
        ]);

        $guestPhotoCount = $event->photos()
            ->where('guest_token', $guestToken)
            ->count();

        if ($guestPhotoCount >= $event->photo_limit) {
            return back()->withErrors([
                'photo' => 'You have reached your photo limit for this event.',
            ]);
        }

        $path = $request->file('photo')->store('event-photos', 'public');

        $guest->update([
            'guest_name' => $request->guest_name ?: $guest->guest_name,
        ]);

        $event->photos()->create([
            'image_path' => $path,
            'guest_name' => $request->guest_name ?: $guest->guest_name,
            'guest_token' => $guestToken,
        ]);

        return back()->with('success', 'Photo uploaded successfully!');
    }
}