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
    <link rel="stylesheet" href="styles/view_group_mem.css">
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
        <h2>View Student Group Members</h2>
    </div>

    <div class="content">
        <div class="selectgm">
            <form method="post" action="">
                <h3>Select a Group to View</h3>
                <select name="groupname" id="groupname">
                    <option value="">Select a Group</option>
                    <?php
                        require_once("db.php");

                        $sql = "SELECT group_name FROM `group`";
                        $result = $mydb->query($sql);

                        while ($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row['group_name']."'>".$row['group_name']."</option>";
                        }
                    ?>
                </select>
                <input type="submit" name="populate" id="populate" value="Display Group Members">
            </form>
        </div>
        <div class="table">
            <table>
                <thead>
                    <th>
                        First Name
                    </th>
                    <th>
                        Last Name
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        Major
                    </th>
                </thead>
                <?php
                    $groupname = "";
                    
                    if(isset($_POST["populate"])){
                        if(isset($_POST["groupname"])){
                            $groupname = $_POST["groupname"];
                        }

                        require_once("db.php");

                        $sql = "SELECT student.first_name, student.last_name, student.student_email, student.smu_id, student.major FROM student INNER JOIN membership ON student.smu_id = membership.student_smu_id INNER JOIN `group` ON membership.group_group_id = `group`.group_id WHERE `group`.group_name = '".$groupname."';";
                        $result = $mydb->query($sql);

                        while($row = mysqli_fetch_array($result)){
                            echo "<tr> <td>".$row["first_name"]."</td><td>".$row["last_name"]."</td><td>".$row["student_email"]."</td><td>".$row["smu_id"]."</td><td>".$row["major"]."</td></tr>";
                        }
                    }
                ?>
            </table>
        </div>
    </div> 
</body>
</html>