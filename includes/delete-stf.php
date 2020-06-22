<?php
if (isset($_POST['delete-stf'])){

  require 'dbh.inc.php';

  $delstf = $_POST['del-stf'];
  foreach($delstf as $id){
    mysqli_query($conn,"DELETE FROM staff WHERE staff.Admin_ID=".$id);
  }
header("Location:../pages/allstaff.php?delete=success");
}
