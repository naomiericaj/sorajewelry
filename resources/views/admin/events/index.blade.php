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
    + Create Event
</a>

@if(session('success'))
    <div style="
    background:#e8f7ec;
    color:#1c6b37;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    ">
        {{ session('success') }}
    </div>
@endif

<table style="
width:100%;
background:white;
border-collapse:collapse;
">

    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:15px;">Title</th>
            <th style="padding:15px;">Code</th>
            <th style="padding:15px;">Start Date</th>
            <th style="padding:15px;">Status</th>
            <th style="padding:15px;">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($events as $event)
            <tr>
                <td style="padding:15px;">
                    {{ $event->title }}
                </td>

                <td style="padding:15px;">
                    {{ $event->discount_code }}
                </td>

                <td style="padding:15px;">
                    {{ $event->start_date }}
                </td>

                <td style="padding:15px;">
                    @if($event->email_sent)
                        ✅ Sent
                    @else
                        ⏳ Pending
                    @endif
                </td>
                <td style="padding:15px;">

    <a href="{{ route('admin.events.edit', $event) }}"
       style="color:#b89b5e;text-decoration:none;">
        Edit
    </a>

    |

    <form action="{{ route('admin.events.destroy', $event) }}"
          method="POST"
          style="display:inline;">
        @csrf
        @method('DELETE')

        <button type="submit"
                onclick="return confirm('Delete this event?')"
                style="
                border:none;
                background:none;
                color:red;
                cursor:pointer;
                ">
            Delete
        </button>
    </form>

    |

    @if(!$event->email_sent)

        <form action="{{ route('admin.events.send', $event) }}"
              method="POST"
              style="display:inline;">
            @csrf

            <button type="submit"
                    style="
                    border:none;
                    background:none;
                    color:green;
                    cursor:pointer;
                    ">
                Send Now
            </button>
        </form>

    @endif

</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="padding:20px;">
                    No events found.
                </td>
            </tr>
        @endforelse
    </tbody>

</table>

@endsection