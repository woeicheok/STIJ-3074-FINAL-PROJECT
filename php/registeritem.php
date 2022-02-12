<?php
session_start();
if (!isset($_SESSION['sessionid'])){
   echo  "<script>alert('Session not available. Please Login');</script>";
   echo  "<script> window.location.replace('login.php')</script>";
}

if(isset($_POST["submit"])){
    include_once ('../php/dbconnect.php');
    $itemcode = $_POST["itemcode"];
    $itemname = $_POST["itemname"];
    $colour = $_POST["colour"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $sqlregister = "INSERT INTO `table_item`(`itemcode`, `itemname`, `colour`, `price`, `stock`) 
    VALUES ('$itemcode','$itemname','$colour','$price','$stock')";
   try {
    $conn->exec($sqlregister);
    if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
        uploadImage($itemcode);
    }
        echo "<script>alert('Registration successful')</script>";
        echo "<script>window.location.replace('mainpage.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Registration failed')</script>";
        echo "<script>window.location.replace('registeritem.php')</script>";
    }
}

function uploadImage($itemcode)
{
    $target_dir = "../images/";
    $target_file = $target_dir . $itemcode . ".jpg";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
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
    <script src="../js/script.js"></script>
    <title>Register Item</title>
</head>

<body> 
    <div class="w3-header w3-display-container w3-black w3-padding-32 w3-center">
        <h1 style="font-size:calc(8px + 4vw);">F&L Florist</h1>
        <p style="font-size:calc(4px + 2vw);">Welcome to the F&L FLorist</p>
    </div>
    <div class="w3-bar-item w3-pale-yellow">
         <a href="mainpage.php" class="w3-bar-item w3-button">Home</a>
        <a href="login.php" class="w3-bar-item w3-button w3-right">Logout</a>
    </div>



    <div class="w3-container w3-padding-64 form-container2">
        <div class="w3-card-4 w3-round">
            <div class="w3-container w3-pale-yellow">
                <h2>Register Item Form</h2>
                <p>Please fill up the form to register item</p>
            </div>
           <form class="w3-container w3-padding formo" name="registeritemForm" class="w3-container" 
            action="registeritem.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()">
                <img class="w3-image w3-round w3-margin" src="../image/empty.jpg" style="width:100%; max-width:600px"><br>
                <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
            </div>
                <p>
                    <label class="w3-text-black"><b>Item code</b></label>
                    <input class="w3-input w3-border w3-round" name="itemcode" id="iditemcode" type="text" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Item name</b></label>
                    <input class="w3-input w3-border w3-round" name="itemname" id="iditemname" type="text" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Colour</b></label>
                    <input class="w3-input w3-border w3-round" name="colour" id="idcolour" type="text" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Price</b></label>
                    <input class="w3-input w3-border w3-round"name="price" id="idprice" type="text" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Item stock</b></label>
                    <input class="w3-input w3-border w3-round" name="stock" id="idstock" type="number" required>
                </p>
                <p>
                    <button class="w3-btn w3-round w3-pale-yellow w3-block w3-center" type="submit" onclick="return confirmDialog2()" name="submit">Submit</button>
                </p>
            </form> 
        </div>
    </div>
</body>
    

<footer class="w3-container w3-pale-yellow w3-center">
    <p> © Copyright:Florist</p>
    <p>TERMS AND CONDITIONS <br> PRIVACY POLICY</p>
    <p><a href="mailto:Florist@example.com">F&Lflorist@gmail.com</a></p>
</footer>

</html>