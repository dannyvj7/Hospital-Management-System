<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>
    <link rel="stylesheet" href="assets/css/home.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"
    />
    <style>
      footer {
        background: #1d1f27;
        color: #fff;
        padding: 50px 40px 20px;
        margin-top: 60px;
      }
      .footer-container {
        display: grid;
        grid-template-columns: 1fr 250px 250px 250px 250px;
        gap: 2rem;
      }
      .footer-column {
        min-width: 160px;
        margin-bottom: 5px;
      }
      .footer-logo {
        font-size: 20px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      .socials {
        display: flex;
        gap: 10px;
      }
      .fa-hospital {
        color: #009879;
      }
      .footer-column h4 {
        margin-bottom: 12px;
        font-size: 16px;
        color: #ffffff;
      }
      .footer-column ul li {
        margin: 6px 0;
      }
      .footer-column ul li a {
        color: gray;
      }
      .footer-column ul li a:hover {
        color: #ffffff;
      }
      .footer-bottom {
        text-align: center;
        margin-top: 30px;
        font-size: 13px;
        color: #bbbbbb;
        border-top: 1px solid #333;
        padding-top: 15px;
      }
      @media (max-width: 800px){
        .footer-logo {
          text-align: center;
          display: block;
        }
        .footer-container{
          display: block;
          text-align: center;
        }
         .footer-column ul li a {
          display: none;
         }
      }
      .faq-section {
        background: #f4f6f9;
        padding: 60px 20px;
        text-align: center;
      }
      .faq-section h2 {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #009879;
      }
      .faq-container {
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
        background-color: white;
        padding: 1.1rem;
        border-radius: 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }
      span {
        max-width: 100%;
        display: block;
      }
      .faq-item .icons {
        font-size: 30px;
      }
      .faq-item .icons .faq-icon-minus {
        color: #009879;
        display: none;
      }
      .faq-item .icons .faq-icon-plus {
        color: #58837b;
      }
      .faq-item {
        border-bottom: 1px solid gray;
      }
      .faq-question {
        cursor: pointer;
        background: transparent;
        width: 100%;
        padding: 1rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border: none;
      }
      .faq-answer {
        background: white;
        max-height: 0;
        overflow: hidden;
        transition: min-height 200ms ease;
      }
      .faq-answer p {
        color: #555;
        padding: 1.5rem 0;
      }
      /* Reviews Section */
      .reviews-section {
        background: #ffffff;
        padding: 60px 20px;
        text-align: center;
      }

      .reviews-section h2 {
        font-size: 32px;
        margin-bottom: 40px;
        font-weight: bold;
        color: #009879;
        text-align: center;
      }

      /* Review Card */
      .review-card {
        background: #f8f9fc;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        text-align: center;
      }

      .review-card img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
      }

      .review-card h3 {
        font-size: 18px;
        font-weight: 700;
        color: #222;
        margin-bottom: 5px;
      }

      .review-card .stars {
        color: #ffc107;
        font-size: 18px;
        margin-bottom: 10px;
      }

      .review-card p {
        color: #555;
        font-size: 14px;
        line-height: 1.5;
      }

      /* Center pagination dots */
      .swiper-pagination-bullet {
        background: #007bff;
        opacity: 0.4;
      }

      .swiper-pagination-bullet-active {
        background: #0056b3;
        opacity: 1;
      }

      /* Doctors Section */
      .doctors-section {
        padding: 60px 40px;
        background: #f8f9fc;
        text-align: center;
      }

      .doctors-section h2 {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #009879;
      }

      .section-subtitle {
        font-size: 16px;
        color: #555;
        margin-bottom: 40px;
      }

      .doctor-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
      }

      .doctor-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }

      .doctor-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
      }

      .doctor-card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 12px;
      }

      .doctor-card h3 {
        margin-top: 15px;
        font-size: 20px;
        font-weight: 700;
        color: #222;
      }

      .specialty {
        font-size: 16px;
        font-weight: 600;
        color: #007bff;
        margin-top: 4px;
      }

      .experience {
        font-size: 14px;
        color: #666;
        margin-top: 3px;
      }

      .bio {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
        line-height: 1.6;
      }
      .app {
        margin-top: 20px;
        font-size: 19px;
        color: red;
      }
      .app-btn {
        background: transparent;
        color: black;
        border: 1px solid #009879;
        border-radius: 30px;
        padding: 10px 15px;
        font-weight: bolder;
        cursor: pointer;
      }
      .app-btn:hover {
        background: #58837b;
      }
      /* Responsive */
      @media (max-width: 992px) {
        .doctor-container {
          grid-template-columns: repeat(2, 1fr);
        }
      }

      @media (max-width: 600px) {
        .doctor-container {
          grid-template-columns: 1fr;
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <nav>
        <div class="header">
          <div class="logo">
            <i class="fa-solid fa-hospital"></i><span>HMS</span>
          </div>
          <div class="menu-toggle">
            <button><i class="fas fa-bars"></i></button>
          </div>
        </div>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#" class="current">About</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="index.php" class="login-btn">Login</a></li>
        </ul>
      </nav>
    </div>
    <section class="hero">
      <div class="hero-content">
        <h1>Welcome to the Hospital Management System</h1>
        <p>
          Manage hospital operations easily - form patient registration to
          doctor appointments - all in one platform.
        </p>
        <a href="index.php" class="cta-btn"
          >Get Started <i class="fa-solid fa-arrow-right-from-bracket"></i
        ></a>
      </div>
    </section>
    <!-- ABOUT SECTION -->
    <section class="about-section">
      <div class="about-container">
        <h1>About Our Hospital Management System</h1>
        <p class="intro">
          Our Hospital Management System (HMS) is designed to streamline
          healthcare operations by providing a fast, secure and user-friendly
          digital system for managing patients, appointments, and doctor
          interactions.
        </p>

        <div class="about-grid">
          <div class="about-box">
            <i class="fa-solid fa-user-doctor icon"></i>
            <h3>For Doctors</h3>
            <p>
              Doctors can view and manage appointments, update patient status,
              and keep track of schedules — all in one dashboard.
            </p>
          </div>

          <div class="about-box">
            <i class="fa-solid fa-hospital-user icon"></i>
            <h3>For Patients</h3>
            <p>
              Patients can easily book appointments, view upcoming schedules,
              and manage their healthcare profile from anywhere.
            </p>
          </div>

          <div class="about-box">
            <i class="fa-solid fa-shield-halved icon"></i>
            <h3>Secure & Reliable</h3>
            <p>
              The system follows strict security standards to protect patient
              data and ensure reliability in hospital operations.
            </p>
          </div>

          <div class="about-box">
            <i class="fa-solid fa-gears icon"></i>
            <h3>Efficient Automation</h3>
            <p>
              HMS reduces paperwork, eliminates scheduling conflicts, and
              improves the speed and accuracy of hospital operations.
            </p>
          </div>
        </div>

        <div class="mission-section">
          <h2>Our Mission</h2>
          <p>
            To transform healthcare through digital innovation by creating a
            modern, time-saving, and secure system that improves communication
            between doctors and patients while enhancing overall healthcare
            delivery.
          </p>
        </div>
      </div>
    </section>
    <section class="doctors-section">
      <h2>Meet Our Doctors</h2>
      <p class="section-subtitle">
        Highly qualified medical professionals ready to care for you.
      </p>

      <div class="doctor-container">
        <!-- Doctor 1 -->
        <div class="doctor-card">
          <img src="assets/img/doctor2.png" alt="" />
          <h3>Dr. Fred Wittons</h3>
          <p class="specialty">Surgeon</p>
          <p class="experience">12 Years Experience</p>
          <p class="bio">
            Dr. Fred Wittons has extensive experience in treating brain & nerve
            disorders, using modern diagnostic and treatment methods.
          </p>
        </div>

        <!-- Doctor 2 -->
        <div class="doctor-card">
          <img src="assets/img/doctor1.jpg" alt="" />
          <h3>Dr. Sarah Williams</h3>
          <p class="specialty">Pediatrician</p>
          <p class="experience">10 Years Experience</p>
          <p class="bio">
            Dr. Williams specializes in child healthcare and development with a
            warm and compassionate approach to young patients.
          </p>
        </div>

        <!-- Doctor 3 -->
        <div class="doctor-card">
          <img src="assets/img/doctor3.jpg" alt="" />
          <h3>Dr. Adams Murphy</h3>
          <p class="specialty">Cardiologist</p>
          <p class="experience">25 Years Experience</p>
          <p class="bio">
            Dr. Adams Murphy is a renowned cardiologist with deep expertise in
            heart disease management and advanced cardiac procedures.
          </p>
        </div>
      </div>
      <p class="app">
        Book an appointment with us today
        <a href="register.php" class="app-btn">Click here</a>
      </p>
    </section>

    <!-- Swiper -->
    <section class="reviews-section">
      <h2>What Some Of Our Patients Say</h2>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide review-card">
            <img src="assets/img/profile3.jpg" alt="Person 1" />
            <h3>James Anderson</h3>
            <div class="stars">★★★★★</div>
            <p>
              “Great experience! The staff was friendly and the environment was
              clean and comfortable.”
            </p>
          </div>
          <div class="swiper-slide review-card">
            <img src="assets/img/profile2.jpg" alt="Person 2" />
            <h3>Sophia Martinez</h3>
            <div class="stars">★★★★★</div>
            <p>
              “I received excellent treatment and follow-up care. Definitely one
              of the best hospitals I’ve visited.”
            </p>
          </div>
          <div class="swiper-slide review-card">
            <img src="assets/img/profile1.jpg" alt="Person 3" />
            <h3>Emily Parker</h3>
            <div class="stars">★★★★★</div>
            <p>
              “The doctors were very caring and professional. The service I
              received was exceptional. Highly recommended!”
            </p>
          </div>
          <div class="swiper-slide review-card">
            <img src="assets/img/profile4.jpg" alt="Person 4" />
            <h3>Michael Johnson</h3>
            <div class="stars">★★★★★</div>
            <p>
              “The online appointment system is fast and easy to use. I didn’t
              have to wait long at all. Highly efficient service.”
            </p>
          </div>
          <div class="swiper-slide review-card">
            <img src="assets/img/profile5.jpg" alt="Person 5" />
            <h3>Aisha Mohammed</h3>
            <div class="stars">★★★★★</div>
            <p>
              “Excellent doctors and very supportive nurses. I felt safe and
              well taken care of during my entire treatment.”
            </p>
          </div>
          <div class="swiper-slide review-card">
            <img src="assets/img/profile6.jpg" alt="Person 6" />
            <h3>Daniel Thompson</h3>
            <div class="stars">★★★★★</div>
            <p>
              “Modern facilities and very professional staff. I’m impressed with
              how organized everything is. Highly recommend!”
            </p>
          </div>
          <div class="swiper-slide review-card">
            <img src="assets/img/profile7.jpg" alt="Person 7" />
            <h3>Grace Owusu</h3>
            <div class="stars">★★★★★</div>
            <p>
              “Wonderful experience. The cardiology department handled my case
              with great expertise and compassion.”
            </p>
          </div>
          <div class="swiper-slide review-card">
            <img src="assets/img/profile8.jpg" alt="Person 8" />
            <h3>Benjamin Carter</h3>
            <div class="stars">★★★★★</div>
            <p>
              “Friendly, fast, and reliable service. The hospital’s digital
              system makes everything so convenient.”
            </p>
          </div>
        </div>
        <!-- Swiper Pagination -->
        <div class="swiper-pagination"></div>
      </div>
    </section>

    <!-- FAQ SECTION-->
    <section class="faq-section">
      <h2>FAQs</h2>
      <div class="faq-container">
        <!-- item -->
        <div class="faq-item">
          <button class="faq-question accordion-btn">
            How do I book an appointment?
            <div class="icons">
              <span class="faq-icon-plus">+</span>
              <span class="faq-icon-minus">-</span>
            </div>
          </button>
          <div class="faq-answer">
            <p>
              You can book an appointment by registering as a patient and using
              the online booking system to select your preferred doctor and time
              slot.
            </p>
          </div>
        </div>
        <!-- end of item -->
        <!-- item -->
        <div class="faq-item">
          <button class="faq-question accordion-btn">
            Can I cancel or reschedule my appointment?
            <div class="icons">
              <span class="faq-icon-plus">+</span>
              <span class="faq-icon-minus">-</span>
            </div>
          </button>
          <div class="faq-answer">
            <p>
              Yes, patients can cancel or reschedule appointments from their
              dashboard before the scheduled date.
            </p>
          </div>
        </div>
        <!-- end of item -->
        <!-- item -->
        <div class="faq-item">
          <button class="faq-question accordion-btn">
            How do I contact a doctor directly?
            <div class="icons">
              <span class="faq-icon-plus">+</span>
              <span class="faq-icon-minus">-</span>
            </div>
          </button>
          <div class="faq-answer">
            <p>
              Communication with doctors is handled through the HMS system to
              maintain security and privacy.
            </p>
          </div>
        </div>
        <!-- end of item -->
        <!-- item -->
        <div class="faq-item">
          <button class="faq-question accordion-btn">
            Is patient data secure?
            <div class="icons">
              <span class="faq-icon-plus">+</span>
              <span class="faq-icon-minus">-</span>
            </div>
          </button>
          <div class="faq-answer">
            <p>
              Yes, HMS follows strict security protocols to protect patient
              information and comply with data privacy standards.
            </p>
          </div>
        </div>
        <!-- end of item -->
        <!-- item -->
        <div class="faq-item">
          <button class="faq-question accordion-btn">
            Can I register as both a patient and a doctor?
            <div class="icons">
              <span class="faq-icon-plus">+</span>
              <span class="faq-icon-minus">-</span>
            </div>
          </button>
          <div class="faq-answer">
            <p>
              No, you must register separately as either a patient or a doctor.
              Admin accounts are created internally.
            </p>
          </div>
        </div>
        <!-- end of item -->
      </div>
    </section>
    <footer>
      <div class="footer-container">
        <div class="footer-column">
          <h3 class="footer-logo">
            <i class="fa-solid fa-hospital"></i><span>HMS</span>
          </h3>
          <ul class="socials">
            <li>
              <a href="#"><i class="fab fa-x-twitter"></i></a>
            </li>
            <li>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </li>
            <li>
              <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>Hospital</h4>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Departments</a></li>
            <li><a href="#">Our Doctors</a></li>
            <li><a href="#">Emergency Services</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>Management</h4>
          <ul>
            <li><a href="#">Patient</a></li>
            <li><a href="#">Doctor</a></li>
            <li><a href="#">Appointments</a></li>
            <li><a href="#">Medical Reports</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>Support</h4>
          <ul>
            <li><a href="#">Help Center</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">System Guide</a></li>
            <li><a href="#">Contact Admin</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>Legal</h4>
          <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Data</a></li>
            <li><a href="#">Terms of Use</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>
          &copy;
          <?php echo date("Y"); ?>
          Hospital Management System - Powered by HMS
        </p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        breakpoints: {
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
        },
      });
      // FAQ Accordion
      document.querySelectorAll(".faq-item").forEach((item) => {
        const btn = item.querySelector(".accordion-btn");
        const answer = item.querySelector(".faq-answer");
        const plus = item.querySelector(".faq-icon-plus");
        const minus = item.querySelector(".faq-icon-minus");

        btn.addEventListener("click", () => {
          const isOpen = item.classList.contains("open");

          // Close all items (accordion behavior)
          document.querySelectorAll(".faq-item").forEach((i) => {
            i.classList.remove("open");
            i.querySelector(".faq-answer").style.maxHeight = null;
            i.querySelector(".faq-icon-plus").style.display = "block";
            i.querySelector(".faq-icon-minus").style.display = "none";
          });

          // If it was not open, open it
          if (!isOpen) {
            item.classList.add("open");
            answer.style.maxHeight = answer.scrollHeight + "px";
            plus.style.display = "none";
            minus.style.display = "block";
          }
        });
      });
    </script>
  </body>
</html>
