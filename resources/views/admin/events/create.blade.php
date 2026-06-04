@extends('layouts.app', ['title' => 'Create Event'])

@section('content')

<h1>Create Event</h1>

<form action="{{ route('admin.events.store') }}"
      method="POST"
      style="
      background:white;
      padding:30px;
      border-radius:15px;
      max-width:700px;
      ">

    @csrf

    <div style="margin-bottom:20px;">
        <label>Event Title</label>
        <input type="text"
               name="title"
               required
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
        <label>Email Subject</label>
        <input type="text"
               name="email_subject"
               required
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
        <label>Description</label>
        <textarea name="description"
                  rows="5"
                  required
                  style="width:100%;padding:10px;"></textarea>
    </div>

    <div style="margin-bottom:20px;">
        <label>Discount Code</label>
        <input type="text"
               name="discount_code"
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
        <label>Start Date</label>
        <input type="datetime-local"
               name="start_date"
               required
               style="width:100%;padding:10px;">
    </div>

    <div style="margin-bottom:20px;">
        <label>End Date</label>
        <input type="datetime-local"
               name="end_date"
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
        Save Event
    </button>

</form>

@endsection