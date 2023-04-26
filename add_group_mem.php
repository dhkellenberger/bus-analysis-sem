<?php
    session_start();
    $group = "";
    $student_id = "";

    if(isset($_POST["submit"])){
        if(isset($_POST["group"])){
            $group = $_POST["group"];
        }
        if(isset($_POST["student"])){
            $student_id = $_POST["student"];
        }

        require_once("db.php");

        $sql = "INSERT INTO membership(group_group_id, student_smu_id) VALUES ('".$group."', '".$student_id."');";
        $result = $mydb->query($sql);
        if($result == 1){
            echo '<script>alert("The student has been added to the group successfully")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU Add Group Members</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Inter&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/add_group_mem.css">
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
        <h2>Add Group Members</h2>
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
            <input type="submit" name="populate" id="populate" value="Show Groups & Students in Class">
            </form>
        </div>
        <div class="group-students">
            <form method="post" action="">
                <h2>Groups in Course</h2>
                <table id="groups" name="groups">
                    <thead>
                        <th>
                            Select
                        </th>
                        <th>
                            Group ID
                        </th>
                        <th>
                            Group Name
                        </th>
                    </thead>
                    <?php
                        $course = "";

                        if(isset($_POST["populate"])){
                            if(isset($_POST["course"])){
                                $course = $_POST["course"];
                            }

                            require_once("db.php");

                            $sql = "SELECT group_id, group_name FROM `group` WHERE course_course_id = '".$course."';";
                            $result = $mydb->query($sql);

                            while($row = mysqli_fetch_array($result)){
                                echo "<tr> <td> <input type='radio' id='".$row["group_id"]."' name='group' value='".$row["group_id"]."'> </td> <td>".$row["group_id"]."</td> <td>".$row["group_name"]."</td></tr>";
                            }
                        }
                    ?>
                </table>
                <h3>Students in Course</h3>
                <table id="students" name="students">
                    <thead>
                        <th>
                            Select
                        </th>
                        <th>
                            First Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            Email
                        </th>
                    </thead>
                    <?php
                        $course = "";

                        if(isset($_POST["populate"])){
                            if(isset($_POST["course"])){
                                $course = $_POST["course"];
                            }

                            require_once("db.php");

                            $sql = "SELECT smu_id, first_name, last_name, student_email FROM student INNER JOIN enrollment ON student.smu_id = enrollment.student_smu_id WHERE enrollment.course_course_id = '".$course."';";
                            $result = $mydb->query($sql);

                            while($row = mysqli_fetch_array($result)){
                                echo "<tr> <td> <input type='radio' id='".$row["smu_id"]."' name='student' value='".$row["smu_id"]."'> </td> <td>".$row["first_name"]."</td> <td>".$row["last_name"]."</td> <td>".$row["student_email"]."</td></tr>";
                            }
                        }
                    ?>
                </table>
                <input type="submit" name="submit" id="submit" value="Add Student to Group">
            </form>
        </div>
    </div> 
</body>
</html>