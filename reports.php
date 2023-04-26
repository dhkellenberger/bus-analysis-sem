<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU View Student Group Members</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Inter&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/reports.css">
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
        <a href="prof_dashboard.html"><img src="images/back-arrow.png" alt="" width="70px" height="70px"></a>
        <h2>View Reports</h2>
    </div>

    <div class="content">
        <div class="selectgm">
            <form method="post" action="">
                <h3>Select a Report to View</h3>
                <select name="groupname" id="groupname">
                    <option value="">Select a Report to View</option>
                    <option value="1">Average GLO Grade - Entire University</option>
                    <option value="2">Average GLO Grade by Course</option>
                    <option value="3">Average GLO Grade by Student (Anonymous)</option>
                    <option value="4">Number of Students Taught by Each Professor</option>
                    <option value="5">Students Assigned to Groups vs. Students Not Assigned</option>
                    <option value="6">Number of Students Using System</option>
                    <option value="7">Peer Evals Scheduled by Professor</option>
                    <option value="8">Peer Evals Scheduled by Course</option>
                    <option value="9">Peer Evals Scheduled Over Time</option>
                </select>
                <p>*Reports are not live at this time.*</p>
                <input type="submit" name="populate" id="populate" value="Show Report">
            </form>
        </div>
        <div class="report">
            <?php
                $reportnum = "";

                if(isset($_POST['populate'])){
                    if(isset($_POST['groupname'])){
                        $reportnum = $_POST['groupname'];

                        if($reportnum == 1){
                            echo '<img src="graphs/average glo total.png" alt="">';
                        }
                        if($reportnum == 2){
                            echo '<img src="graphs/average glo course.png" alt="">';
                        }
                        if($reportnum == 3){
                            echo '<img src="graphs/average glo student.png" alt="">';
                        }
                        if($reportnum == 4){
                            echo '<img src="graphs/students per prof.png" alt="">';
                        }
                        if($reportnum == 5){
                            echo '<img src="graphs/assigned vs not assigned groups.png" alt="">';
                        }
                        if($reportnum == 6){
                            echo '<img src="graphs/system total.png" alt="">';
                        }
                        if($reportnum == 7){
                            echo '<img src="graphs/peer eval by prof.png" alt="">';
                        }
                        if($reportnum == 8){
                            echo '<img src="graphs/peer evals by course.png" alt="">';
                        }
                        if($reportnum == 9){
                            echo '<img src="graphs/students assigned to groups over time.png" alt="">';
                        }
                    }
                }
            ?>
        </div>
    </div> 
</body>
</html>