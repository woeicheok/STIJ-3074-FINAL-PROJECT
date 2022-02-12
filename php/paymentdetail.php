<?php
include_once ("dbconnect.php");
session_start();
if (isset($_SESSION['sessionid']))
{
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
}else{
    echo "<script>alert('Please login or register')</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

$receiptid = $_GET['receipt'];
$sqlquery = "SELECT * FROM table_order INNER JOIN table_items ON table_order.order_itemcode = table_items.itemcode WHERE table_order.order_receiptid = '$receiptid'";
$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

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
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<title>F&L FLORIST</title>
<script src="../js/script.js"></script>

<body>
    <!-- Sidebar (hidden by default) -->
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:10%;min-width:601px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()"
        class="w3-bar-item w3-button">Close Menu</a>
        <a href="cart2.php" onclick="w3_close()" class="w3-bar-item w3-button">My Cart</a>
        <a href="mainpage.php" onclick="w3_close()" class="w3-bar-item w3-button">Flower</a>
        <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
        <a href="registeritem.php" onclick="w3_close()" class="w3-bar-item w3-button">Register Item</a>
        <a href="paymenthistory.php" onclick="w3_close()" class="w3-bar-item w3-button">Payment History</a>
        <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>
    </nav>

    <!-- Top menu -->
    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
            <div class="w3-center w3-padding-16">F&L Florist Shop</div>
        </div>
        </div>
    
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
      
      <div class="w3-grid-template">
          
          <?php 
            $totalpaid = 0.0;
           foreach ($rows as $details)
            {
                $itemid = $details['item_id'];
                $item_name = subString($details['item_name']);
                $order_qty = $details['order_qty'];
                $order_paid = $details['order_paid'];
                $order_status = $details['order_status'];
                $totalpaid = ($order_paid * $order_qty) + $totalpaid;
                $order_date = date_format(date_create($details['order_date']), 'd/m/y h:i A');
               echo "<div class='w3-center w3-padding-small'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small'><a href='book_details.php?bookid=$itemid'><img class='w3-container w3-image' 
                    src=../images/books/$itemcode.jpg onerror=this.onerror=null;this.src='../images/empty.jpg'></a></div>
                    <b>$item_name</b>RM $order_paid<br> $order_qty unit<br></div></div>";
             }
             
             $totalpaid = number_format($totalpaid, 2, '.', '');
            echo "</div><br><hr><div class='w3-container w3-left'><h4>Your Order</h4><p>Order ID: $receiptid<br>Name: $user_name <br>Phone: $user_phone<br>Total Paid: RM $totalpaid<br>Status: $order_status<br>Date Order: $order_date<p></div>";
            ?>
    </div>
    
    <footer class="w3-container w3-white w3-center">
        <p> © Copyright:Florist</p>
        <p>TERMS AND CONDITIONS <br> PRIVACY POLICY</p>
        <p><a href="mailto:Florist@example.com">F&Lflorist@gmail.com</a></p>
    </footer>   
   

</body>

</html>