<?php
    session_start();
    $course = "";
    $groupname = "";
    $groupid = "";

    if(isset($_POST["submit"])){
        if(isset($_POST["course"])){
            $course = $_POST["course"];
        }
        if(isset($_POST["groupname"])){
            $groupname = $_POST["groupname"];
        }
        if(isset($_POST["groupid"])){
            $groupid = $_POST["groupid"];
        }

        require_once("db.php");

        $sql = "INSERT INTO `group`(group_id, group_name, course_course_id) VALUES ('".$groupid."', '".$groupname."', '".$course."');";
        $result = $mydb->query($sql);
        if($result == 1){
            echo "<script>
                alert('The group has been created successfully.');
                window.location.href='add_group_mem.php';
                </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU Create Peer Eval Group</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Inter&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/create_group.css">
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
        <h2>Create Peer Evaluation Group</h2>
    </div>

    <div class="content">
        <div class="courses">
            <form method="post" action="">
                <h2>Select a Course</h2>
                <table>
                    <thead>
                        <th>
                            Select
                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            Course Name
                        </th>
                        <th>
                            Semester
                        </th>
                        <th>
                            Year
                        </th>
                    </thead>
                    <?php
                        $smu_id = $_SESSION["smu_id"];
                        require_once("db.php");

                        $sql = "SELECT course_id, course_name, course_semester, course_year FROM course WHERE professor_smu_id = '".$smu_id."';";
                        $result = $mydb->query($sql);

                        while($row = mysqli_fetch_array($result)){
                            echo "<tr> <td> <input type='radio' id='".$row["course_id"]."' name='course' value='".$row["course_id"]."'> </td> <td>".$row["course_id"]."</td> <td>".$row["course_name"]."</td> <td>".$row["course_semester"]."</td> <td>".$row["course_year"]."</td></tr>";
                        }
                    ?>
                </table>
            <h4 class="groupname">New Group Name:</h4>
            <input type="text" name="groupname" id="groupname">
            <h4 class="groupid">New Group ID:</h4>
            <input type="text" name="groupid" id="groupid">
            <input type="submit" name="submit" id="submit" value="Create New Group">
        </form>
    </div> 
</body>
</html>