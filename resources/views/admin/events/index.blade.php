@extends('layouts.app', ['title' => 'Manage Events'])

@section('content')

<h1 style="margin-bottom:30px;">Manage Events</h1>

<a href="{{ route('admin.events.create') }}"
style="
display:inline-block;
background:#111;
color:white;
padding:12px 24px;
border-radius:10px;
text-decoration:none;
margin-bottom:25px;
">
+ Create Event </a>

@if(session('success')) <div style="
 background:#e8f7ec;
 color:#1c6b37;
 padding:15px;
 border-radius:10px;
 margin-bottom:20px;
 ">
{{ session('success') }} </div>
@endif

<table style="
width:100%;
background:white;
border-collapse:collapse;
border-radius:16px;
overflow:hidden;
box-shadow:0 2px 12px rgba(0,0,0,0.05);
">

```
<thead>
    <tr style="
    background:#f8f8f8;
    border-bottom:1px solid #ececec;
    ">
        <th style="padding:18px;text-align:left;">Title</th>
        <th style="padding:18px;text-align:left;">Code</th>
        <th style="padding:18px;text-align:left;">Start Date</th>
        <th style="padding:18px;text-align:left;">Status</th>
        <th style="padding:18px;text-align:left;">Actions</th>
    </tr>
</thead>

<tbody>

    @forelse($events as $event)

        <tr style="border-bottom:1px solid #f0f0f0;">

            <td style="padding:18px;">
                {{ $event->title }}
            </td>

            <td style="padding:18px;">
                {{ $event->discount_code }}
            </td>

            <td style="padding:18px;">
                {{ $event->start_date }}
            </td>

            <td style="padding:18px;">

                @if($event->email_sent)

                    <span style="
                    background:#e8f7ec;
                    color:#1c6b37;
                    padding:6px 12px;
                    border-radius:20px;
                    font-size:13px;
                    font-weight:600;
                    ">
                        Sent
                    </span>

                @else

                    <span style="
                    background:#fff6db;
                    color:#b58105;
                    padding:6px 12px;
                    border-radius:20px;
                    font-size:13px;
                    font-weight:600;
                    ">
                        Pending
                    </span>

                @endif

            </td>

            <td style="padding:18px;">

                <div style="
                display:flex;
                gap:8px;
                flex-wrap:wrap;
                ">

                    <a href="{{ route('admin.events.edit', $event) }}"
                       style="
                       background:#f5f5f5;
                       color:#222;
                       padding:8px 14px;
                       border-radius:10px;
                       text-decoration:none;
                       font-size:14px;
                       font-weight:500;
                       ">
                        ✏️ Edit
                    </a>

                    <form action="{{ route('admin.events.destroy', $event) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Delete this event?')"
                                style="
                                background:#ffeaea;
                                color:#d11a2a;
                                border:none;
                                padding:8px 14px;
                                border-radius:10px;
                                cursor:pointer;
                                font-size:14px;
                                font-weight:500;
                                ">
                            🗑 Delete
                        </button>
                    </form>

                    @if(!$event->email_sent)

                        <form action="{{ route('admin.events.send', $event) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf

                            <button type="submit"
                                    style="
                                    background:#e8f7ec;
                                    color:#1c6b37;
                                    border:none;
                                    padding:8px 14px;
                                    border-radius:10px;
                                    cursor:pointer;
                                    font-size:14px;
                                    font-weight:500;
                                    ">
                                📧 Send Now
                            </button>
                        </form>

                    @endif

                </div>

            </td>

        </tr>

    @empty

        <tr>
            <td colspan="5"
                style="
                padding:25px;
                text-align:center;
                color:#777;
                ">
                No events found.
            </td>
        </tr>

    @endforelse

</tbody>
```

</table>

@endsection
