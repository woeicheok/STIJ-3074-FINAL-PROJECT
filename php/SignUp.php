<?php

if(isset($_POST["submit"])){
    include("../php/dbconnect.php");
    $id = $_POST["id"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = sha1($_POST["password"]);
    $otp = rand(10000,99999);
    $sqlsignup = "INSERT INTO `table_admin`(`id`, `email`, `name`, `password`) 
    VALUES ('$id','$email','$name','$password')";
    try{
        $conn->exec($sqlsignup);
        echo "<script>alert('Sign Up Successful')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Sign Up Failed')</script>";
        echo "<script>window.location.replace('signup.php')</script>";
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
    <title>Sign Up </title>
</head>

<body> 
    <div class="w3-header w3-display-container w3-black w3-padding-32 w3-center">
        <h1 style="font-size:calc(4px + 2vw);">F&L Florist</h1>
    </div>

    <div class="w3-bar-item w3-white">
         <a href="login.php" class="w3-bar-item w3-button">BACK</a>
    </div>

    <div class="w3-container w3-padding-64 form-container2">
        <div class="w3-card-4 w3-round">

            <div class="w3-container w3-white">
                <h2>Sign Up </h2>
                <p>Enter your information to sign up</p>
            </div>
            <form class="w3-container w3-padding formo" name="SignUpForm" class="w3-container" 
            action="SignUp.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()">
                <p>
                    <label class="w3-text-black"><b>IC number/Passport</b></label>
                    <input class="w3-input w3-border w3-round" name="id" id="id" type="text" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Email</b></label>
                    <input class="w3-input w3-border w3-round" name="email" id="email" type="text" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Name</b></label>
                    <input class="w3-input w3-border w3-round" name="name" id="idname" type="text" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Password</b></label>
                    <input class="w3-input w3-border w3-round" name="password" id="idpassword" type="password" required>
                </p>
                <p> 
                    <button class="w3-btn w3-round w3-pale-yellow w3-block w3-center" type="submit" onclick="return confirmDialog2()" name="submit">SignUp</button>
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