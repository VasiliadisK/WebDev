<?php
   include("db.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 

      $sql = "SELECT IF(EXISTS(
                  SELECT username
                  FROM users
                  WHERE username='$myusername' AND password='$mypassword'), 'user',
               (SELECT IF(EXISTS(
                  SELECT username
                  FROM doctors
                  WHERE username='$myusername' AND password='$mypassword'), 'doctor', 'invalid')))";

      $result = current($db->query($sql)->fetch_assoc());
   
      if ($result=="user"){
         header("location:user.php");
      }else if ($result=="doctor"){
         header("location:doctor.php");
      }else{
         $error = "Your Login Name or Password is Invalid!";
      }
   }
?>