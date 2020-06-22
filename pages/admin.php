<?php
  session_start();
  if (!isset($_SESSION['userId'])){
    header("Location: ../admlogin.php?session=expired");
  } else {
    $inactiveTime = 0;
    if(!isset($_SESSION['actionTime'])){
      header("Location: ../admlogin.php?session=expired");
    } else {
      $inactiveTime = time() - $_SESSION['actionTime'];
      $expire = 10 * 60;

      if ($inactiveTime > $expire) {
        session_unset();
        header("Location: ../admlogin.php?session=expired");
      }
    }
  }
$_SESSION['actionTime'] = time();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Donnelly Library</title>
    <meta name="viewport" contect="width-device-width, initial scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Poppins:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styleadmin.css">
  </head>

  <body>
    <header>
      <a href="admin.php" class="header-brand">Admin Page</a>
      <nav>
        <ul>
          <li><a href="newstaff.php">New Staff</a></li>
          <li><a href="newstd.php">New Student</a></li>
          <li><a href="allstaff.php">Staff</a></li>
          <li><a href="allstudents.php">Students</a></li>
          <li><a href="timesheet.php">Timesheet</a></li>
        </ul>
        <div class="logout-button">
          <form action="../includes/logout.inc.php" method="post">
            <button class="logout-button" type="submit" name="logout-button">Log Out</button>
          </form>
        </div>
      </nav>
    </header>

    <main>
      <h2>Admin Page</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ac mi justo. Fusce diam lorem, vulputate et dapibus nec, faucibus in ipsum. Maecenas ultricies nisi consectetur pretium tincidunt. In sed augue ut ante mattis mattis in eget lorem. Nulla facilisi. Pellentesque eros arcu, ornare sit amet efficitur in, sodales et sapien. Donec molestie, enim a commodo aliquet, enim odio blandit risus, et tincidunt turpis lorem id nulla. Ut tristique sapien magna, at volutpat tellus porta at. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus elit turpis, feugiat eget pulvinar vitae, elementum imperdiet est. Maecenas eu laoreet arcu, id rutrum augue. Sed a elit convallis arcu efficitur sodales id sed ante.
      </p>
      <p>
        Vestibulum at interdum tortor, ut efficitur ante. Nullam ut nunc nunc. Aenean consequat odio nisi, id bibendum mi vehicula nec. Curabitur euismod sit amet velit nec feugiat. Nulla at dolor et metus pellentesque suscipit id a lorem. Nullam vitae tempus metus. Curabitur porta elit quis nunc ornare mollis. Donec eget maximus dui. Sed ligula velit, vulputate et leo eget, ullamcorper vestibulum dolor. Mauris nisl mi, vulputate ut nunc ut, laoreet euismod nisi. Aenean sit amet ipsum congue, aliquam enim eget, maximus ligula. Suspendisse at dapibus augue. Suspendisse molestie nibh vitae tortor accumsan tempor nec et odio.
      </p>
      <p>
        Donec congue varius quam, at sodales tellus lacinia sit amet. Cras non tortor felis. Quisque vehicula risus dui, eu dictum velit ornare vitae. Aliquam lacus ligula, vestibulum a condimentum sit amet, accumsan vitae orci. Etiam laoreet eros vitae bibendum iaculis. In hac habitasse platea dictumst. Ut varius sem ut porttitor egestas. Nunc ut nunc vestibulum, porta elit porta, aliquam ligula. Nulla purus lacus, sollicitudin sed tellus id, vestibulum bibendum nisi. Suspendisse non leo feugiat, dictum massa nec, vehicula nisl. Morbi ac nisi et elit maximus volutpat et id nulla.
      </p>
      <p>
        Donec ex nibh, varius ac porta et, dapibus vitae libero. Nam quis mi lacus. Duis auctor dolor turpis, et sagittis justo tincidunt nec. Praesent vel dui varius elit bibendum aliquam. Nunc consectetur mattis massa, a feugiat nisi placerat eget. Suspendisse potenti. Aenean nibh quam, finibus ut risus a, eleifend efficitur augue. Aenean vel massa metus. Praesent ultricies tempor ligula nec congue. Curabitur semper turpis at mattis consectetur. Quisque vitae est tellus. Sed risus urna, porta sed lorem eu, placerat ultrices diam.
      </p>
      <p>
        Sed a massa lorem. Nulla aliquam sagittis elit vel facilisis. Donec dictum et ante quis dictum. Sed eleifend, tellus a lobortis euismod, felis ante sagittis est, eu mattis lacus arcu sit amet mi. Praesent nulla turpis, mollis eu dignissim sed, volutpat ac felis. Morbi egestas tellus a elit fermentum tristique. Vivamus scelerisque risus lacus, quis vulputate elit vulputate nec. Fusce sodales mauris non fermentum ornare. Sed nulla lacus, posuere vitae turpis vitae, mollis auctor velit. Fusce semper nunc in ante volutpat, ut faucibus magna congue. Etiam tempus quam vel blandit venenatis. Curabitur bibendum pulvinar orci, quis blandit est consequat ut.
      </p>
      <p>
        Aliquam tristique urna quis massa vestibulum commodo. Donec laoreet auctor lectus imperdiet dictum. Quisque purus quam, porttitor sit amet lobortis ac, tincidunt vitae arcu. Quisque lacus mauris, faucibus vitae semper nec, vulputate eget neque. Nam feugiat placerat ante, ut consequat libero tempus congue. Proin fermentum mi quis turpis vulputate, in vulputate augue condimentum. Phasellus gravida a orci ut vehicula. Aliquam euismod id neque et venenatis. Nulla vel scelerisque metus, id posuere tellus
      </p>
    </main>
