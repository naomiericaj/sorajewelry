@extends('layouts.app', ['title' => 'About & Contact - Sora Jewelry'])

@section('styles')
<style>

.about-section{
    padding:100px 80px;
    text-align:center;
    background:linear-gradient(
        135deg,
        #faf8f5,
        #f3ede2
    );
}

.about-title{
    font-family:Georgia, serif;
    font-size:58px;
    font-weight:400;
    margin-bottom:25px;

    animation:fadeUp 1s ease;
}

.about-text{
    max-width:850px;
    margin:0 auto;

    color:#555;
    line-height:2;
    font-size:17px;

    animation:fadeUp 1.5s ease;
}

.contact-quote{
    max-width:700px;
    margin:40px auto 0;

    color:#b89b5e;

    font-style:italic;
    font-size:22px;

    border-left:3px solid #b89b5e;

    padding-left:20px;
    text-align:left;

    animation:fadeUp 2s ease;
}


.contact-section{
    padding:100px 80px;
    background:white;
}

.section-heading{
    text-align:center;
    font-family:Georgia, serif;
    font-size:48px;
    font-weight:400;

    margin-bottom:15px;
}

.section-subheading{
    text-align:center;
    color:#666;

    max-width:650px;

    margin:0 auto 50px;

    line-height:1.8;
}

.contact-form{
    max-width:850px;
    margin:auto;
}

.form-group{
    margin-bottom:18px;
}

.form-control{
    width:100%;
    height:58px;

    border:1px solid #e5e5e5;
    border-radius:12px;

    padding:0 18px;

    font-size:15px;

    transition:.3s ease;
}

.form-control:focus{
    outline:none;

    border-color:#b89b5e;

    box-shadow:0 0 15px rgba(184,155,94,.15);
}

textarea.form-control{
    height:180px;
    padding:18px;
    resize:vertical;
}

.btn-send{
    width:100%;
    height:58px;

    border:none;
    border-radius:35px;

    background:#b89b5e;
    color:white;

    cursor:pointer;

    font-size:15px;
    letter-spacing:1px;

    transition:.3s ease;
}

.btn-send:hover{
    transform:translateY(-4px);

    background:#a58a4d;

    box-shadow:0 10px 20px rgba(0,0,0,.15);
}


.team-section{
    padding:100px 80px;

    background:linear-gradient(
        135deg,
        #faf8f5,
        #f3ede2
    );
}

.team-grid{
    margin-top:50px;

    display:grid;
    grid-template-columns:repeat(3,1fr);

    gap:30px;
}

.team-card{
    background:white;

    border-radius:24px;

    padding:40px 30px;

    text-align:center;

    box-shadow:0 8px 30px rgba(0,0,0,.08);

    transition:.3s ease;
}

.team-card:hover{
    transform:translateY(-8px);
}

.team-icon{
    font-size:45px;
    margin-bottom:20px;
}

.team-card h3{
    margin-bottom:12px;
    font-family:Georgia, serif;
}

.team-card p{
    color:#666;
    line-height:1.8;
}

  /* FOUNDER */
.founder-section{
    padding:100px 80px;
    background:white;
}

.founder-content{
    max-width:900px;
    margin:auto;
    text-align:center;
}

.founder-content p{
    line-height:2;
    color:#555;
    font-size:17px;
}

.founder-name{
    margin-top:35px;

    font-size:22px;
    color:#b89b5e;

    font-style:italic;
}

/* CUSTOMER CARE */

.care-section{
    padding:100px 80px;

    background:linear-gradient(
        135deg,
        #c8aa6e,
        #8f7442
    );

    color:white;
}

.care-grid{
    margin-top:50px;

    display:grid;
    grid-template-columns:repeat(4,1fr);

    gap:25px;
}

.care-card{
    background:rgba(255,255,255,.12);

    backdrop-filter:blur(10px);

    padding:30px;

    border-radius:20px;
}

.care-card h3{
    margin-bottom:15px;
}

