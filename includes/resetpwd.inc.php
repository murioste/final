<?php

  if (isset($_POST['reset-pwd-submit'])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

    if (empty($password) || $passwordRepeat) {
      header(Location: "../createnewpassword.php?newpwd=empty");
      exit()
    } else if ($password != $passwordRepeat){
      header(Location: "../createnewpassword.php?newpwd=notsame");
      exit()
    }

    $currentDate = date("U");

    require 'dbh.inc.php';

    $sql = "SELECT * FROM Password_Reset WHERE Password_Reset_Selector=? AND Password_Reset_Expire >= ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
      header("Location: ../createnewpassword.php?error=sql");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss" , $selector,$currentDate);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      if (!$row = mysqli_fetch_assoc($result)){
        header("Location: ../createnewpassword.php?error=expired");
        exit();
      } else {
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row["Password_Reset_Token"]);

        if ($tokenCheck === false) {
          header("Location: ../createnewpassword.php?error=expired");
          exit();
        } else if ($tokenCheck === true) {

          $tokenEmail = $row['Password_Reset_Email'];

          $sql = "SELECT * FROM staff WHERE Email=?;";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../createnewpassword.php?error=sql");
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)){
              header("Location: ../createnewpassword.php?error=expired");
              exit();
            } else {

              $sql = "UPDATE staff SET Password=? WHERE Email=?";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt,$sql)) {
                header("Location: ../createnewpassword.php?error=sql");
                exit();
              } else {
                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                mysqli_stmt_execute($stmt);

                $sql = "DELETE FROM Password_Reset WHERE Password_Reset_Email=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                  header("Location: ../admpassword.php?error=sql");
                  exit();
                } else {
                  mysqli_stmt_bind_param($stmt, "s" , $userEmail);
                  mysqli_stmt_execute($stmt);
                  header("Location: ../admlogin.php?newpwd=success");
                }

              }
            }
        }
      }
    }


  } else {
    header(Location: "../admpassword.php")
  }
