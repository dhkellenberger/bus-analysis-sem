<?php
    session_start();
    $course = "";
    $date = "";
    $students = array();

    if(isset($_POST['submit'])){
        if(isset($_POST['course'])){
            $course = $_POST['course'];
        }   

        if(isset($_POST['date'])){
            $date = $_POST['date'];
        }
            
        require_once("db.php");

        $sql = "SELECT student_smu_id FROM enrollment WHERE course_course_id = '$course';";
        $result = $mydb->query($sql);
        while($row = mysqli_fetch_array($result)){
            array_push($students, $row);
        }
            
        if(!empty($course) && !empty($date) && !empty($students)){
            foreach($students as $id){
                require_once("db.php");
                $sql = "INSERT INTO peer_evaluation(student_writer_smu_id, course_course_id, due_date) VALUES ('$id[0]', '$course', '$date');";
                $result = $mydb->query($sql);
                if($result == 1){
                    echo '<script>alert("Your Peer Evalution has been scheduled.")</script>';
                }    
            }
        }         
    }
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
    <link rel="stylesheet" href="styles/schedule.css">
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
        <h2>Schedule Peer Evaluations</h2>
    </div>

    <div class="content">
        <h2>Schedule Evaluations for Selected Course</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="course">Select Course</label>
            <select name="course" id="course">
                <option value="">Select a Course</option>
                <?php
                    $smu_id = $_SESSION['smu_id'];

                    require_once('db.php');
                    $sql = "SELECT course_id, course_name FROM course WHERE professor_smu_id = '".$smu_id."';";
                    $result = $mydb->query($sql);

                    while($row = mysqli_fetch_array($result)){
                        echo "<option value='".$row['course_id']."'>".$row['course_name']."</option>";
                    }
                ?>
            </select>
            <p>*Professors can only schedule evaluations for their own courses*</p>
            <label class="date-label" for="date">Due Date</label>
            <input class="date" type="date" name="date">
            <input class="submit" type="submit" name="submit" value="Schedule Evaluation">
        </form>
    </div>

</body>
</html>