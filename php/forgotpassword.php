<?php
if (isset ($_POST["confirm"])){
    echo "<script>alert('An email had sent to your email. Please check your email');</script>";
    echo "<script> window.location.replace('login.php')</script>";
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
    <title>Forgot Password</title>
</head>

<body> 
    <div class="w3-header w3-display-container w3-black w3-padding-32 w3-center">
        <h1 style="font-size:calc(4px + 2vw);">F&L Florist</h1>
    </div>

    <div class="w3-container w3-padding-64 form-container">
        <div class="w3-card-4 w3-round">
            <div class="w3-container w3-white">
                <h2>Forgot Password</h2>
                <p>Enter your email to retrieve your password</p>
            </div>
            <form name="ForgotPasswordForm" class="w3-container" action="forgotpassword.php" method="post">
                <p>
                    <label class="w3-text-black"><b>Email</b></label>
                    <input class="w3-input w3-border w3-round" name="email" id="idemail" required>
                </p>
                <p>
                    <button class="w3-btn w3-round w3-white w3-block" name="confirm">Confirm</button>
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