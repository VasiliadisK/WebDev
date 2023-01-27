<?php
session_start();
include('db.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
  
    $id = $_POST["id"];
    $date = $_POST["datetime"];
    $description = trim($_POST["description"]);

  // Prepare an update statement
  $stmt = "UPDATE appointments SET datetime = '$date', description = '$description' WHERE id = '$id'";


    // Attempt to execute the prepared statement
    if(mysqli_query($conn, $stmt)){
      $response = [ 
          'success' => true,
          'message' => '<div class="alert alert-success">Successfully edited the appointment!</div>'
          ];
       echo json_encode($response);
    } else{
        $response = [ 
            'success' => false,
            'message' => '<div class="alert alert-warning">Oops! Something went wrong. Please try again later.</div>'
            ];
        echo json_encode($response);
    }
  }
?>