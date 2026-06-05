<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $event->email_subject }}</title>
</head>

<body style="
margin:0;
padding:40px 20px;
background:#f8f8f6;
font-family:Arial, Helvetica, sans-serif;
">

<div style="
max-width:650px;
margin:auto;
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 8px 25px rgba(0,0,0,0.08);
">

```
<!-- Header -->
<div style="
background:#f5f5f3;
padding:40px 20px;
text-align:center;
">

    <img src="{{ asset('images/sora-logo (1).png') }}"
         alt="Sora Jewelry"
         style="
         max-width:220px;
         height:auto;
         ">

    <p style="
    margin-top:15px;
    color:#777;
    letter-spacing:2px;
    font-size:13px;
    ">
        MINIMAL JEWELRY FOR EVERYDAY ELEGANCE
    </p>

</div>

<!-- Content -->
<div style="padding:45px;">

    <h1 style="
    margin-top:0;
    text-align:center;
    color:#222;
    font-size:32px;
    ">
        {{ $event->title }}
    </h1>

    <p style="
    text-align:center;
    color:#666;
    line-height:1.9;
    font-size:16px;
    ">
        {{ $event->description }}
    </p>

    @if($event->discount_code)

    <div style="
    margin:35px 0;
    padding:25px;
    text-align:center;
    border:2px dashed #b89b5e;
    border-radius:15px;
    background:#fbf8f1;
    ">

        <p style="
        margin:0;
        color:#777;
        font-size:14px;
        ">
            Exclusive Discount Code
        </p>

        <h2 style="
        margin:12px 0 0;
        color:#b89b5e;
        letter-spacing:4px;
        font-size:32px;
        ">
            {{ $event->discount_code }}
        </h2>

    </div>

    @endif

    <div style="
    text-align:center;
    margin-top:40px;
    ">

        <a href="{{ url('/catalogue') }}"
           style="
           background:#111;
           color:white;
           text-decoration:none;
           padding:14px 34px;
           border-radius:10px;
           display:inline-block;
           font-size:15px;
           ">
            Explore Collection
        </a>

    </div>

</div>

<!-- Footer -->
<div style="
background:#fafafa;
border-top:1px solid #ececec;
padding:30px;
text-align:center;
">

    <p style="
    margin:0;
    color:#999;
    font-size:13px;
    line-height:1.8;
    ">
        Thank you for choosing Sora Jewelry.
        <br>
        Crafted with elegance, made for every moment.
    </p>

</div>
```

</div>

</body>
</html>
