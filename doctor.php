<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
  header("Location:index.php");
}
include('db.php');
# Το query τραβάει τα απαραίτητα δεδομένα για το view για τον γιατρό 'kostas'.
# Να αλλάξω where clause (Όταν μπουν τα sessions).

$query = "SELECT patients.firstname, patients.lastname, patients.email, patients.phone_number, appointments.location, DATE_FORMAT(appointments.datetime, '%W %m/%d/%Y at %H:%i') AS datetime, appointments.description FROM appointments INNER JOIN patients ON appointments.patient_id = patients.id INNER JOIN doctors ON appointments.doctor_id = doctors.id WHERE doctors.username = 'nikos'";
$prepared = $conn->prepare($query);
$prepared->execute();
$appointments_result = $prepared->get_result();

$sql = "SELECT firstname, lastname, specialty, biography FROM doctors WHERE id =" .$_SESSION['id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$firstname = $row['firstname'];
$lastname = $row['lastname'];
$specialty = $row['specialty'];
$biography = $row['biography'];

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
  <link href="websiteicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

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

      <h1 class="logo me-auto"><a href="admin.html">DocWebox</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#doctorappointment">Doctor Appointment</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
        </ul>
        
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <a class="appointment-btn d-none d-md-inline mx-2" href="logout.php">Logout</a>
      <a href="#profilesettings" class="profilesettings-btn scrollto" data-bs-toggle="modal" data-bs-target="#modal"><span class="d-none d-md-inline" ><div class="icon"><i class="fa-solid fa-gear"></i></div></span></a>
    </div>
  </header><!-- End Header -->

  
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <h1>Welcome to DocWebox</h1>
      <h2>A network for any doctor you need</h2>
      <a href="#contact" class="btn-get-started scrollto">Contact</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">
    
    <!--Profile Settings Modal -->

  <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalLabel">Profile Options</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" >
          <form action = "doctor.php" method = "POST" class="modal-form">
            <div class="firstname-block modcont">
              <label for="firstname">Name</label>
              <input type="input" class="firstname" id="firstname" placeholder="<?php echo $firstname ?>" name = "firstname">
            </div>
            <div class="lastname-block modcont">
              <label for="lastname">Last Name</label>
              <input type="input" class="lastname" id="lastname" placeholder="<?php echo $lastname ?>" name = "lastname">
            </div>
            <div class="specialty-block modcont">
              <label for="specialty">Specialty</label>
              <input type="input" class="specialty" id="specialty" placeholder="<?php echo $specialty ?>" name = "specialty">
            </div>
            <div class="bio-block modcont">
              <label for="bio">Biography</label>
              <textarea id="form7" class="md-textarea form-control" rows="3" placeholder = "<?php echo $biography ?>" name = "biography"></textarea>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
        </form>

        <!-- get data from the form -->
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
              $firstname = $_POST['firstname'];
              $lastname = $_POST['lastname'];
              $specialty = $_POST['specialty'];
              $biography = $_POST['biography'];
            $mySql = profileDataChangeQuery($firstname,$lastname,$specialty,$biography);
            if(!empty($mySql)){
            $result = $conn->query($mySql);
            }
          }

          function profileDataChangeQuery($firstname,$lastname,$specialty,$biography){
            $n = 0;
            $coma = true;
            $query = "UPDATE doctors SET ";
            if(!empty(test_input($firstname))){
              $n++;
              $query = $query . "firstname='" . $firstname . "'";
              $coma = false;
            }

            if(!empty(test_input($lastname))){
              $n++;
              if($coma==true){
              $query = $query . "lastname='" . $lastname . "'";
              $coma = false;
              }
              else{
              $query = $query . ", lastname='" . $lastname . "'";
              }
            }

            if(!empty(test_input($specialty))){
              $n++;
              if($coma==true){
              $query = $query . "specialty='" . $specialty . "'";
              $coma = false;
              }
              else{
              $query = $query . ", specialty='" . $specialty . "'";
              }
            }

            if(!empty(test_input($biography))){
              $n++;
              if($coma==true){
              $query = $query . "biography='" . $biography . "'";
              $coma = false;
              }
              else{
              $query = $query . ", biography='" . $biography . "'";
              }
            }

            if($n!=0){
              $query = $query . " WHERE id = " .$_SESSION['id'];
              return $query;
            }
            else {
              return $query = "";
            }
            }

            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }

            ?>



      </div>
    </div>
  </div>


    <!-- ======= Doctor Appointment Section ======= -->
    <section id="doctorappointment" class="doctorappointment">
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
          </div>

          <!--<div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5"> -->
            <div class="section-title">
              <h2>Doctor Appointments</h2>
              <p>Here you see a list of doctor appointments</p>
            </div>

            <div class="d-flex justify-content-around flex-wrap p-4">
            <?php
              if ($appointments_result->num_rows > 0) {
              $sn=1;
              while($data = $appointments_result->fetch_assoc()) {
            ?> 
              <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="patient.png" alt="Card image cap">
                <div class="card-body text-center" >
                  <h5 class="card-title">
                    <?php echo $data['firstname'], " ", $data['lastname']; ?>
                  </h5>

                  <p class="card-text"><!--Grid column-->
                    <div class="text-center">
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-phone mt-4 fa-2x"></i>
                                <p>
                                  <?php echo $data['phone_number']; ?>
                                </p>
                            </li>
            
                            <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                                <p>
                                  <?php echo $data['email']; ?>
                                </p>
                            </li>
                        </ul>
                      </div>

                    <!--Grid column--></p>
                  <a href="#" class="btn btn-primary">Edit Appointment</a>
                </div>
              </div>

            <?php
            $sn++;}
          } else { 
            ?> 
            <p class="card-text">
              <h2 class="text-center p-5">There are no appointments at this time</h2>
            </p>    
            <?php } ?>     
            </div>
        </div>
    </section>
    
    <!-- End Doctor Appointment Section -->


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


</body>

</html>