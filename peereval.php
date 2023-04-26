<?php
    $course = "";
    session_start();
    $writer_id = $_SESSION['smu_id'];
    $date = "";
    $smu_id = "";
    $DMK = "";
    $ICS = "";
    $IS = "";
    $GC = "";
    $PM = "";
    $err = false;


    if(isset($_POST['submit'])){
        if(isset($_POST['group_member'])){
            $smu_id = $_POST['group_member'];

            require_once("db.php");
            
            $sql = "SELECT course_course_id FROM enrollment where student_smu_id = '$smu_id';";
            $result = $mydb->query($sql);
            $row = mysqli_fetch_array($result);

            $course = $row['course_course_id'];
        }
        if(isset($_POST['date'])){
            $date = $_POST['date'];
        }
        if(isset($_POST['DMK'])){
            $DMK = $_POST['DMK'];   
        }
        if(isset($_POST['ICS'])){
            $ICS = $_POST['ICS'];
        }
        if(isset($_POST['IS'])){
            $IS = $_POST['IS'];
        }
        if(isset($_POST['GC'])){
            $GC = $_POST['GC'];
        }
        if(isset($_POST['PM'])){
            $PM = $_POST['PM'];
        }

        if(!empty($writer_id) && !empty($smu_id) && strlen($DMK) > 0 && strlen($ICS) > 0 && strlen($IS) > 0 && strlen($GC) > 0 && strlen($PM) > 0 && !empty($date)){
            require_once("db.php");
            
            $sql = "INSERT INTO peer_evaluation(disciplinary_grade, intellectual_grade, interpersonal_grade, global_citizenship_grade, personal_mastery_grade, student_writer_smu_id, student_receiver_smu_id, course_course_id, peer_evaluation_date) VALUES ('$DMK', '$ICS', '$IS', '$GC', '$PM', '$writer_id', '$smu_id', '$course', '$date');";
            $result = $mydb->query($sql);

            if($result == 1){
                echo '<script>alert("Your Peer Evalution has been submitted")</script>';
            }
        } else{
            $err = True;
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
    <link rel="stylesheet" href="styles/peereval.css">
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
        <a href="student_dashboard.html"><img src="images/back-arrow.png" alt="" width="70px" height="70px"></a>
        <h2>Submit Peer Evaluations</h2>
        <!-- Student Name? -->
    </div>

    <div class="content">
        <div class="form">
            <form class="form1" method="post" action="">
                <div class="group">
                    <h4>Group</h4>
                    <select name="group" id="group-select">
                        <option value="">Select Group to Evaluate</option>
                        <?php
                            require_once("db.php");

                            $sql = "SELECT group_name FROM `group`";
                            $result = $mydb->query($sql);

                            while ($row = mysqli_fetch_array($result)){
                                echo "<option value='".$row['group_name']."'>".$row['group_name']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <input class="submit" type="submit" name="populate" value="Get Member Names">
            </form>
    
            <form class="form2" method="post" action="">
                <div class="date">
                    <h4>Date</h4>
                    <input type="date" name="date">
                </div>
                <div class="group-mem">
                    <h4>Names of Group Members</h4>
                    <div class="group-members">
                        <div class="group-mem-radios">
                            <?php
                                $group_name = "";

                                if(isset($_POST['populate'])){
                                    if(isset($_POST['group'])){
                                        $group_name = $_POST['group'];

                                        if(!empty($group_name)){
                                            require_once("db.php");
                                            $sql = "SELECT `group`.group_name, `group`.course_course_id, membership.group_group_id, membership.student_smu_id, student.first_name, student.last_name FROM membership JOIN `group` ON `group`.group_id=membership.group_group_id JOIN student ON membership.student_smu_id=student.smu_id WHERE `group`.group_name = '".$group_name."';";
                                            $result = $mydb->query($sql);
                                            
                                            while ($row = mysqli_fetch_array($result)){
                                                echo "<input type='radio' id='".$row['student_smu_id']."' name='group_member' value='".$row['student_smu_id']."'>";
                                                echo "<label for='".$row['student_smu_id']."'>".$row['first_name']." ".$row['last_name']."</label><br>";
                                                $course = $row['course_course_id'];
                                            }
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class=labels>
                    <h5>Please evaluate your peer on the following:</h5>
                    <h4>Graduate Learning Outcome</h4>
                </div>
                <div class="radios">
                    <p>Disciplinary & Multidisciplinary Knowledge</p>
                    <div class="dmk">
                        <input type="radio" id="DMK0" name="DMK" value="0">
                        <label for="DMK0">0</label>
                        <input type="radio" id="DMK1" name="DMK" value="1">
                        <label for="DMK1">1</label>
                        <input type="radio" id="DMK2" name="DMK" value="2">
                        <label for="DMK2">2</label>
                        <input type="radio" id="DMK3" name="DMK" value="3">
                        <label for="DMK3">3</label>
                        <input type="radio" id="DMK4" name="DMK" value="4">
                        <label for="DMK4">4</label>
                    </div>
                    <p>Intellectual & Creative Skills</p>
                    <div class="ics">
                        <input type="radio" id="ICS0" name="ICS" value="0">
                        <label for="ICS0">0</label>
                        <input type="radio" id="ICS1" name="ICS" value="1">
                        <label for="ICS1">1</label>
                        <input type="radio" id="ICS2" name="ICS" value="2">
                        <label for="ICS2">2</label>
                        <input type="radio" id="ICS3" name="ICS" value="3">
                        <label for="ICS3">3</label>
                        <input type="radio" id="ICS4" name="ICS" value="4">
                        <label for="ICS4">4</label>
                    </div>
                    <p>Interpersonal Skills</p>
                    <div class="IS">
                        <input type="radio" id="IS0" name="IS" value="0">
                        <label for="IS0">0</label>
                        <input type="radio" id="IS1" name="IS" value="1">
                        <label for="IS1">1</label>
                        <input type="radio" id="IS2" name="IS" value="2">
                        <label for="IS2">2</label>
                        <input type="radio" id="IS3" name="IS" value="3">
                        <label for="IS3">3</label>
                        <input type="radio" id="IS4" name="IS" value="4">
                        <label for="IS4">4</label>
                    </div>
                    <p>Global Citizenship</p>
                    <div class="GC">
                        <input type="radio" id="GC0" name="GC" value="0">
                        <label for="GC0">0</label>
                        <input type="radio" id="GC1" name="GC" value="1">
                        <label for="GC1">1</label>
                        <input type="radio" id="GC2" name="GC" value="2">
                        <label for="GC2">2</label>
                        <input type="radio" id="GC3" name="GC" value="3">
                        <label for="GC3">3</label>
                        <input type="radio" id="GC4" name="GC" value="4">
                        <label for="GC4">4</label>
                    </div>
                    <p>Personal Mastery</p>
                    <div class="PM">
                        <input type="radio" id="PM0" name="PM" value="0">
                        <label for="PM0">0</label>
                        <input type="radio" id="PM1" name="PM" value="1">
                        <label for="PM1">1</label>
                        <input type="radio" id="PM2" name="PM" value="2">
                        <label for="PM2">2</label>
                        <input type="radio" id="PM3" name="PM" value="3">
                        <label for="PM3">3</label>
                        <input type="radio" id="PM4" name="PM" value="4">
                        <label for="PM4">4</label>
                    </div>
                </div>
                <?php
                    if($err){
                        echo"<p class='error'>Please select a rating for each Graduate Learning Outcome.</p>";
                    }
                ?>
                <input class="submit" type="submit" name="submit" value="Submit Evaluation" >
            </form>
        </div>
    </div> 
</body>
</html>