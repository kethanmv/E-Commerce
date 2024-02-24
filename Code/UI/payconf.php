<?php include('server.php'); 
  if(empty($_SESSION['uemail'])){
    header('location: login.php');
  }
?> 
<?php 
    $host        = "host = 127.0.0.1";
    $port        = "port = 5432";
    $dbname      = "dbname = ecommerce";
    $credentials = "user = postgres password=root";
    $temp = $_SESSION['uemail'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>E-commerce Database</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <meta http-equiv="refresh" content="2;url=orders.php">
</head>
<body style="background: #9cd9eb">
<nav class="navbar navbar-expand-sm bg-info navbar-dark">
  <a class="navbar-brand" href="index.php" style="font-size: 30px">E-commerce Database</a>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item dropdown" style="font-size: 20px;padding-right: 50px;">
      <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" href="index.php">Shop by Category</a>
      <div class="dropdown-menu" style="background:#addfee;">
        <a class="dropdown-item" href="category.php?catid=21370">Mobiles, Computers</a>
        <a class="dropdown-item" href="category.php?catid=72282">TV, Appliances, Electronics</a>
        <a class="dropdown-item" href="category.php?catid=50619">Fashion</a>
        <a class="dropdown-item" href="category.php?catid=38680">Sports, Fitness, Bags, Luggage</a>
        <a class="dropdown-item" href="category.php?catid=57390">Books & Audible</a>
        <a class="dropdown-item" href="category.php?catid=13121">Gaming</a>
      </div>
    </li>
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="orders.php">My Orders</a>
    </li>
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="index.php?logout=1">Logout</a>
    </li>
  </ul>
</nav>
<br>
	<h1 align='center'><p>Purchase Complete.</p></h1><br>
	<p align='center'>Redirecting you to your orders....<p>
</body>
</html>