<?php session_start(); 

if(isset($_SESSION["loggedin"])){
  if($_SESSION["is_doctor"]){
    header("Location: doctor.php");
  } else {
    header("Location: user.php");
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>DocWebox</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Latest compiled and minified CSS -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope"></i> <a href="mailto:contact@example.com">DocWebox@gmail.com</a>
        <i class="bi bi-phone"></i> +30 5589 55488 55
      </div>
      <div class="d-none d-lg-flex social-links align-items-center">
        <a href="#" class="twitter"><i class="fa-brands fa-twitter"></i></a>
        <a href="#" class="facebook"><i class="fa-brands fa-facebook"></i></a>
        <a href="#" class="instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" class="linkedin"><i class="fa-brands fa-linkedin"></i></a>
      </div>
    </div>
  </div>


  

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.php">DocWebox</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php">Home</a></li> <!--#hero-->
          <li><a class="nav-link scrollto" href="#docs">Doctors</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
        </ul>
        
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <?php 
      if(!isset($_SESSION["loggedin"])){
        ?>
      <a href="#appointment" class="appointment-btn scrollto" data-bs-toggle="modal" data-bs-target="#login_modal" id="getstarted"><span class="d-none d-md-inline" >Get Started</span></a>
      <?php } else { ?>
      <a class="appointment-btn d-none d-md-inline" href="logout.php">Logout</a>
      <?php } ?>
      <!-- <a href="#appointment" class="appointment-btn scrollto" data-bs-toggle="modal" data-bs-target="#register_modal"><span class="d-none d-md-inline" >Register</span></a> -->
    </div>
  </header><!-- End Header -->

 
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <h1>Welcome to DocWebox</h1>
      <h2>A network for any doctor you need</h2>
      <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">
    
    <!-- Login Modal -->
  
  <div class="modal fade" id="login_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="login">
      <div class="switch">
            <div class="login active" onclick="LoginBut()">Login</div>
            <div class="register" onclick="RegisterBut()">Register</div>
        </div>
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalLabel">Login</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <form id="login_register_form" method="POST" class="modal-form">
            <div class="username-block" style="margin-bottom:0px;">
              <label for="username" id="label1">Username</label>
              <input type="input" class="form-control" name="username" id="username" placeholder="Username" required>
              <span class="error" id="username_err"></span>
            </div>
            <div class="password-block">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
              <span class="error" id="password_err"></span>
            </div>     
            <div class="form-check" id="login_as_doctor" style = "padding-top:30px;">
              <input class="form-check-input" type="checkbox" name="login_as_doctor" value="" id="flexCheckDefault" style = "cursor:pointer;">
              <label class="form-check-label" for="flexCheckDefault" style="margin-right:100px; cursor:pointer;">Login as a doctor
              </label>
            </div>
            <div class="registerfields" style="display: none;">
              <div class="password-block" >
                <label for="password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <span class="error" id="confirm_password_err"></span>
              </div>
              <div class="email-block" style="margin-bottom:0px; padding:10px;">
                <label for="email">Email</label>
                <input type="input" class="form-control" name="email" id="email" placeholder="Email" required>
                <span class="error" id="email_err"></span>
              </div>
              <div class="bio-block">
                <label for="specialty" id ="specialty">Specialty</label>
                <input type="bio" class="form-control" name="specialty" id="specialtyInput" placeholder="Specialty" disabled required>
                <span class="error" id="specialty_err"></span>
              </div>
              <div class="form-check" id="register_as_doctor" style = "padding-top:30px;">
                <input class="form-check-input" type="checkbox" name="register_as_doctor" value="" id="flexCheckDefault" style = "cursor:pointer;">
                <label class="form-check-label" for="flexCheckDefault" style="margin-right:100px; cursor:pointer;">Register as a doctor
                </label>
              </div>
            </div>
            <div class="modal-footer">
              <button style="display:block;" type="button" name="button" id="login_button" value="login" class="btn btn-primary formbut">Login</button>
              <button style="display:none;" type="button" name="button" id="register_button" value="login" class="btn btn-primary formbut">Register</button>
            </div>
          </form>
          <div id="message"></div>
        </div>
      </div>
    </div>
  </div>

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
      <div class="container">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="content">
              <h3>Why Choose DocWebox?</h3>
              <p>
                DocWebox is a website that allows clients to find doctors of any specialty with a simple search. Book an appointment and resolve your issues fast.
              </p>
              
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="fa-solid fa-sheet-plastic"></i>
                    <h4>Book appointments</h4>
                    <p>Easy way to book an appointment with your doctor fast</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h4>Search any doctor</h4>
                    <p>Use our filters or search with name or specialty for the doctor of your desire</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="fa-solid fa-xmark"></i>
                    <h4>Change your appointments or cancel it anytime </h4>
                    <p>Something came up? No problem just reschedule or just cancel your appointment with the press of a button</p>
                  </div>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
          </div>

          <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
            <h3>Find the best doctor suited for your problem</h3>
            <p>Our team contains some of the best medical staff trained to perform any kind of medical diagnosis or procedure.</p>

            <div class="icon-box">
              <div class="icon"><i class="fa-solid fa-question"></i></div>
              <h4 class="title"><a href="">Need information?</a></h4>
              <p class="description">Be sure to let our team know if you have any questions. Even if your doctor is not available at that time we will be sure to inform him and get back to you as soon as possible.</p>
            </div>

            <div class="icon-box">
              <div class="icon"><i class="fa-solid fa-wrench"></i></div>
              <h4 class="title"><a href="">Most advanced machinery</a></h4>
              <p class="description">Here in DocWebox we use the most advanced available technology to not only give you the best experience but also to be precise with your diagnosis.</p>
            </div>

            <div class="icon-box">
              <div class="icon"><i class="fa-solid fa-euro-sign"></i></div>
              <h4 class="title"><a href="">Accessible prices</a></h4>
              <p class="description">HealthCare is something that anyone must be able to afford! So our accessible fees allow everyone to get proper healthcare.</p>
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->

   
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2>Services</h2>
          <p>Here in our headcourters you will find all kind of services. Some of them are:</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-heartbeat"></i></div>
              <h4><a href="">Examination</a></h4>
              <p>All kind of examination including blood, covid-19 tests as well as ultrasounds and axial tomography.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-pills"></i></div>
              <h4><a href="">Proper Medication</a></h4>
              <p>We can prescribe any medication after proper examination by our team.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-cut"></i></div>
              <h4><a href="">Surgery</a></h4>
              <p>Our group undertakes all kinds of surgery which can be performed by a surgeon of your choice</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-syringe"></i></div>
              <h4><a href="">Vaccinations</a></h4>
              <p>We vaccinate children and adults after proper examinations.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-hospital"></i></div>
              <h4><a href="">Hosplitalization</a></h4>
              <p>If you need hospitalization, you do not have to worry. Our team can take care of you 24/7.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-notes-medical"></i></div>
              <h4><a href="">Other diseases</a></h4>
              <p>Some of the other specialties in our group are Neurosurgeons, Gastroenterologists, pathologists and much more.</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>If you need more information feel free to contact our team 24 hours a day. If there is an emergency please call the emergency number.</p>
        </div>
      </div>


      <div class="container">
        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="fa-sharp fa-solid fa-location-dot"></i>
                <h4>Location:</h4>
                <p>A108 Adam Street, New York, NY 535022</p>
              </div>

              <div class="email">
                <i class="fa-solid fa-envelope"></i>
                <h4>Email:</h4>
                <p>DocWebox@gmail.com</p>
              </div>

              <div class="phone">
                <i class="fa-solid fa-phone"></i>
                <h4>Call:</h4>
                <p>+30 5589 55488 55</p>
              </div>

              <div class="phone">
                <i class="fa-solid fa-exclamation"></i>
                <h4>Emergencies:</h4>
                <p>+30 119</p>
              </div>

            </div>

          </div>


        </div>

      </div>
    </section><!-- End Contact Section -->

      

  </main><!-- End #main -->

  
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fa-solid fa-arrow-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/validation.js"></script>

</body>

</html>