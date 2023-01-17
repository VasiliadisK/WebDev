<?php
session_start();
include('db.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
  
    $doctor_id = $_POST["id"];
    $patient_id = $_SESSION["id"];
    $date = $_POST["datetime"];
    $description = trim($_POST["description"]);

    $query = "SELECT location FROM doctors WHERE id =" .$doctor_id;
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $location = $row['location'];

  // Prepare an insert statement
  $sql = "INSERT INTO appointments (patient_id, doctor_id, datetime, description, location) VALUES (?, ?, ?, ?, ?)";

  if($stmt = mysqli_prepare($conn, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sssss", $patient_id, $doctor_id, $date, $description, $location);

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
      $response = [ 
          'success' => true,
          'message' => '<div class="alert alert-success">Successfully made an appointment!</div>'
          ];
       echo json_encode($response);
    } else{
        $response = [ 
            'success' => false,
            'message' => '<div class="alert alert-warning">Oops! Something went wrong. Please try again later.</div>'
            ];
        echo json_encode($response);
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }
}
?>