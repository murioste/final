<?php
//This is used to varify if a button was clicked to access this page.
if(isset($_POST['clockin']) || isset($_POST['clockout'])) {

//This will require the dbh.inc.php and allow for connection to database.
  require 'dbh.inc.php';

//These two variables will be used to get input from the webpage
  $username = $_POST['std-uid'];
  $password = $_POST['std-pwd'];

//This statement will check if any field was empty.
  if (empty($username) || empty($password)) {
    header("Location: ../stdlogin.php?error=emptyfields");
    exit();
  } else {
/*If the statement is false and both inputs had values then the following code
will prepare our sql querry to verify if the username and password locale_filter_matches
what is in the database.*/

//This is the querry we want to send for information.
    $sql = "SELECT * FROM student_employee WHERE Username=? OR Email=?;";
//initializes the statemnt with the connection.
    $stmt = mysqli_stmt_init($conn);
/*This will check if the statement is valid by running the statement to the
database and verifying if it works*/
    if (!mysqli_stmt_prepare($stmt,$sql)) {
      header("Location: ../stdlogin.php?error=sqlerror");
      exit();
    } else {
/*This will bind the parameters and cause them to be strings to prevent
hackers from sending in their code.*/
      mysqli_stmt_bind_param($stmt, "ss", $username, $username);
//This executes the code with the database.
      mysqli_stmt_execute($stmt);
//This returns results into a variable that we can test.
      $result = mysqli_stmt_get_result($stmt);
//This will associate fetched results with the return array.
      if ($row = mysqli_fetch_assoc($result)) {
//This bool function will test if passwords match.
        $pwdCheck = password_verify($password, $row['Password']);
//If passwords dont match then it will output an error in url.
        if ($pwdCheck == false) {
          header("Location: ../stdlogin.php?error=wrongpwd");
          exit();
        } else if ($pwdCheck == true) {
          date_default_timezone_set('America/Denver');
          $currentDate = date("Y-m-d");
          $currentTime = date("H:i");
//Get amount of clockins for the day
          $sql = "SELECT * FROM Timein
                  INNER JOIN student_employee on student_employee.WS_ID = Timein.WS_ID
                  WHERE Username=? OR Email=? AND Date=$currentDate;";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../stdlogin.php?error=sqlerror");
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "ss", $username, $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $loginResult = mysqli_stmt_num_rows($stmt);
            print_r ($loginResult);
          }
//Get amount of clockouts for the day.
          $sql = "SELECT * FROM Timeout
                  INNER JOIN student_employee on student_employee.WS_ID = Timeout.WS_ID
                  WHERE Username=? OR Email=? AND Date=$currentDate;";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../stdlogin.php?error=sqlerror");
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "ss", $username, $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $logoutResult = mysqli_stmt_num_rows($stmt);
            print_r ($logoutResult);
          }

          if (isset($_POST['clockin'])) {
            //To see if student logged in
              if ($loginResult == $logoutResult) {
                $sql = "INSERT INTO timein (WS_ID, Date, Time_In) VALUES (?,?,?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                  header("Location: ../stdlogin.php?error=sqlerror");
                  exit();
                } else {
                  mysqli_stmt_bind_param($stmt, "iss", $row['WS_ID'], $currentDate, $currentTime);
                  mysqli_stmt_execute($stmt);
                  header("Location: ../stdlogin.php?clockin=success");
                  exit();
                  }
              } else {
                header("Location: ../stdlogin.php?error=loggedin");
                exit();
              }
            }elseif (isset($_POST['clockout'])) {
              //To see if student logged out
              if (($loginResult - 1) == $logoutResult) {
                  $sql = "INSERT INTO timeout (WS_ID, Date, Time_Out) VALUES (?,?,?);";
                  $stmt = mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt,$sql)) {
                  header("Location: ../stdlogin.php?error=sqlerror");
                }
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                  header("Location: ../stdlogin.php?error=sqlerror");
                  exit();
                } else {
                  mysqli_stmt_bind_param($stmt, "iss", $row['WS_ID'], $currentDate, $currentTime);
                  mysqli_stmt_execute($stmt);
                  header("Location: ../stdlogin.php?clockout=success");
                  exit();
                }
              }else {
                header("Location: ../stdlogin.php?error=loggedout");
                exit();
              }
            }
    }
      } else {
          header("Location: ../stdlogin.php?error=nouser");
          exit();
    }
  }
}

} else {
  header("Location: ../stdlogin.php");
  exit();
}

//closes isset
