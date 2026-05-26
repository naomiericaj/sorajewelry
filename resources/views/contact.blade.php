@extends('layouts.app', ['title' => 'Contact - Sora Jewelry'])

@section('styles')
<style>
    .contact-page {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: calc(100vh - 70px);
    }

    .contact-left {
        padding: 70px;
        background: #f8f8f6;
    }

    .contact-right {
        background: #a7ad98;
        color: white;
        padding: 70px;
        display: flex;
        align-items: center;
    }

    .contact-title {
        font-family: Georgia, serif;
        font-size: 42px;
        font-weight: 400;
        margin-bottom: 20px;
    }

    .contact-text {
        color: #555;
        line-height: 1.8;
        max-width: 520px;
        margin-bottom: 35px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-control {
        width: 100%;
        height: 56px;
        border: 1px solid #d8d8d4;
        background: transparent;
        padding: 0 16px;
        font-size: 15px;
    }

    textarea.form-control {
        height: 140px;
        padding: 16px;
        resize: vertical;
    }

    .btn {
        width: 100%;
        height: 56px;
        background: #111;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 15px;
    }

    .info-block {
        margin-bottom: 35px;
    }

    .info-block h3 {
        font-family: Georgia, serif;
        font-size: 26px;
        margin-bottom: 10px;
    }

    .info-block p {
        line-height: 1.8;
        opacity: .9;
    }

    @media (max-width: 900px) {
        .contact-page {
            grid-template-columns: 1fr;
        }

        .contact-left,
        .contact-right {
            padding: 35px 22px;
        }
    }
</style>
@endsection

@section('content')

<section class="contact-page">
    <div class="contact-left">
        <h1 class="contact-title">Contact Us</h1>

        <p class="contact-text">
            Have a question about your order, product availability, sizing, or jewelry care?
            Send us a message and our team will get back to you soon.
        </p>

        <form action="#" method="POST">
            @csrf

            <div class="form-group">
                <input class="form-control" type="text" name="name" placeholder="Your name">
            </div>

            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email address">
            </div>

            <div class="form-group">
                <input class="form-control" type="text" name="subject" placeholder="Subject">
            </div>

            <div class="form-group">
                <textarea class="form-control" name="message" placeholder="Message"></textarea>
            </div>

            <button type="submit" class="btn">Send Message</button>
        </form>
    </div>

    <div class="contact-right">
        <div>
            <div class="info-block">
                <h3>Customer Care</h3>
                <p>
                    Email: hello@sorajewelry.com<br>
                    WhatsApp: +62 812 3456 7890<br>
                    Monday - Friday, 10:00 - 18:00
                </p>
            </div>

            <div class="info-block">
                <h3>Shipping</h3>
                <p>
                    We currently ship across Indonesia. Shipping fees are calculated during checkout.
                </p>
            </div>

            <div class="info-block">
                <h3>Returns</h3>
                <p>
                    Items can be returned within 7 days if unused and in original condition.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection