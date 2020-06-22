<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Donnelly Library</title>
    <meta name="viewport" contect="width-device-width, initial scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Poppins:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylelogin.css">
  </head>

  <body>
    <header>
      <a href="index.php" class="header-brand">Donnelly Library</a>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="stdlogin.php">Student Login</a></li>
          <li><a href="admlogin.php">Admin Login</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <div class="back">
        <section class="info-box">
          <h2>Instruction For Admin</h2>
          <p>
            Please input your username/email and password in the provided input
            area. Please make sure that you are a user in the database. Make sure to
            contact your computer admin to create your account. If you are having
            trouble loging in, please contact your computer admin to make sure
            your account still exists and has not expired.
          </p>
        </section>

        <section class="login-box">
          <h2>Reset Password</h2>
          <form class="login" action="includes/resetpwdstf.inc.php" method="post">
            <input type="text" name="email" placeholder="Enter your e-mail...">
            <div class="login-button">
              <button class="reset-button" type="submit" name="reset-submit">Submit</button>
            </div>
          </form>
          <?php
            if (isset($_GET['reset'] == 'success')) {
              echo '<p class="success">Check your e-mail</p>'
            }
           ?>
        </section>
      </div>
    </main>