.care-card p{
    line-height:1.8;
}
.care-card a {
    color: white;
    text-decoration: none;
    transition: 0.3s ease;
}

.care-card a:hover {
    color: #f5e7c1;
    text-decoration: underline;
}


@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(40px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* MOBILE */

@media(max-width:900px){

    .about-section,
    .contact-section,
    .team-section,
    .founder-section,
    .care-section{
        padding:70px 25px;
    }

    .team-grid,
    .care-grid{
        grid-template-columns:1fr;
    }

    .about-title{
        font-size:42px;
    }

    .section-heading{
        font-size:36px;
    }
}

</style>
@endsection

@section('content')


<section class="about-section">

    <h1 class="about-title">About Sora</h1>

    <p class="about-text">
        Sora Jewelry is a modern jewelry brand dedicated to creating timeless pieces
        that celebrate elegance, confidence, and individuality. Every collection is
        thoughtfully designed to complement everyday moments while remaining effortlessly
        sophisticated. We believe jewelry should not only elevate your style, but also
        become a meaningful part of your story.
    </p>

    <div class="contact-quote">
        "Jewelry is more than an accessory — it's a reflection of your story."
    </div>

</section>

<!-- CONTACT -->

<section class="contact-section">

    <h2 class="section-heading">Contact Us</h2>

    <p class="section-subheading">
        We'd love to hear from you. Whether you have questions about our collections,
        orders, shipping, or jewelry care, our team is here to help.
    </p>

    <form class="contact-form">

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Your Name">
        </div>

        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email Address">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Subject">
        </div>

        <div class="form-group">
            <textarea class="form-control" placeholder="Message"></textarea>
        </div>

        <button class="btn-send">
            Send Message
        </button>

    </form>

</section>

<!-- TEAM -->

<section class="team-section">

    <h2 class="section-heading">
        The People Behind This Masterpiece
    </h2>

    <p class="section-subheading">
        Every Sora collection is brought to life by passionate individuals who share
        the same vision of timeless elegance and meaningful craftsmanship.
    </p>

    <div class="team-grid">

        <div class="team-card">
            <div class="team-icon">✨</div>

            <h3>Creative Vision</h3>

            <p>
                Designing collections that blend modern sophistication with timeless beauty.
            </p>
        </div>

        <div class="team-card">
            <div class="team-icon">💍</div>

            <h3>Craftsmanship</h3>

            <p>
                Carefully creating pieces with attention to detail and quality.
            </p>
        </div>

        <div class="team-card">
            <div class="team-icon">🤍</div>

            <h3>Customer Experience</h3>

            <p>
                Making every interaction with Sora memorable and personal.
            </p>
        </div>

    </div>

</section>

<!-- FOUNDER -->

<section class="founder-section">

    <div class="founder-content">

        <h2 class="section-heading">Founder Story</h2>

        <p>
            Sora Jewelry was founded with a simple vision: to create jewelry that feels
            meaningful, effortless, and timeless. Inspired by modern women who embrace
            confidence and individuality, Sora was built to celebrate everyday elegance
            through carefully crafted pieces that can be worn and cherished for years.
        </p>

        <div class="founder-name">
            — SORA TEAM
        </div>

    </div>

</section>

<section class="care-section">

    <h2 class="section-heading">
        Customer Care
    </h2>

    <div class="care-grid">

        <div class="care-card">
    <h3>📧 Email</h3>
    <p>
        <a href="mailto:soraajewelry@gmail.com">
            soraajewelry@gmail.com
        </a>
    </p>
    </div>

        <div class="care-card">
            <h3>📱 WhatsApp</h3>
            <p>
        <a href="https://wa.me/628993790220" target="_blank">
            +62 899 379 0220
        </a>
             </p>
         </div>

        <div class="care-card">
            <h3>🚚 Shipping</h3>
            <p>Available across Indonesia.</p>
        </div>

        <div class="care-card">
            <h3>↩️ Returns</h3>
            <p>Returns accepted within 7 days.</p>
        </div>

    </div>

</section>

@endsection