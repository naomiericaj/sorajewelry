<h1>{{ $event->title }}</h1>

<p>{{ $event->description }}</p>

@if($event->discount_code)
<p>
    Discount Code:
    <strong>{{ $event->discount_code }}</strong>
</p>
@endif

<p>
Thank you for choosing SORA Jewelry.
</p>