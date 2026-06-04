<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Mail\EventNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'email_subject' => 'required|string|max:255',
            'description' => 'required',
            'discount_code' => 'nullable|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Event::create([
            ...$validated,
            'is_active' => true,
            'email_sent' => false,
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'email_subject' => 'required|string|max:255',
            'description' => 'required',
            'discount_code' => 'nullable|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function send(Event $event)
    {
        $users = User::where('role', 'customer')->get();

        foreach ($users as $user) {

            Mail::to($user->email)
                ->send(new EventNotificationMail($event));
        }

        $event->update([
            'email_sent' => true
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event emails sent successfully.');
    }
}