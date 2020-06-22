<?php
if (isset($_SESSION['student-user'])){
  if(empty($_SESSION['timeInRows']) == 0){
    echo "<table>";
      echo "<tr>";
        echo "<th>Clock-in Date</th>";
        echo "<th>Clock-in Time</th>";
        echo "<th>Clock-out Date</th>";
        echo "<th>Clock-out Time</th>";
        echo "<th>Total Time</th>";
      echo "</tr>";

      if (!isset($_SESSION['timeOutRows'])) {
        printf ('<tr> <td>%s</td> <td>%s</td> <td></td> <td></td> <td></td> </tr>',
        $_SESSION['timeInRows'][0][0], $_SESSION['timeInRows'][0][1]);
      } else{
        if (count($_SESSION['timeOutRows']) !== count($_SESSION['timeInRows'])){
          $i=0;
          $totalHr=0;
          $totalMin=0;
          foreach($_SESSION['timeOutRows'] as $row) {
            $strTime = new DateTime($_SESSION['timeInRows'][$i][1]);
            $endTime = new DateTime($_SESSION['timeOutRows'][$i][1]);
            $duration = $strTime->diff($endTime);
            printf ('<tr> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>',
            $_SESSION['timeInRows'][$i][0], $_SESSION['timeInRows'][$i][1],
            $_SESSION['timeOutRows'][$i][0], $_SESSION['timeOutRows'][$i][1],
            $duration->format("%H:%I:%S"));

            $totalHr += ((int)(date("H",strtotime($duration->format("%H:%I:%S")))));
            $totalMin += ((int)(date("i",strtotime($duration->format("%H:%I:%S")))));
            $i++;
        }
        $i = count($_SESSION['timeInRows']) - 1;
        printf ('<tr> <td>%s</td> <td>%s</td> <td></td> <td></td> <td></td> </tr>',
        $_SESSION['timeInRows'][$i][0], $_SESSION['timeInRows'][$i][1]);

        if ($totalMin/60 > 1) {
          $totalHr += floor($totalMin/60);
          $totalMin = $totalMin % 60;
          echo ("<h4>Total Time : ".$totalHr.":".$totalMin."</h4>");
        } else {
          echo ("<h4>Total Time : ".$totalHr.":".$totalMin."</h4>");
        }
      } else if (count($_SESSION['timeOutRows']) == count($_SESSION['timeInRows'])) {
          $i=0;
          $totalHr=0;
          $totalMin=0;
          foreach($_SESSION['timeInRows'] as $row) {
            $strTime = new DateTime($_SESSION['timeInRows'][$i][1]);
            $endTime = new DateTime($_SESSION['timeOutRows'][$i][1]);
            $duration = $strTime->diff($endTime);
            printf ('<tr> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>',
            $_SESSION['timeInRows'][$i][0], $_SESSION['timeInRows'][$i][1],
            $_SESSION['timeOutRows'][$i][0], $_SESSION['timeOutRows'][$i][1],
            $duration->format("%H:%I:%S"));
            $totalHr += ((int)(date("H",strtotime($duration->format("%H:%I:%S")))));
            $totalMin += ((int)(date("i",strtotime($duration->format("%H:%I:%S")))));
            $i++;
        }
        if ($totalMin/60 > 1) {
          $totalHr += floor($totalMin/60);
          $totalMin = $totalMin % 60;
          echo ("<h4>Total Time : ".$totalHr.":".$totalMin."</h4>");
        } else {
          echo ("<h4>Total Time : ".$totalHr.":".$totalMin."</h4>");
        }
      } else {
          header("Location: ../pages/timesheet.php?error=notable");
        }
    }
      unset($_SESSION['timeOutRows'],$_SESSION['timeInRows'],$_SESSION['student-user'] );
  }
}
?>
