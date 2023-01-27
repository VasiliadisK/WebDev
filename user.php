<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['is_doctor'] === TRUE) {
  header("Location:index.php");
}
include('db.php');
# Το query τραβάει τα απαραίτητα δεδομένα για το view για τον χρήστη 'kostas'.
# Να αλλάξω where clause (Όταν μπουν τα sessions).

$query = "SELECT doctors.firstname, doctors.lastname, doctors.specialty, doctors.image, appointments.id, appointments.location, DATE_FORMAT(appointments.datetime, '%W %m/%d/%Y at %H:%i') AS datetime, appointments.description FROM appointments INNER JOIN patients ON appointments.patient_id = patients.id INNER JOIN doctors ON appointments.doctor_id = doctors.id WHERE patients.username = '".$_SESSION['name']."'";
$prepared = $conn->prepare($query);
$prepared->execute();
$appointments_result = $prepared->get_result();


$query = "SELECT doctors.id, doctors.firstname, doctors.lastname, doctors.specialty, doctors.image, doctors.email, doctors.phone_number FROM doctors";
$prepared = $conn->prepare($query);
$prepared->execute();
$doctors_result = $prepared->get_result();

$sql = "SELECT firstname, lastname, username FROM patients WHERE id =" .$_SESSION['id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$firstname = $row['firstname'];
$lastname = $row['lastname'];
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

  <!-- JQuery -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

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
          <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto" href="#docs">Doctors</a></li>
          <li><a class="nav-link scrollto" href="#services">My appointments</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><div class="container">
          <form action="#">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Search Doctors
</button>
          </form>
          </div></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <a class="appointment-btn d-none d-md-inline mx-2" href="logout.php">Logout</a>
      <a href="#profilesettings" class="profilesettings-btn scrollto" data-bs-toggle="modal" data-bs-target="#modalGear"><span class="d-none d-md-inline" ><div class="icon"><i class="fa-solid fa-gear"></i></div></span></a>
    </div>
  </header><!-- End Header -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


<?php
?>
<!-- Modal for Doctor Search-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Search Doctors Based on: </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>



      <div class="modal-body">
       <form action = "user.php" method = "POST" class ="modal-form">
       <label for="chooseLocation">Location</label>
       <input type="hidden" name="form_name" value="searchForm">
       <select class="form-select" aria-label="Default select example" style ="margin-bottom:30px; margin-top:0px;" name="selectedLocation">
  <option selected id ="chooseLocation" name ="sele">Choose Location</option>
  <?php
  $query = "SELECT location, specialty FROM doctors";
  $searchPrepared = $conn->prepare($query);
  $searchPrepared->execute();
  $locations_specialties = $searchPrepared->get_result();
  $locations = array();
  $specialties = array();
   if($locations_specialties->num_rows > 0){
    while($x = $locations_specialties->fetch_assoc()){
      $new_location = $x['location'];
      if (!in_array($new_location, $locations)) {
        array_push($locations, $new_location);
    }
    $new_specialty = $x['specialty'];
    if (!in_array($new_specialty, $specialties)) {
      array_push($specialties, $new_specialty);
  }
    }
  }
  for($i =0; $i < count($locations); $i++){
  echo "<option value=", $locations[$i], ">", $locations[$i], "</option>";
  }
   ?>
</select>
       <label for="chooseSpecialty">Specialty</label>
       <select class="form-select" aria-label="Default select example" name ="selectedSpecialty">
  <option selected id ="chooseSpecialty">Choose Specialty</option>
  <?php
   for($i =0; $i < count($specialties); $i++){
    echo "<option value=", $specialties[$i], ">", $specialties[$i], "</option>";
    }
    ?>
</select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="searchSubmit">Search</button>
      </div>
    </div>
  </div>
</div>
</form>

<?php
if($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['form_name']=='searchForm'){
$query = "SELECT id, firstname, lastname, specialty, image, email, phone_number FROM doctors WHERE location ='". $_POST['selectedLocation'] . "'" . " AND specialty= '". $_POST['selectedSpecialty']."'";
$prepared = $conn->prepare($query);
$prepared->execute();
$searchedDoctors = $prepared->get_result();
}
?>



  <!-- Modal for gear (options) // profile Setinngs Change -->
  <div class="modal fade" id="modalGear" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ModalLabel">Profile Options</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>


        <div class="modal-body" >
          <form action = "user.php" method = "POST" class="modal-form">
          <input type="hidden" name="form_name" value="editForm">
            <div class="firstname-block modcont">
              <label for="firstname">First Name</label>
              <input type="input" class="firstname" id="firstname" name="firstname" placeholder = "<?php echo $firstname ?>" required>
            </div>
            <div class="lastname-block modcont">
              <label for="lastname">Last Name</label>
              <input type="input" class="lastname" id="lastname" name ="lastname" placeholder = "<?php echo $lastname ?>" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id ="enterKey">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  //gia na brw pia forma ekane submit o xristis na ginete to isset sto value tou submit tis kathe formas kai meta sto telos pou trexei o kwdikas mporoume na tou dinoume pali ti timi null
   if($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['form_name'] == 'editForm'){
   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];
   $mySql = profileDataChangeQuery($firstname,$lastname);
   if(!empty($mySql))
            $result = $conn->query($mySql);
          }

          function profileDataChangeQuery($firstname,$lastname){
            $n = 0;
            $coma = true;
            $query = "UPDATE patients SET ";
            if(!empty(test_input($firstname))){
              $n++;
              $query = $query . "firstname='" . $firstname . "'";
              $coma = false;
            }

            if(!empty(test_input($lastname))){
              $n++;
              if($coma===true){
              $query = $query . "lastname='" . $lastname . "'";
              $coma = false;
              }
              else
              $query = $query . ", lastname='" . $lastname . "'";
              
            }

            if($coma===false){
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
 <!-- ======= About Section ======= -->

 <section id="home" class="about mt-5">
    <div class="container-fluid">
        <div class="icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
          <h3>Look up any doctor using a name, specialty or even a location</h3>

          <div class="icon-box" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <div class="icon"><i class="fa-solid fa-magnifying-glass"></i></div>
            <h4 class="title"><a href="#search">Search for our doctors</a></h4>
            <p class="description">Feel free to use the search bar to look up any of our doctors using filters like name, specialty or location !</p>
          </div>

          <div class="icon-box">
            <div class="icon"><i class="fa-solid fa-check"></i></div>
            <h4 class="title"><a class="nav-link scrollto" href="#docs">Make an appointment with a doctor of your choice...</a></h4>
            <p class="description">Found a doctor you like? Make an appointment with him to resolve your issues</p>
          </div>

          <div class="icon-box">
            <div class="icon"><i class="fa-solid fa-phone"></i></div>
            <h4 class="title"><a class="nav-link scrollto" href="#contact">Contact</a></h4>
            <p class="description">Be sure to let us know if there is a problem or if you need help with your appointments!</p>
          </div>

        </div>
      </div>

    </div>
  </section><!-- End About Section -->

 
   <!-- Search for doctors section -->
   
   <section id="docs">
     <div class="container">
        <h1 class="text-center">Our doctors</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-5">
        <?php
        if($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['form_name']=='searchForm'){
            $shownDoctors = $searchedDoctors;
        }
        else{
          $shownDoctors = $doctors_result;
        }
          if ($shownDoctors->num_rows > 0) {
            $sn=1;
            while($data = $shownDoctors->fetch_assoc()) {
        ?>
            <div class="col">
                <div class="card">
                  <img src="./assets/img/<?php echo $data['image']; ?>" class="card-img-top"
                    alt="Palm Springs Road" />
                  <div class="card-body">
                    <h5 class="card-title">
                      <?php echo $data['firstname'], " ", $data['lastname']; ?> 
                    </h5>
                    <p class="card-text">
                      <p class="card-text">
                          <?php echo $data['specialty']; ?>
                        </p>
                        <p class="card-text">
                          <?php echo $data['email']; ?>
                        </p>
                        <p class="card-text">
                          <?php echo $data['phone_number']; ?>
                        </p>
                        <p class="card-text">
                          <button type="button" id="makeAppointmentButton<?php echo $data['id']; ?>" class="btn btn-primary btn-lg btn-block makeAppointmentButton" data-bs-toggle="modal" data-bs-target="#makeAppointment">Make appointment</button>
                        </p>
                      </p>
                    </p>
                  </div>
                </div>
              </div>
          <?php
          $sn++;}
        } else { 
          ?>
          <p class="card-text">
            <h2 class="text-center">There are no available doctors at this time</h2>
          </p>    
          <?php } ?>
                </div>
            </div>
          </section>
   
   <!-- End of doctors sections -->


   <!-- Modal -->
   <div class="modal fade" id="makeAppointment" tabindex="-1" role="dialog" aria-labelledby="makeAppointmentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="makeAppointmentModalLabel">Appointment's date and time</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form id="makeAppointmentForm" method="POST">
            <div class="form-group">
              <label for="datetime">Date and Time</label>
              <input class="form-control mb-4" id="appointmentDatetime" type="datetime-local" name="datetime" value="<?php echo date("Y-m-d\TH:i"); ?>" required>
              <label for="description">Description</label>
              <textarea class="form-control" id="appointmentDescription" name="description" rows="5" cols="20" maxlength="50"></textarea>
              <span class="error" id="appointmentDescription_err"></span>
              <input type="hidden" name="id" id="appointmentDoctorId" value="" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="makeAppointmentSubmit" name="makeAppointmentSubmit" class="btn btn-primary makeAppointmentSubmit">Make Appointment</button>
          </div>
          </form>
          <div id="message"></div>
        </div>
      </div>
    </div>


    <!-- My appointments section -->


    <!-- Αν δεν υπάρχουν ραντεβού να βγάζει το μήνυμα -->

    <section id="services">
      <div class="container">
        <h1 class="text-center" >My appointments</h1>
          <div class="row row-cols-1 row-cols-md-3 g-4 mt-5">
    <?php
      if ($appointments_result->num_rows > 0) {
        $sn=1;
        while($data = $appointments_result->fetch_assoc()) {
    ?>
      <div class="col">
          <div class="card">
            <img src="./assets/img/<?php echo $data['image']; ?>" class="card-img-top"
              alt="Palm Springs Road" />
            <div class="card-body">
              <h5 class="card-title"><?php echo $data['firstname'], " ", $data['lastname'] ?></h5>
              <p class="card-text">
                <p class="card-text">
                    <?php echo $data['specialty'] ?>
                  </p>
                  <p class="card-text">
                    <?php echo $data['datetime']; ?>
                  </p>
                  <p class="card-text">
                    <?php echo $data['description'] ?>
                  </p>
                  <p class="card-text">
                    <?php echo $data['location'] ?>
                  </p>
                  <p class="card-text">
                    <button type="button" id="<?php echo $data['id'] ?>" class="btn btn-primary btn-lg btn-block editAppointmentButton" data-bs-toggle="modal" data-bs-target="#editAppointment">Edit Appointment</button>
                  </p>
                </p>
            </div>
          </div>
        </div>
    <?php
    $sn++;}
  } else { 
    ?><p class="card-text">
        <h2 class="text-center">There are no appointments at this time</h2>
      </p>    
    <?php } ?>
          </div>
      </div>
    </section>

    <!-- Modal -->
   <div class="modal fade" id="editAppointment" tabindex="-1" role="dialog" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editAppointmentModalLabel">Appointment's date and time</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form id="editAppointmentForm" method="POST">
            <div class="form-group">
              <label for="datetime">Date and Time</label>
              <input class="form-control mb-4" id="appointmentDatetime" type="datetime-local" name="datetime" value="<?php echo date("Y-m-d\TH:i"); ?>" required>
              <label for="description">Description</label>
              <textarea class="form-control" id="editAppointmentDescription" name="description" rows="5" cols="20" maxlength="50"></textarea>
              <span class="error" id="editAppointmentDescription_err"></span>
              <input type="hidden" name="id" id="editAppointmentId" value="" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="editAppointmentSubmit" name="editAppointmentSubmit" class="btn btn-primary">Edit Appointment</button>
          </div>
          </form>
          <div id="message"></div>
        </div>
      </div>
    </div>
    <!-- End of my appointments section-->
    
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
  <script src="assets/js/appointment.js"></script>

</body>

</html>