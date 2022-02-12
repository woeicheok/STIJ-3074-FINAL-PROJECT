<?php
$carttotal = 0;
if (isset($_GET['submit']))
{
    include_once ("../php/dbconnect.php");
    if ($_GET['submit'] == "cart")
    {
        if ($email != "Guest")
        {
            $itemcode = $_GET['itemcode'];
            $cartqty = "1";
            $stmt = $conn->prepare("SELECT * FROM table_cart WHERE email = '$email' AND itemcode = '$itemcode'");
            $stmt->execute();
            $number_of_rows = $stmt->rowCount();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();
            if ($number_of_rows > 0)
            {
                foreach ($rows as $carts)
                {
                    $cartqty = $carts['cart_qty'];
                }
                $cartqty = $cartqty + 1;
                $updatecart = "UPDATE `table_cart` SET `cart_qty`= '$cartqty' WHERE email = '$email' AND itemcode = '$itemcode'";
                $conn->exec($updatecart);
                echo "<script>alert('Cart updated')</script>";
                echo "<script> window.location.replace('mainpage.php')</script>";
            }
            else
            {
                $addcart = "INSERT INTO `table_cart`(`email`, `itemcode`, `cart_qty`) VALUES ('$email','$itemcode','$cartqty')";
                try
                {
                    $conn->exec($addcart);
                    echo "<script>alert('Success')</script>";
                    echo "<script> window.location.replace('mainpage.php')</script>";
                }
                catch(PDOException $e)
                {
                    echo "<script>alert('Failed')</script>";
                }
            }

        }
        else
        {
            echo "<script>alert('Please login or register')</script>";
            echo "<script> window.location.replace('login.php')</script>";
        }
    }
}

$results_per_page = 3;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

include_once("../php/dbconnect.php");
$sqlitems = "SELECT * FROM table_item ORDER BY itemcode ASC";
$stmt = $conn->prepare($sqlitems);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlitems = $sqlitems . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlitems);
$stmt-> execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <script src="https://kit.fontawesome.com/9ed75330c4.js" crossorigin="anonymous" rel="stylesheet"></script>
    <script src="../js/script.js"></script>
    <title>F&L Florist</title>

</head>

<body>

<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:10%;min-width:601px" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()"
  class="w3-bar-item w3-button">Close Menu</a>
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

<div class = "w3-grid-template" id="flower">
        <?php
        $cart = "cart";
        foreach ($rows as $items) {
            $itemcode = $items["itemcode"];
            $itemname = $items["itemname"];
            $colour = $items["colour"];
            $price = $items["price"];
            $stock = $items["stock"];
            echo "<div class='w3-center w3-padding'>"; 
            echo "<div class='w3-card-4 w3-white'>";
            echo "<header class='w3-container w3-white'>";
            echo "<h5>$itemname</h5>";
            echo "</header>";
            echo "<img class='w3-image' src=../images/$itemcode.jpg" .
                " onerror=this.onerror=null;this.src='../image/empty.jpg'"
                . " '>";
            echo "<div class='w3-container w3-left-align'><hr>";
            echo "<p>
                    <i class='fas fa-brush' style='font-size:16px'></i>&nbsp&nbsp&nbsp&nbsp<p1>Item Code:</p1>$itemcode<br>
                    <i class='fas fa-tint' style='font-size:16px'></i>&nbsp&nbsp&nbsp&nbsp<p1>Colour:</p1>$colour<br>
                    <i class='fas fa-money-bill-wave' style='font-size:16px'></i>&nbsp&nbsp<p1>RM</p1>$price<br>
                    <a href='cart.php?bookid=$itemcode&submit=$cart' class='w3-btn w3-blue w3-round'>Add to Cart</a><br><br>
                    <hr>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        
        }
        ?>
    </div>

    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo'<a href = "mainpage.php?pageno=' . $page . '" style= "text-decoration: none">&nbsp&nbsp'
        . $page . ' </a>';
    }
    echo " [ " . $pageno . " ] ";
    echo "</center>";
    echo "</div>";
?>

<hr id="about"> 

 <!-- About Section -->
 <div class="w3-container w3-padding-32 w3-center">  
    <h3>About Us</h3><br>
    <img src="../image/Cover Photo.jpg" alt="Me" class="w3-image" style="display:block;margin:auto" width="1500" height="1000">
    <div class="w3-padding-32">
      <h4><b>F&L Florist</b></h4>
      <h6><i>We Provide All type of flowers based on your needs</i></h6>
      <p>F&L Florist is a small business which operate by a yougster Ms Lim which located at Lintang Batu Lanchang, Pulau Pinang. This business started since 2010 until now. Altought there have been crisis where the business nearly can’t operate, but Ms Lim with the passion in florist stand still and overcome all the situation and challenges and continue to operate the business unitl now. Although they don’t have a website but they have Facebook to promote their flower and order from Facebook.</p>
    </div>
  </div>
  <hr>

</body>


<footer class="w3-container w3-white w3-center">
    <p> © Copyright:Florist</p>
    <p>TERMS AND CONDITIONS <br> PRIVACY POLICY</p>
    <p><a href="mailto:Florist@example.com">F&Lflorist@gmail.com</a></p>
</footer>

</html>