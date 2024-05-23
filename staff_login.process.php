<?php
 if (isset($_POST["login-submit"])) {
   require "connection.php";

   $uid=$_POST["userID"];
   $pswd=$_POST["pass"];

   if(empty($uid) || empty($pswd))
   {
     header("Location:staff.login.php?error=emptyfields");
     exit();
   }
   else {
     $sql = "SELECT * FROM staff_login WHERE s_ssn=?";
     $stmt= mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt,$sql)) {
       header("Location:staff.login.php?error=sqlerror");
     }
     else {
       mysqli_stmt_bind_param($stmt, "s", $uid);
       mysqli_stmt_execute($stmt);
       $result= mysqli_stmt_get_result($stmt);
       if ($row = mysqli_fetch_assoc($result)) {
         {
           if($pswd !== $row["pass"]){
                header("Location:staff.login.php?error=wrongpass");
                exit();
                  }
          else if ($pswd == $row["pass"]) {
            session_start();
            $_SESSION["userID"] = $row["s_ssn"];
            $_SESSION["uc"]="3";
            header("Location:sdashboard.php");
            exit();
          }
          else {
            header("Location:staff.login.php?error=wrongpass");
            exit();
          }
         }
       }
       else {
         header("Location:staff.login.php?error=nouser");
         exit();
       }
     }
   }
 }
 else{
   header("Location:index.php");
   exit();
 }
 ?>
