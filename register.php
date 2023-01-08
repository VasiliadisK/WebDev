<?php

// Include config file
require_once "db.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $specialty = "";
$username_err = $password_err = $confirm_password_err = $email_err = $specialty_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        if(isset($_POST["register_as_doctor"])){
            $sql = "SELECT id FROM doctors WHERE username = ?";
        } else{
            $sql = "SELECT id FROM patients WHERE username = ?";
        }
        
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // store result
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $response = [ 
                        'success' => false,
                        'message' => '<div class="alert alert-danger">This username is already taken.</div>'
                        ];
                     echo json_encode($response);
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
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
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate e-mail
    if(empty(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL))){
        $email_err = "Please enter an email.";
    } else{
        if (!filter_var(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please enter a valid email.";
        } else {
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        }
    }

    // Validate specialty
    if(isset($_POST["register_as_doctor"])){
        if(empty(trim($_POST["specialty"]))){
            $specialty_err = "Enter a specialty.";
        } elseif(!preg_match('/^[a-zA-Z]+$/', trim($_POST["specialty"]))) {
            $specialty_err = "Specialty can only contain letters.";
        } else {
            $specialty = trim($_POST["specialty"]);
        }
    }
    
    
    // Check input errors before inserting in database
    if(!isset($_POST["register_as_doctor"])){
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
            // Prepare an insert statement
            $sql = "INSERT INTO patients (username, password, email) VALUES (?, ?, ?)";
             
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
                
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_email = $email;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $response = [ 
                        'success' => true,
                        'message' => '<div class="alert alert-success">Successfully registered!</div>'
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
    } else {
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($specialty_err)){
        
            // Prepare an insert statement
            $sql = "INSERT INTO doctors (username, password, email, specialty) VALUES (?, ?, ?, ?)";
             
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_email, $param_specialty);
                
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_email = $email;
                $param_specialty = $specialty;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $response = [ 
                        'success' => true,
                        'message' => '<div class="alert alert-success">Successfully registered!</div>'
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
    }
    
    // Close connection
    mysqli_close($conn);
}

?>