<?php
include_once("../php/dbconnect.php");
session_start();

if (isset($_SESSION['sessionid'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
}else{
   echo "<script>alert('Please login or register')</script>";
   echo "<script> window.location.replace('login.php')</script>";
}

$sqlcart = "SELECT * FROM table_cart WHERE email = '$email'";
$stmt = $conn->prepare($sqlcart);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
if ($number_of_rows>0){
   if (isset($_GET['submit'])) {
    if ($_GET['submit'] == "add"){
        $itemcode = $_GET['itemcode'];
        $quantity = $_GET['quantity'];
        $cartqty = $quantity + 1 ;
        $updatecart = "UPDATE `table_cart` SET `quantity`= '$cartqty' WHERE email = '$email' AND itemcode = '$itemcode'";
        $conn->exec($updatecart);
        echo "<script>alert('Cart updated')</script>";
    }
    if ($_GET['submit'] == "remove"){
        $itemcode = $_GET['itemcode'];
        $quantity = $_GET['quantity'];
        if ($quantity == 1){
            $updatecart = "DELETE FROM `table_cart` WHERE email = '$email' AND itemcode = '$itemcode'";
            $conn->exec($updatecart);
            echo "<script>alert('Book removed')</script>";
        }else{
            $cartqty = $quantity - 1 ;
            $updatecart = "UPDATE `table_cart` SET `quantity`= '$cartqty' WHERE email = '$email' AND itemcode = '$itemcode'";
            $conn->exec($updatecart);    
            echo "<script>alert('Removed')</script>";
        }
        
    }
} 
}else{
    echo "<script>alert('No item in your cart')</script>";
    echo "<script> window.location.replace('mainpage.php')</script>";
}



$stmtqty = $conn->prepare("SELECT * FROM table_cart INNER JOIN table_items ON table_cart.itemcode = table_items.itemcode WHERE table_cart.email = '$email'");
$stmtqty->execute();
$resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
$rowsqty = $stmtqty->fetchAll();
foreach ($rowsqty as $carts) {
   $carttotal = $carts['quantity'] + $carttotal;
}

function subString($str)
{
    if (strlen($str) > 15)
    {
        return $substr = substr($str, 0, 15) . '...';
    }
    else
    {
        return $str;
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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <script src="https://kit.fontawesome.com/9ed75330c4.js" crossorigin="anonymous" rel="stylesheet"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/script.js"></script>
    <title>F&L Florist</title>

</head>

<body>
    <!-- Sidebar (hidden by default) -->
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:10%;min-width:601px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()"
        class="w3-bar-item w3-button">Close Menu</a>
        <a href="cart.php" onclick="w3_close()" class="w3-bar-item w3-button">My Cart</a>
        <a href="Mainpage.php" onclick="w3_close()" class="w3-bar-item w3-button">Flower</a>
        <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
        <a href="registeritem.php" onclick="w3_close()" class="w3-bar-item w3-button">Register Item</a>
        <a href="paymentdetial.php" onclick="w3_close()" class="w3-bar-item w3-button">Payment History</a>
        <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>
    </nav>

    <!-- Top menu -->
    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
            <a href="cart.php" class="w3-right w3-padding-16">Cart</a>
            <div class="w3-center w3-padding-16">F&L Florist Shop</div>
    </div>

    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
        <div class="w3-container w3-center"><p>Cart for <?php echo $name?> </p></div><hr>
        <div class="w3-grid-template">
             <?php
             
             $total_payable = 0.00;
                foreach ($rowsqty as $items){
                    $itemcode = $items['itemcode'];
                    $itemname = subString($itemname['itemname']);
                    $price = $items['price'];
                    $quantity = $items['quantity'];
                    $items_total = $quantity * $price;
                    $total_payable = $items_total + $total_payable;
                    echo "<div class='w3-center w3-padding-small' id='bookcard_$itemcode'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small'><a href='book_details.php?bookid=$itemcode'><img class='w3-container w3-image' 
                    src=../images/books/$itemcode.jpg onerror=this.onerror=null;this.src='../images/books/default.jpg'></a></div>
                    <b>$itemname</b><br>RM $price/unit<br>
                    <input type='button' class='w3-button w3-red' id='button_id' value='-' onClick='removeCart($itemcode,$price);'>
                    <label id='qtyid_$itemcode'>$quantity</label>
                    <input type='button' class='w3-button w3-green' id='button_id' value='+' onClick='addCart($itemcode,$price);'>
                    <br>
                    <b><label id='bookprid_$itemcode'> Price: RM $items_total</label></b><br></div></div>";
                }
             ?>
        </div>
        <?php 
        echo "<div class='w3-container w3-padding w3-block w3-center'><p><b><label id='totalpaymentid'> Total Amount Payable: RM $total_payable</label>
        </b></p><a href='payment.php?email=$email&amount=$total_payable' class='w3-button w3-round w3-blue'> Pay Now </a> </div>";
        ?>
        
    <footer class="w3-container w3-white w3-center">
        <p> © Copyright:Florist</p>
        <p>TERMS AND CONDITIONS <br> PRIVACY POLICY</p>
        <p><a href="mailto:Florist@example.com">F&Lflorist@gmail.com</a></p>
    </footer>

</body>
</html>