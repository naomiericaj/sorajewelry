@extends('layouts.app', ['title' => 'Edit Event'])

@section('content')

<h1>Edit Event</h1>

<form action="{{ route('admin.events.update', $event) }}"
      method="POST"
      style="
      background:white;
      padding:30px;
      border-radius:15px;
      max-width:700px;
      ">

    @csrf
    @method('PATCH')

    <div style="margin-bottom:20px;">
        <label>Event Title</label>
        <input type="text"
               name="title"
               value="{{ $event->title }}"
               required
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
        <label>Email Subject</label>
        <input type="text"
               name="email_subject"
               value="{{ $event->email_subject }}"
               required
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
        <label>Description</label>
        <textarea name="description"
                  rows="5"
                  required
                  style="width:100%;padding:10px;">{{ $event->description }}</textarea>
    </div>

    <div style="margin-bottom:20px;">
        <label>Discount Code</label>
        <input type="text"
               name="discount_code"
               value="{{ $event->discount_code }}"
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
    <label>Discount Percentage (%)</label>

    <input
        type="number"
        name="discount_percentage"
        min="1"
        max="100"
        value="{{ $event->discount_percentage }}"
        style="width:100%;padding:10px;">
</div>

    <div style="margin-bottom:20px;">
        <label>Start Date</label>
        <input type="datetime-local"
               name="start_date"
               value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') }}"
               required
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
        <label>End Date</label>
        <input type="datetime-local"
               name="end_date"
               value="{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '' }}"
               style="width:100%;padding:10px;">
    </div>

    <button type="submit"
            style="
            background:#111;
            color:white;
            border:none;
            padding:12px 25px;
            border-radius:10px;
            ">
        Update Event
    </button>

</form>

@endsection