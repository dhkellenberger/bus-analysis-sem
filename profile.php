<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU Student Peer Reviews</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Inter&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/profile.css">
</head>

  <body>
    <header>
      <div class="menubar">
          <nav>
              <div class="logo">Singapore Management University <br> Student Peer Reviews</div>
              <ul>
                  <li>
                      <a href="default.html"><img src="images/home.png" alt="" width="75px" height="75px"></a>
                      <a href="default.html">SMU Home</a>
                  </li>
                  <li>
                      <a href="account.php"><img src="images/user.png" alt="" width="75px" height="75px"></a>
                      <a href="account.php">Account</a>
                  </li>
                  <li>
                      <a href="reports.php"><img src="images/bar-chart.png" alt="" width="75px" height="75px"></a>
                      <a href="reports.php">Reports</a>
                  </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="banner">
        <a href="default.html"><img src="images/back-arrow.png" alt="" width="70px" height="70px"></a>
        <h2>Your Account</h2>
    </div>


    <div class="content">
      <form>
        <div class="left">
          <label for="id">ID Number</label>
          <?php
            $smu_id = $_SESSION["smu_id"];

            echo '<input type="text" id="id" name="id" value="'.$smu_id.'" readonly><br>';
          ?>
          <label for="name">Name</label>
          <?php
            $smu_id = $_SESSION["smu_id"];

            require_once("db.php");
            $sql = "SELECT first_name, last_name FROM student WHERE smu_id = '".$smu_id."';";
            $result = $mydb->query($sql);
            $row = mysqli_fetch_array($result);
            if(empty($row)){
              require_once("db.php");
              $sql = "SELECT first_name, last_name FROM professor WHERE smu_id = '".$smu_id."';";
              $result = $mydb->query($sql);
              $row = mysqli_fetch_array($result);
              if($result == 1){
                echo '<input type="text" id="name" name="name" value="'.$row['first_name'].''.$row['last_name'].'" readonly><br>';
              }
            } else {
              echo '<input type="text" id="name" name="name" value="'.$row['first_name'].''.$row['last_name'].'" readonly><br>';
            }
            
          ?>
        </div>
        <div class="right">
          <label for="major">Major/Department</label>
          <?php
            $smu_id = $_SESSION["smu_id"];

            require_once("db.php");
            $sql = "SELECT major FROM student WHERE smu_id = '".$smu_id."';";
            $result = $mydb->query($sql);
            $row = mysqli_fetch_array($result);
            if(empty($row)){
              require_once("db.php");
              $sql = "SELECT department FROM professor WHERE smu_id = '".$smu_id."';";
              $result = $mydb->query($sql);
              $row = mysqli_fetch_array($result);
              if($result == 1){
                echo '<input type="text" id="major" name="major" value="'.$row['department'].'" readonly><br>';
              } 
            } else {
              echo '<input type="text" id="major" name="major" value="'.$row['major'].'" readonly><br>';
            }
            
          ?>
          <label for="year">Academic Year</label>
          <?php
            $smu_id = $_SESSION["smu_id"];

            require_once("db.php");
            $sql = "SELECT academic_year FROM student WHERE smu_id = '".$smu_id."';";
            $result = $mydb->query($sql);
            $row = mysqli_fetch_array($result);
            if(empty($row)){
              echo '<input type="text" id="year" name="year" value="N/A" readonly><br>';
            } else {
              echo '<input type="text" id="year" name="year" value="'.$row['academic_year'].'" readonly><br>';
            }
          ?>
        </div>
        <div class="bottom">
          <label for="email">Email</label>
          <?php
            $smu_id = $_SESSION["smu_id"];

            require_once("db.php");
            $sql = "SELECT student_email FROM student WHERE smu_id = '".$smu_id."';";
            $result = $mydb->query($sql);
            $row = mysqli_fetch_array($result);
            if(empty($row)){
              require_once("db.php");
              $sql = "SELECT professor_email FROM professor WHERE smu_id = '".$smu_id."';";
              $result = $mydb->query($sql);
              $row = mysqli_fetch_array($result);
              if($result == 1){
                echo '<input type="text" id="email" name="email" value="'.$row['professor_email'].'" readonly><br>';
              }
            } else {
              echo '<input type="text" id="email" name="email" value="'.$row['student_email'].'" readonly><br>';
            } 
          ?>
        </div>   
      </form>
    </div>  
  </body>
</html>







