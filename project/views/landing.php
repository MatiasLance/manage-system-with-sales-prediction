<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MBRLCFI | BOOKING</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display+SC:wght@400;700&family=Quicksand:wght@400;500;600&family=Caveat:wght@500;600&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- AOS - Animate On Scroll -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
      overflow-x: hidden;
    }

    h1, h2, h3, h4, h5 {
      font-family: 'Quicksand', sans-serif;
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
                        url('https://i.imgur.com/9GfrqMK.png');
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
      font-family: 'Quicksand', sans-serif;
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
      scroll-margin-top: 90px;
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

    /* === Booking — Full Width Enhanced === */
    .booking-hero {
      width: 100vw;
      position: relative;
      left: 50%;
      right: 50%;
      margin-left: -50vw;
      margin-right: -50vw;
      padding: 120px 0;
      background: linear-gradient(to bottom right, rgba(250, 243, 224, 0.9), rgba(255, 255, 255, 0.95));
      overflow-x: hidden;
    }

    .booking-bg-pattern {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      background-image: radial-gradient(circle at 80% 30%, rgba(74, 124, 89, 0.05) 0%, transparent 40%),
                        radial-gradient(circle at 20% 70%, rgba(227, 176, 75, 0.04) 0%, transparent 40%);
      pointer-events: none;
      opacity: 0.8;
    }

    .booking-container {
      max-width: 1400px;
      margin: 0 auto;
      padding-left: 15px;
      padding-right: 15px;
    }

    .booking-form-card {
      border-radius: 24px !important;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08),
                  0 10px 30px -10px rgba(74, 124, 89, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      padding: 40px;
      background-color: var(--cream);
      height: 100%;
    }

    .booking-form-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 30px 60px -10px rgba(0, 0, 0, 0.12),
                  0 15px 40px -12px rgba(74, 124, 89, 0.15);
    }

    /* .form-control {
      font-family: 'Quicksand', sans-serif;
      font-weight: 500;
      font-size: 1rem;
      transition: all 0.3s ease;
      border: none;
      border-bottom: 2px solid #eee;
      border-radius: 50px !important;
      padding: 14px 20px;
    } */

    .form-control:focus {
      border-color: transparent;
      box-shadow: 0 0 0 3px rgba(74, 124, 89, 0.25);
      outline: none;
    }

    .form-label {
      color: var(--green-forest);
      font-weight: 600;
      margin-bottom: 8px;
    }

    .btn-gold {
      background: var(--gold);
      color: var(--charcoal);
      border: none;
      padding: 14px 36px;
      font-weight: 600;
      letter-spacing: 0.05em;
      border-radius: 50px;
      transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      text-transform: uppercase;
      font-size: 1.1rem;
      width: 100%;
      max-width: 300px;
      margin: 0 auto;
    }

    .btn-gold:hover {
      background: #f0c050;
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(227, 176, 75, 0.3);
    }

    .letter-spacing-1 {
      letter-spacing: 0.1em;
    }

    .floating-goat {
      display: inline-block;
      animation: bounceSlow 3s ease-in-out infinite;
      font-size: 1.8rem;
      margin-left: 8px;
    }

    @keyframes bounceSlow {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    /* === Footer === */
    footer {
      background: var(--green-forest);
      color: var(--white);
      padding: 80px 80px 0 80px;
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

    /* === Container Padding Fix === */
    .container {
      padding-left: 15px;
      padding-right: 15px;
    }

    /* === Responsive Adjustments === */
    @media (max-width: 768px) {
      .booking-hero {
        padding: 80px 0;
      }

      .booking-form-card {
        padding: 30px 24px !important;
      }

      .btn-gold {
        font-size: 1rem;
        padding: 12px 30px;
      }

      .hero h1 {
        font-size: clamp(2rem, 6vw, 3.5rem);
      }

      .hero p {
        font-size: clamp(0.9rem, 5vw, 1.2rem);
      }
    }

    /* === Dark Mode Support === */
    @media (prefers-color-scheme: dark) {
      .hero {
        background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url('https://i.imgur.com/9GfrqMK.png');
      }

      .booking-hero {
        background: linear-gradient(to bottom right, rgba(20, 25, 30, 0.9), rgba(18, 24, 31, 0.95));
      }

      .booking-bg-pattern {
        background-image: radial-gradient(circle at 80% 30%, rgba(74, 124, 89, 0.08) 0%, transparent 40%),
                          radial-gradient(circle at 20% 70%, rgba(227, 176, 75, 0.06) 0%, transparent 40%);
      }

      .news-date, .lead, .text-muted {
        color: #d0d0d0 !important;
      }

      .about-text {
        color: #000;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">MBRLCFI</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#news">News</a></li>
          <li class="nav-item"><a class="nav-link" href="#book">Book</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero d-flex align-items-center">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
      <h1>Where <span class="goat-name">Golden Goats</span><br>Roam Green Hills</h1>
      <p class="lead">A small farm rooted in care, sunshine, and slow living.</p>
      <a href="#book" class="btn btn-gold mt-4">Book Now <span class="floating-goat">🐐</span></a>
    </div>
  </section>

  <!-- About -->
  <section id="about" class="container-fluid">
    <div class="row align-items-center g-5">
      <div class="col-md-7" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
        <h2>Mindanao Baptist Rural Life Center Foundation, Inc.</h2>
        <p class="about-text">
          The Mindanao Baptist Rural Life Center Foundation, Inc. (MBRLCFI)
          is a non-profit organization located in Kinuskusan, Bansalan, Davao del Sur, Philippines.
          Established with a vision to empower rural communities, MBRLCFI is dedicated 
          to promoting sustainable agriculture, rural development, and community
          transformation through faith-based values and innovative practices.
        </p>
        <p class="about-text mt-3" style="font-style: italic;">
          “I have come that you might have <span class="goat-name">life</span> and that you might have it more abundantly.” – John 10:10b
        </p>
      </div>
      <div class="col-md-5" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
        <div class="about-img-wrapper">
          <img src="https://i.imgur.com/9GfrqMK.png" alt="Goat in green field" class="about-img">
        </div>
      </div>
    </div>
  </section>

  <!-- News -->
  <section id="news" class="container-fluid">
    <div data-aos="fade-up" data-aos-duration="800">
      <h2 class="text-center mb-5" style="color: var(--green-forest);">News</h2>
    </div>
    <div class="d-flex flex-column flex-md-row-reverse flex-md-row align-items-center justify-content-between mb-3 gap-2">
        <nav class="mt-2 mt-md-0">
            <ul class="pagination mb-0 justify-content-center" id="news-pagination-links"></ul>
        </nav>
    </div>
    <div id="websiteNewsContainer"></div>
  </section>

  <!-- Booking — FULL WIDTH ENHANCED -->
  <section id="book" class="bg-white text-black">
    <div class="container-fluid px-lg-7 px-md-5 px-4">
      <div class="row align-items-center g-5">

        <!-- LEFT SIDE — TEXT & EMOTIONAL HOOK -->
        <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right" data-aos-duration="900" data-aos-delay="100">
          <h2 class="fw-bold text-charcoal mb-4">Come Say Hello</h2>
          <p class="text-charcoal fs-5 mb-5" style="line-height: 1.8;">
            Our farm is open for intimate, guided visits Monday to Friday - where MBRLCFI's unique approach to nature and care invites you to reconnect. Reserve your peacful escape among rolling hills and the quiet rhythm of the land.
          </p>

          <div class="d-flex align-items-center mb-4">
            <span class="bi bi-tree-fill text-dark-green me-3" style="font-size: 1.8rem; opacity: 0.7;"></span>
            <span class="small text-charcoal" style="letter-spacing: 0.5px;">Rooted in Faith • Growing in Abundance</span>
          </div>
        </div>

        <!-- RIGHT SIDE — FORM -->
        <div class="col-lg-6 order-lg-2 order-1" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
          <div class="booking-form-card shadow-lg rounded-4 p-5 h-100">
            <form id="bookNow">
              <div class="row g-4">

                <!-- Name Fields -->
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark-green">First Name</label>
                  <input type="text" class="form-control border-0 shadow-sm py-3" name="first_name" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark-green">Last Name</label>
                  <input type="text" class="form-control border-0 shadow-sm py-3" name="last_name" required>
                </div>

                <!-- Email & Phone -->
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark-green">Email</label>
                  <input type="email" class="form-control border-0 shadow-sm py-3" name="email" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark-green">Phone Number</label>
                  <input type="text" class="form-control border-0 shadow-sm py-3" name="phone_number" required>
                  <div class="invalid-feedback small mt-1">
                    Phone number must start with 09, followed by 9 digits.
                  </div>
                </div>

                <!-- Booking Date -->
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark-green">Booking Schedule</label>
                  <input type="text" class="form-control border-0 shadow-sm py-3" id="filterSalesByDate" name="booking_schedule" required>
                </div>

                <!-- Guest Count -->
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark-green">Guests Count</label>
                  <input type="number" class="form-control border-0 shadow-sm py-3" name="guest_count" min="1" value="1">
                </div>

                <!-- Room Selection -->
                <div class="col-12">
                  <label class="form-label fw-semibold text-dark-green">Select Room</label>
                  <select class="form-select border-0 shadow-sm py-3" aria-label="Default select example" id="selectedRoom" name="selected_room_id">
                    <option value="">Choose a room...</option>
                    <!-- Options will be populated via JS -->
                  </select>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-center mt-4">
                  <button type="submit" class="btn btn-gold btn-sm fw-bold letter-spacing-1 shadow-lg hover-shadow">
                    Book Now
                  </button>
                </div>

              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container-fluid">
      <div class="row text-center">
        <div class="col-md-3">
          <h5 class="text-white">Visit</h5>
          <p>📍Kinuskusan Bansalan Davao Del Sur</p>
        </div>
        <div class="col-md-3">
          <h5 class="text-white">Contact</h5>
          <p>mbrlcfi71@gmail.com</p>
        </div>
        <div class="col-md-3">
          <h5 class="text-white">Hours</h5>
          <p>Mon–Fri: 8am–4pm<br>Tours by reservation</p>
        </div>
        <div class="col-md-3">
          <h5 class="text-white">Follow</h5>
          <p>Facebook<br>MBRLCFI DAVAO</p>
        </div>
        <hr class="mt-4 mb-3 bg-white opacity-25">
        <div class="text-center">
          <p>&copy; 2025 MBRLCFI. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>
  <?php include __DIR__ . '/../views/modal/news/ViewImageModal.php' ?>
  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS Library -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="./assets/js/booking.js"></script>
  <script src="./assets/js/room.js"></script>
  <script src="./assets/js/news.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      AOS.init({
        offset: 120,
        duration: 800,
        easing: 'ease-in-out',
        delay: 100,
        once: false
      });

      // Smooth scroll for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('href');
          document.querySelector(targetId).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        });
      });

      // Navbar scroll effect
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