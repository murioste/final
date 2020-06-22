<?php
  require 'dbh.inc.php';

  $sql = "SELECT Admin_ID, Department_Name, First_Name, Last_Name, ID_Number, Email, Phone, Username FROM staff
          INNER JOIN departments on staff.Department_ID = departments.Department_ID
          ORDER BY Department_Name, Last_Name;";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  if ($resultCheck > 0) {
    echo "<table>";
    echo "<tr>";
      echo "<th>Select</th>";
      echo "<th>Department Name</th>";
      echo "<th>First Name</th>";
      echo "<th>Last Name</th>";
      echo "<th>ID Number</th>";
      echo "<th>E-Mail</th>";
      echo "<th>Phone Number</th>";
      echo "<th>Username</th>";
    echo "</tr>";

    while($row = mysqli_fetch_assoc($result)){
      printf ("<tr> <td><input type='checkbox' name='del-stf[]' value='".$row["Admin_ID"]."'> </td> <td>%s</td> <td>%s</td>
      <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td></tr>",
      $row['Department_Name'],$row['First_Name'],$row['Last_Name'],$row['ID_Number'],
      $row['Email'],$row['Phone'],$row['Username']);
    }
    echo "</table>";
    echo "<button type='submit' name='delete-stf'>Delete User</button>";
  }
