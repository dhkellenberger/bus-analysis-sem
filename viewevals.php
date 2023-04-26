<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU Student Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Inter&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/viewevals.css">
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
    <!-- End of desktop nav menu -->

    <div class="banner">
        <a href="default.html"><img src="images/back-arrow.png" alt="" width="70px" height="70px"></a>
        <h2>View My Evaluations</h2>
    </div>

    <div class="content">
        <form action="">
            <table>
                <thead>
                    <th>
                        Date
                    </th>
                    <th>
                        Class ID
                    </th>
                    <th>
                        Total Points
                    </th>
                </thead>
                <?php
                    $smu_id = $_SESSION["smu_id"];
                    require_once("db.php");

                    $sql = "SELECT peer_evaluation_date, course_course_id, total_grade FROM peer_evaluation WHERE student_receiver_smu_id = '".$smu_id."';";
                    $result = $mydb->query($sql);

                    while($row = mysqli_fetch_array($result)){
                        echo "<tr> <td>".$row['peer_evaluation_date']."</td> <td>".$row["course_course_id"]."</td> <td>".$row["total_grade"]."</td></tr>";
                    }
                ?>
            </table>
        </form>
    </div>


    <div class="footer">
        <header>
            
        </header>
    </div>
    
</body>
</html>