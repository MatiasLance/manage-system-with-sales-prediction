<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sunny Meadows | Golden Goats in Green Hills</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display+SC:wght@400;700&family=Quicksand:wght@400;500;600&family=Caveat:wght@500;600&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- AOS - Animate On Scroll -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    :root {
      --green-forest: #4A7C59;
      --gold: #E3B04B;
      --cream: #FAF3E0;
      --charcoal: #333333;
      --white: #FFFFFF;
    }

    body {
      font-family: 'Quicksand', sans-serif;
      color: var(--charcoal);
      background-color: var(--cream);
      margin: 0;
      line-height: 1.8;
    }

    h1, h2, h3, h4, h5 {
      font-family: 'Playfair Display SC', serif;
      color: var(--green-forest);
      font-weight: 600;
      letter-spacing: -0.02em;
    }

    .goat-name {
      font-family: 'Caveat', cursive;
      font-weight: 600;
      font-size: clamp(1.2rem, 4vw, 1.4rem);
      color: var(--gold);
    }

    /* === Hero === */
    .hero {
      min-height: 100vh;
      height: auto;
      background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5)),
                        url('https://i.imgur.com/9AMFYVI.jpeg');
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      color: white;
      text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
    }

    .hero h1 {
      font-size: clamp(2.5rem, 8vw, 4.5rem);
      line-height: 1.2;
    }

    .hero p {
      font-size: clamp(1rem, 6vw, 1.3rem);
      max-width: 100%;
    }

    /* === Navbar === */
    .navbar {
      background: rgba(74, 124, 89, 0.95);
      backdrop-filter: blur(10px);
      transition: all 0.4s ease;
      padding: 1rem 0;
    }

    .navbar.scrolled {
      padding: 0.7rem 0;
    }

    .navbar-brand {
      font-family: 'Playfair Display SC', serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--white);
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.85) !important;
      margin: 0 12px;
      font-weight: 500;
      position: relative;
      font-family: 'Quicksand', sans-serif;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--gold);
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    /* === Button – Golden === */
    .btn-gold {
      background: var(--gold);
      color: var(--charcoal);
      border: none;
      padding: 14px 36px;
      font-weight: 600;
      letter-spacing: 0.05em;
      border-radius: 0;
      transition: all 0.4s ease;
    }

    .btn-gold:hover {
      background: #f0c050;
      transform: translateY(-3px);
    }

    /* === Sections === */
    section {
      padding: 100px 0;
      scroll-margin-top: 90px; /* Prevents navbar from hiding section titles */
    }

    /* === About === */
    #about {
      background: var(--white);
    }

    .about-img-wrapper {
      border: 4px solid var(--green-forest);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 15px 30px rgba(74, 124, 89, 0.1);
      margin-top: 20px;
    }

    .about-img {
      width: 100%;
      height: auto;
      max-height: 450px;
      object-fit: cover;
    }

    .about-text {
      color: #555;
      font-size: clamp(1rem, 4.5vw, 1.15rem);
      line-height: 1.8;
    }

    /* === News === */
    #news {
      background: var(--cream);
    }

    .news-item {
      margin-bottom: 40px;
    }

    .news-date {
      color: var(--green-forest);
      font-weight: 600;
      font-size: 0.9rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }

    /* === Booking === */
    #book {
      background: var(--white);
      max-width: 900px;
      margin: 60px auto;
      padding: 60px 20px;
      border-top: 5px solid var(--green-forest);
      border-radius: 8px;
    }

    .form-control {
      border: none;
      border-bottom: 2px solid #ddd;
      border-radius: 0;
      padding: 12px 0;
      font-size: 1.1rem;
      min-height: 48px; /* Better tap target on mobile */
    }

    .form-control:focus {
      border-color: var(--green-forest);
      box-shadow: none;
    }

    .form-label {
      color: var(--green-forest);
      font-weight: 600;
    }

    /* === Footer === */
    footer {
      background: var(--green-forest);
      color: var(--white);
      padding: 80px 0 40px;
    }

    footer a {
      color: var(--gold);
      text-decoration: none;
    }

    footer a:hover {
      color: var(--white);
      text-decoration: underline;
    }

    .footer-signature {
      font-family: 'Caveat', cursive;
      font-size: 1.3rem;
      color: var(--gold);
    }

    /* === Custom Animation for Goat === */
    @keyframes bounceSlow {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .floating-goat {
      display: inline-block;
      animation: bounceSlow 2.5s ease-in-out infinite;
    }

    /* === Container Padding Fix === */
    .container {
      padding-left: 15px;
      padding-right: 15px;
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">SUNNY MEADOWS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#news">Journal</a></li>
          <li class="nav-item"><a class="nav-link" href="#book">Visit</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero d-flex align-items-center">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
      <h1>Where <span class="goat-name">Golden Goats</span><br>Roam Green Hills</h1>
      <p class="lead">A small farm rooted in care, sunshine, and slow living.</p>
      <a href="#book" class="btn btn-gold mt-4">Plan Your Visit <span class="floating-goat">🐐</span></a>
    </div>
  </section>

  <!-- About -->
  <section id="about" class="container">
    <div class="row align-items-center g-5">
      <div class="col-md-7" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
        <h2>In Harmony with Nature</h2>
        <p class="about-text">
          At Sunny Meadows, we believe farming should be gentle.  
          Our goats graze freely on lush pastures, nurtured by rain and sunlight.
        </p>
        <p class="about-text mt-3">
          We make small-batch goat cheese, host weekend tours,  
          and welcome families to connect with the land — and with joy.
        </p>
        <p class="about-text mt-3" style="font-style: italic;">
          “The goats aren’t just animals — they’re <span class="goat-name">family</span>.” – Clara, Founder
        </p>
      </div>
      <div class="col-md-5" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
        <div class="about-img-wrapper">
          <img src="https://i.imgur.com/9AMFYVI.jpeg" alt="Goat in green field" class="about-img">
        </div>
      </div>
    </div>
  </section>

  <!-- News -->
  <section id="news" class="container">
    <div data-aos="fade-up" data-aos-duration="800">
      <h2 class="text-center mb-5" style="color: var(--green-forest);">From the Farm Journal</h2>
    </div>
    <div class="news-item" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
      <div class="row">
        <div class="col-12">
          <span class="news-date">Apr 5, 2025</span>
          <h3>Meet <span class="goat-name">Buttercup</span>!</h3>
          <p>Our newest kid arrived at dawn — full of hops, curiosity, and mischief.</p>
        </div>
      </div>
    </div>
    <div class="news-item" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
      <div class="row">
        <div class="col-12">
          <span class="news-date">Mar 28, 2025</span>
          <h3>Spring Cheese Batch Ready</h3>
          <p>Lavender-infused goat cheese, made with flowers from our west field. Available every Saturday.</p>
        </div>
      </div>
    </div>
    <div class="news-item" data-aos="fade-up" data-aos-duration="700" data-aos-delay="300">
      <div class="row">
        <div class="col-12">
          <span class="news-date">Mar 15, 2025</span>
          <h3>School Tours Open</h3>
          <p>Hands-on learning: milking, feeding, and understanding where food comes from.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Booking -->
  <section id="book">
    <div class="container" data-aos="fade-in" data-aos-duration="800">
      <div class="text-center mb-5">
        <h2>Come Say Hello</h2>
        <p class="lead" style="color: #555;">Open weekends. Reserve your visit below.</p>
      </div>
      <form>
        <div class="row g-4">
          <div class="col-md-6" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="100">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="col-md-6" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="200">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" required>
          </div>
          <div class="col-md-6" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="300">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" required>
          </div>
          <div class="col-md-6" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="400">
            <label class="form-label">Guests</label>
            <input type="number" class="form-control" min="1" value="1">
          </div>
          <div class="col-12 text-center" data-aos="fade-up" data-aos-duration="700" data-aos-delay="500">
            <button type="submit" class="btn btn-gold btn-lg">Request Your Visit</button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>Visit</h5>
          <p>123 Green Pasture Lane<br>Vermont, USA</p>
        </div>
        <div class="col-md-3">
          <h5>Contact</h5>
          <p>
            <a href="mailto:hello@sunymeadows.com">hello@sunymeadows.com</a><br>
            (555) 123-GOAT
          </p>
        </div>
        <div class="col-md-3">
          <h5>Hours</h5>
          <p>Sat–Sun: 10am–4pm<br>Tours by reservation</p>
        </div>
        <div class="col-md-3">
          <h5>Follow</h5>
          <p>
            <a href="#">Instagram</a> · <a href="#">Journal</a>
          </p>
          <p class="footer-signature">— Clara & Tom</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS Library -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      AOS.init({
        offset: 120,
        duration: 800,
        easing: 'ease-in-out',
        delay: 100,
        once: false
      });

      window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      });
    });
  </script>
</body>
</html>