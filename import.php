<?php
    session_start();
    $smu_id = $_SESSION["smu_id"];
    $filepath = "";
    $course = "";
    $del_course = "";
    $del_student = "";
    $date = date("m/d/Y");

    if(isset($_POST["import-courses"])){
        if(isset($_FILES["courses-file"])){
            $filepath = realpath($_FILES["courses-file"]["tmp_name"]);
        }

        $file = fopen($filepath, "r");

        while(($getData = fgetcsv($file, 100000, ",")) !== False){
            require_once("db.php");

            $sql = "INSERT INTO course(course_id, course_name, course_year, course_semester, course_day, course_time, professor_smu_id) VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$smu_id."');";
            $result = $mydb->query($sql);
            if($result == 1){
                echo '<script>alert("Courses have been imported successfully")</script>';
            }
        }
    }

    if(isset($_POST["import-students"])){
        if(isset($_FILES["students-file"])){
            $filepath = realpath($_FILES["students-file"]["tmp_name"]);
        }
        if(isset($_POST["courses"])){
            $course = $_POST["courses"];
        }

        $file = fopen($filepath, "r");

        while(($getData = fgetcsv($file, 100000, ",")) !== False){
            require_once("db.php");

            $sql = "INSERT INTO student(smu_id, last_name, first_name, major, academic_year, student_email, user_name, pass_word) VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."');";
            $result = $mydb->query($sql);

            require_once("db.php");
            
            $sql = "INSERT INTO enrollment(enrollment_date, student_smu_id, course_course_id) VALUES ('".$date."','".$getData[0]."','".$course."');";
            $result = $mydb->query($sql);
            if($result == 1){
                echo '<script>alert("Students have been imported and enrolled successfully.")</script>';
            }
        }
    }

    if(isset($_POST["delete-courses"])){
        if(isset($_POST["course"])){
            $del_course = $_POST["course"];
        }

        require_once("db.php");

        $sql = "DELETE FROM course WHERE course_id = '".$del_course."';";
        $result = $mydb->query($sql);
        if($result == 1){
            echo '<script>alert("Course has been deleted successfully.")</script>';
        }
    }

    if(isset($_POST["delete-students"])){
        if(isset($_POST["student"])){
            $del_student = $_POST["student"];
        }

        require_once("db.php");
        $sql = "DELETE FROM student WHERE smu_id = '".$_POST['student']."';";
        $result = $mydb->query($sql);
        if($result == 1){
            echo '<script>alert("Student has been deleted successfully.")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU Import Courses/Students</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Inter&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/import.css">
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
        <h2>Import Courses/Students</h2>
    </div>

    <div class="content">
        <div class="courses">
            <form method="post" action="" enctype="multipart/form-data">
                <h2>Imported Courses</h2>
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
                    <th>
                        Days
                    </th>
                    <th>
                        Time
                    </th>
                </thead>
                <?php
                    $smu_id = $_SESSION["smu_id"];
                    require_once("db.php");

                    $sql = "SELECT course_id, course_name, course_semester, course_year, course_day, course_time FROM course WHERE professor_smu_id = '".$smu_id."';";
                    $result = $mydb->query($sql);

                    while($row = mysqli_fetch_array($result)){
                        echo "<tr> <td> <input type='radio' id='".$row["course_id"]."' name='course' value='".$row["course_id"]."'> </td> <td>".$row["course_id"]."</td> <td>".$row["course_name"]."</td> <td>".$row["course_semester"]."</td> <td>".$row["course_year"]."</td> <td>".$row["course_day"]."</td><td>".$row["course_time"]."</td></tr>";
                    }
                ?>
            </table>
            <input type="file" name="courses-file" id="courses-file" accept=".csv">
            <input type="submit" name="import-courses" id="import-courses" value="Import Course">
            <input type="submit" name="delete-courses" id="delete-courses" value="Delete Course">
            <input type="submit" name="populate" id="populate" value="Show Students in Selected Class">
            </form>
        </div>
        <div class="students">
            <form method="post" action="" enctype="multipart/form-data">
                <h4>Import Students to:</h4>
                <select name="courses" id="courses">
                    <option value="">Select Course to Import To</option>
                    <?php
                        $smu_id= $_SESSION["smu_id"];
                        require_once("db.php");

                        $sql = "SELECT course_id FROM course WHERE professor_smu_id = '".$smu_id."';";
                        $result = $mydb->query($sql);

                        while ($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row['course_id']."'>".$row['course_id']."</option>";
                        }
                    ?>
                </select>
                <h2>Imported Students</h2>
                <table>
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
                            Email Address
                        </th>
                    </thead>
                    <?php
                        $course_id = "";

                        if(isset($_POST["populate"])){
                            if(isset($_POST["course"])){
                                $course_id = $_POST["course"];
                                require_once("db.php");
                    
                                $sql = "SELECT student.smu_id, student.first_name, student.last_name, student.student_email FROM student INNER JOIN enrollment ON student.smu_id = enrollment.student_smu_id WHERE enrollment.course_course_id = '".$course_id."';";
                                $result = $mydb->query($sql);

                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr> <td> <input type='radio' id='".$row["smu_id"]."' name='student' value='".$row["smu_id"]."'> </td> <td>".$row["first_name"]."</td> <td>".$row["last_name"]."</td> <td>".$row["student_email"]."</td> </tr>";
                                }
                            }
                        }
                    ?>
                </table>
                <input type="file" name="students-file" id="students-file" accept=".csv">
                <input type="submit" name="import-students" id="import-students" value="Import Student(s)">
                <input type="submit" name="delete-students" id="delete-students" value="Delete Student(s)">
            </form>
        </div>
    </div> 
</body>
</html>