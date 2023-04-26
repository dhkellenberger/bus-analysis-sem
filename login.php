<?php
    $un = "";
    $pw = "";
    $sqlerr = false;
    $err = false;

    if(isset($_POST["submit"])){
        if(isset($_POST["username"])){
            $un = $_POST["username"];
        }
        if(isset($_POST["password"])){
            $pw = $_POST["password"];
        }
        if(!empty($un) && !empty($pw)){
            require_once("db.php");
            
            $sql = "SELECT user_name, pass_word, smu_id FROM student WHERE user_name = '".$un."' AND pass_word = '".$pw."';";
            $result = $mydb->query($sql);
            $row = mysqli_fetch_array($result);

            if(!empty($row) && $row["user_name"] == $un && $row["pass_word"] == $pw && $result == 1){
                session_start();
                $_SESSION["username"] = $un;
                $_SESSION["smu_id"] = $row["smu_id"];
                $_SESSION["role"] = "Student";
                header("HTTP/1.1 307 Temporary Redirect");
                header("Location: profile.php");
            } else{
                require_once("db.php");

                $sql = "SELECT user_name, pass_word, smu_id FROM professor WHERE user_name = '".$un."' AND pass_word = '".$pw."';";
                $result = $mydb->query($sql);
                $row = mysqli_fetch_array($result);
                if(!empty($row) && $row["user_name"] == $un && $row["pass_word"] == $pw && $result == 1){
                    session_start();
                    $_SESSION["username"] = $un;
                    $_SESSION["smu_id"] = $row["smu_id"];
                    $_SESSION["role"] = "Professor";
                    header("HTTP/1.1 307 Temporary Redirect");
                    header("Location: profile.php");
                } else{
                    $sqlerr = True;
                }
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
    <link rel="stylesheet" href="styles/login.css">
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
        <h2>Log In</h2>
    </div>

    <div class="content">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <img src="images/login-icon.png" alt="">
            <h2>Username</h2>
            <input class="form-control" type="text" name="username" placeholder="Username" required/>
            <?php
                if($err && empty($un)){
                    echo"<label class='error'><br>Error: Please enter a username.</label>";
                }
            ?>
            <h2>Password</h2>
            <input class="form-control" type="password" name="password" placeholder="Password" required/>
            <?php
                if($err && empty($un)){
                    echo"<label class='error'><br>Error: Please enter a password.</label>";
                }
            ?>
            <input class="submit" type="submit" name="submit" value="Log In" >
            <?php
                if($sqlerr){
                    echo"<label class='error'><br>Error: Username & Password combination not valid.</label>";
                }
            ?>
        </form>
    </div>


    <div class="footer">
        <header>
            
        </header>
    </div>
    
</body>
</html>