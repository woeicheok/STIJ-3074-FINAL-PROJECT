<?php
if (isset($_POST["submit"])){
    include '../php/dbconnect.php';
    $email = $_POST["email"];
    $password = sha1($_POST["password"]);
    $stmt = $conn->prepare("SELECT * FROM table_admin WHERE email = '$email' AND password = '$password'");
    $stmt->execute();
    $number_of_rows = $stmt->fetchColumn();
    if ($number_of_rows > 0) {
        session_start();
        $_SESSION["sessionid"] = session_id();
        echo "<script>alert('Login Successful');</script>";
        echo "<script> window.location.replace('mainpage.php')</script>";
    } else {
        echo "<script>alert('Login Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../script.js"></script>
    <title>Login</title>

</head> 

<body onload="loadCookies()">
    <div class="w3-header w3-display-container w3-black w3-padding-32 w3-center">
        <h1 style="font-size:calc(4px + 2vw);">F&L Florist</h1>
</div>

    <div class="w3-container w3-padding-64 form-container">
        <div class="w3-card-4 w3-round">
            <div class="w3-container w3-white">
                <h2>Login</h2>
            </div>
            <form name="loginForm" class="w3-container" action="login.php" method="post">
                <p>
                    <label class="w3-text-black"><b>Email</b></label>
                    <input class="w3-input w3-border w3-round" name="email" id="idemail" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Password</b></label>
                    <input class="w3-input w3-border w3-round" name="password" type="password" id="idpass" required>
                </p>
                <p>
                    <input class="w3-check" type="checkbox" id="idremember" onclick="rememberMe()">
                    <label>Remember Me</label>
                </p>
                <p>
                    <button class="w3-btn w3-round w3-white w3-block" name="submit">Login</button>
                        <span class="psw"><a href="forgotpassword.php">Forgot password?</a></span>
                        <a href="SIgnUp.php", class="w3-right">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
</body>


<footer class="w3-container w3-white w3-center">
    <p> © Copyright:Florist</p>
    <p>TERMS AND CONDITIONS <br> PRIVACY POLICY</p>
    <p><a href="mailto:Florist@example.com">F&Lflorist@gmail.com</a></p>
</footer>

</html>