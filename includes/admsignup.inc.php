<?php

if (isset($_POST['newstf-submit'])) {

  require 'dbh.inc.php';

  $firstName = $_POST['fname'];
  $lastName = $_POST['lname'];
  $department = $_POST['department'];
  $userID = $_POST['idnum'];
  $email = $_POST['mail'];
  $phone = $_POST['phone'];
  $username = $_POST['uid'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  if (empty($firstName) || empty($lastName) || empty($department) || empty($userID) || empty($email) || empty($phone) || empty($username) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../pages/newstaff.php?error=emptyfields");
    exit();
  } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../pages/newstaff.php?error=invaliduid");
    exit();
  } else if ($password !== $passwordRepeat) {
    header("Location: ../pages/newstaff.php?error=passwordcheck");
    exit();
  } else {

      $sql = "SELECT Username FROM staff WHERE Username=?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../pages/newstaff.php?error=sqlerror");
        exit();
      } else {
          mysqli_stmt_bind_param($stmt, "s", $username);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if ($resultCheck > 0) {
            header("Location: ../pages/newstaff.php?error=userexists");
            exit();
          }else{
        $sql = "INSERT INTO staff (Department_ID, First_Name, Last_Name, ID_Number, Email, Phone, Username, Password) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
          header("Location: ../pages/newstaff.php?error=sqlerror");
          exit();
        } else {
          $hashedPwd = password_hash($password,PASSWORD_DEFAULT);

          mysqli_stmt_bind_param($stmt, "isssssss", $department, $firstName, $lastName, $userID, $email, $phone, $username, $hashedPwd);
          mysqli_stmt_execute($stmt);
          header("Location: ../pages/newstaff.php?signup=success");
          exit();
        }
      }
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  // This create more security but not needed for my project. It checks for valid email
  // else if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
  //   header("Location: ../newstaff.php?error=invalidmail")
  //   exit();
  // }
}
else {
  header("Location: ../pages/newstaff.php");
  exit();
}
