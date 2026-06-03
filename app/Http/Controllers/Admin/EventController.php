<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

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
}