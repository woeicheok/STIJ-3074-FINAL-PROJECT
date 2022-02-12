<?php
include_once ("../php/dbconnect.php");
session_start();
if (isset($_SESSION['sessionid']))
{
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
}else{
    echo "<script>alert('Please login or register')</script>";
    echo "<script> window.location.replace('login.php')</script>";
}
$sqlpayment = "SELECT * FROM table_payment WHERE payment_email = '$email' ORDER BY payment_date DESC";
$stmt = $conn->prepare($sqlpayment);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
   <link rel="stylesheet" type="text/css" href="../css/style.css">
   <script src="../js/script.js"></script>
   <title>F&L FLORIST</title>

   <body onload="loadCookies()">
      <!-- Sidebar (hidden by default) -->
      <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:10%;min-width:601px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()"class="w3-bar-item w3-button">Close Menu</a>
        <a href="cart.php" onclick="w3_close()" class="w3-bar-item w3-button">My Cart</a>
        <a href="mainpage.php" onclick="w3_close()" class="w3-bar-item w3-button">Flower</a>
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
        </div>


      <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
          <div class="w3-grid-template">
               <?php
               $totalpaid = 0.0;
               $count = 0;
                foreach ($rows as $payments){
                    $paymentid = $payments['payment_id'];
                    $paymentreceipt = $payments['payment_receipt'];
                    $paymentpaid = number_format($payments['payment_paid'], 2, '.', '');
                    $totalpaid = $paymentpaid + $totalpaid;
                    $count++;
                    $paymentdate = date_format(date_create($payments['payment_date']),"d/m/Y h:i A");
                     echo "<div class='w3-left w3-padding-small'><div class = 'w3-card w3-round-large w3-padding'>
                    <div class='w3-container w3-center w3-padding-small'><b>Receipt ID: $paymentreceipt</b></div><br>
                    Book ordered: $count<br>Paid: RM $paymentpaid<br>Date: $paymentdate<br>
                    <div class='w3-button w3-blue w3-round w3-block'><a style='text-decoration: none;' href='payment_history.php?receipt=$paymentreceipt'>Details</a></div>
                    </div></div>";
                }
                $totalpaid = number_format($totalpaid, 2, '.', '');
                $totalpaid = number_format($totalpaid, 2, '.', '');
            echo "</div><br><hr><div class='w3-container w3-left'><h4>Your Orders</h4><p>Name: $nameTotal Paid: RM $totalpaid<p></div>";
               ?>
          </div>
      </div>
      <footer class="w3-row-padding w3-padding-32">
         <hr>
         </hr>
         <p class="w3-center">F&L FLORIST&reg;</p>
      </footer>
      <div id="id01" class="w3-modal">
      <div class="w3-modal-content" style="width:50%">
         <header class="w3-container w3-blue">
            <span onclick="document.getElementById('id01').style.display='none'" 
               class="w3-button w3-display-topright">&times;</span>
            <h4>Email to reset password</h4>
         </header>
         <div class="w3-container w3-padding">
            <form action="login.php" method="post">
               <label><b>Email</b></label>
               <input class="w3-input w3-border w3-round" name="email" type="email" id="idemail" required>
               <p>
                  <button class="w3-btn w3-round w3-blue" name="reset">Submit</button>
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