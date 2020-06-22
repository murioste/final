<?php
if (isset($_POST['delete-std'])){

  require 'dbh.inc.php';

  $delstd = $_POST['del-std'];
  foreach($delstd as $id){
    mysqli_query($conn,"DELETE FROM student_employee WHERE student_employee.WS_ID=".$id);
    mysqli_query($conn,"DELETE FROM timein WHERE timein.WS_ID=".$id);
    mysqli_query($conn,"DELETE FROM timeout WHERE timeout.WS_ID=".$id);
  }
header("Location:../pages/allstudents.php?delete=success");
}
