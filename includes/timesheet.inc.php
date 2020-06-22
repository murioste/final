<?php
session_start();

if (isset($_POST['time-submit'])) {

  require 'dbh.inc.php';

  $username = $_POST['username'];
  $beginningDate = $_POST['bdate'];
  $endingDate = $_POST['edate'];

  if (empty($username) || empty($beginningDate) || empty($endingDate)) {
    header("Location: ../pages/timesheet.php?error=emptyfields");
    exit();
  } else {
    $sql = "SELECT Username FROM student_employee WHERE Username=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: ../pages/timesheet.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck !== 1) {
        header("Location: ../pages/timesheet.php?error=nouser");
        exit();
      } else {
        $_SESSION['student-user'] = $username;
        $sql = "SELECT Date, Time_In FROM timein
                INNER JOIN student_employee ON timein.WS_ID = student_employee.WS_ID
                WHERE student_employee.Username=? AND Date Between ? AND ?
                ORDER BY Date, Time_In;";

         $stmt = mysqli_stmt_init($conn);
         if (!mysqli_stmt_prepare($stmt,$sql)){
           header("Location: ../pages/timesheet.php?error=sqlerror");
           exit();
         } else {
           mysqli_stmt_bind_param($stmt, "sss", $username, $beginningDate, $endingDate);
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           $i = 0;
           while($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
              $timeInResult[$i] = $row;
              $i++;
           }
           $_SESSION['timeInRows'] = $timeInResult;
         }

         $sql = "SELECT Date, Time_Out FROM timeout
                 INNER JOIN student_employee ON timeout.WS_ID = student_employee.WS_ID
                 WHERE student_employee.Username=? AND Date Between ? AND ?
                 ORDER BY Date, Time_Out;";

          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../pages/timesheet.php?error=sqlerror");
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "sss", $username, $beginningDate, $endingDate);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $i = 0;
            while($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
               $timeOutResult[$i] = $row;
               $i++;
            }
            $_SESSION['timeOutRows'] = $timeOutResult;
          }

        $sql = "SELECT SUBTIME(SUM(Time_Out), SUM(Time_In)) FROM timein
                INNER JOIN student_employee ON timein.WS_ID = student_employee.WS_ID
                INNER JOIN timeout on timein.WS_ID = timeout.WS_ID
                WHERE student_employee.Username=? AND timein.Date Between ? AND ?
                GROUP BY TI_ID;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)){
          header("Location: ../pages/timesheet.php?error=sqlerror");
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "sss", $username, $beginningDate, $endingDate);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $i = 0;
          while($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
             $timeTimeResult[$i] = $row;
             $i++;
          }
          $_SESSION['timeTotalRows'] = $timeTimeResult;
        }
      header("Location: ../pages/timesheet.php?search=success");
    }
  }
}
}
