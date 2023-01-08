<?php
   include("db.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $param_username = trim($_POST['username']);
      // Prepare our SQL, preparing the SQL statement will prevent SQL injection.

      if(!isset($_POST["login_as_doctor"])){
         $statement = $conn->prepare('SELECT id, password FROM patients WHERE username = ?');
      } else {
         $statement = $conn->prepare('SELECT id, password FROM doctors WHERE username = ?');
      }

      if ($stmt = $statement) {
         // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
         $stmt->bind_param('s', $param_username);
         $stmt->execute();
         // Store the result so we can check if the account exists in the database.
         $stmt->store_result();

         if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if (password_verify($_POST["password"], $password)) {
               // Verification success! User has logged-in!
               // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
               session_regenerate_id();
               $_SESSION['loggedin'] = TRUE;
               $_SESSION['name'] = $_POST['username'];
               $_SESSION['id'] = $id;
               $_SESSION['is_doctor'] = isset($_POST["login_as_doctor"]);
               $response = [ 
                  'success' => true,
                  'message' => '<div class="alert alert-success">Welcome ' . $_SESSION['name'] . '!</div>'
                  ];
               echo json_encode($response);
            } else {
               // Incorrect password
               $response = [ 
                  'success' => false,
                  'message' => '<div class="alert alert-warning">Username and/or password incorrect.</div>'
                  ];
               echo json_encode($response);
            }
         } else {
            // Incorrect username
            $response = [ 
               'success' => false,
               'message' => '<div class="alert alert-warning">Username and/or password incorrect.</div>'
               ];
            echo json_encode($response);
         }

         $stmt->close();
      }
   }
?>