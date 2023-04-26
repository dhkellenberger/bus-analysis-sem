<?php
    session_start();

    if(isset($_POST["new-group"])){
        header("HTTP/1.1 307 Temporary Redirect");
        header("Location: create_group.php");
    }

    if(isset($_POST["view"])){
        header("HTTP/1.1 307 Temporary Redirect");
        header("Location: view_group_mem.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU View Student Groups</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Inter&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/view_groups.css">
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
        <h2>View Student Groups</h2>
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
                        echo "<tr> <td> <input type='radio' id='".$row["course_id"]."' name='course' value='".$row["course_id"]."'> </td> <td>".$row["course_id"]."</td> <td>".$row["course_name"]."</td> <td>".$row["course_semester"]."</td> <td>".$row["course_year"]."</td> </tr>";
                    }
                ?>
            </table>
            <input type="submit" name="populate" id="populate" value="Show Groups in Selected Class">
            <input type="submit" name="new-group" id="new-group" value="Create New Student Group">
            </form>
        </div>
        <div class="groups">
            <form method="post" action="">
                <h2>Current Groups in Class Selected</h2>
                <table>
                    <thead>
                        <th>
                            ID
                        </th>
                        <th>
                            Group Name
                        </th>
                    </thead>
                    <?php
                        $course_id = "";

                        if(isset($_POST['populate'])){
                            if(isset($_POST["course"])){
                                $course_id = $_POST['course'];
                                require_once("db.php");
                    
                                $sql = "SELECT group_id, group_name FROM `group` where course_course_id ='".$course_id."';";
                                $result = $mydb->query($sql);

                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr><td>".$row['group_id']."</td><td>".$row["group_name"]."</td></tr>";
                                }
                            }
                        }
                    ?>
                </table>
                <input type="submit" name="view" id="view" value="View Members of All Groups">
            </form>
        </div>
    </div> 
</body>
</html>