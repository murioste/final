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
          <h2>Instructions for Student Employees</h2>
          <p>
            Please clock in and out on time. If you need to go on a lunch break,
            make sure you clock out as lunch time does not count as time on the
            clock. If you need to change your time, please contact your supervisor
            so they can make any necessary changes.
          </p>
          <br>
          <p>
            Please contact your computer administration to create your account
            so you can log your time-in and time-out. If you are having any trouble,
            please contact your computer administration. Make sure
          </p>
        </section>

        <section class="login-box">
          <h2>Student Login</h2>
          <form class="login" action="includes/stdlogin.inc.php" method="post">
            <!-- <h3>Student Username:</h3> -->
            <input type="text" name="std-uid" placeholder="username">
            <!-- <h3>Student Password:</h3> -->
            <input type="password" name="std-pwd" placeholder="password">
            <div class="login-button">
              <button class="login-button" type="submit" name="clockin">Clock In</button>
              <button type="submit" name="clockout">Clock Out</button>
            </div>
          </form>
          <a href="stdpassword.php">Forgot your password?</a>
        </section>
      </div>
    </main>
