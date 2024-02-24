<?php include('server.php'); 
	if(empty($_SESSION['supplierid'])){
		header('location: sellerlogin.php');
	}
?>
<?php
    $host        = "host = 127.0.0.1";
    $port        = "port = 5432";
    $dbname      = "dbname = ecommerce";
    $credentials = "user = postgres password=root";
    $db = pg_connect( "$host $port $dbname $credentials");
    $temppp = $_SESSION['supplierid'];
    $q = <<<EOF
      select * from suppliers where supplier_id='$temppp';
EOF;
    $rr = pg_query($db,$q) or die(pg_last_error($db));
    $rowx = pg_fetch_row($rr);
    $supp_name = $rowx[3];
    //echo $supp_name;
?>
<!DOCTYPE html>
<html>
<head>
  <title>E-commerce Database</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-info navbar-dark">
  <a class="navbar-brand" href="#" style="font-size: 30px">E-commerce Database</a>
  <ul class="navbar-nav ml-auto">
    <?php
    echo "<li class='nav-item' style='font-size: 20px;padding-right: 30px;'><a class='nav-link' style='color:black'><b>Hello, ".$supp_name."!</b></a>
    </li>";
    ?>
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="supplierhome.php">Home</a>
    </li>
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="aap.php">Add a Product</a>
    </li>
    <li class="nav-item dropdown" style="font-size: 20px;padding-right: 50px;">
      <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" href="supplierhome.php">Orders</a>
      <div class="dropdown-menu" style="background:#addfee;">
        <a class="dropdown-item" href="sorders.php?data=Delivered">Delivered Orders </a>
        <a class="dropdown-item" href="sorders.php?data=NotDelivered">Pending Orders </a>
        <a class="dropdown-item" href="sorders.php?data=Cancelled">Cancelled Orders</a>
      </div>
    </li>
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="supplierhome.php?suplogout=1">Logout</a>
    </li>
  </ul>
</nav>
	<div class="header1">
		<h2>Product Details</h2>
	</div>

	<form method="post" action="aap.php" enctype="multipart/form-data">
		<div class="input-group">
			<label>Product Name:</label>
			<input type="text" name="productname" required>
		</div>
		<div class="input-group">
			<label>Product Description:</label>
			<textarea rows="4" cols="50" name="productdescription" required></textarea>
		</div>
		<div class="input-group">
			<label>Category:</label>
			<select name="category">
				<option value="21370">Mobiles, Computers</option>
				<option value="72282">TV, Appliances, Electronics</option>
				<option value="50619">Fashion</option>
				<option value="38680">Sports, Fitness, Bags, Luggage</option>
				<option value="57390">Books & Audible</option>
				<option value="13121">Gaming</option>	
			</select>
		</div><br>
		<div>
			<label>Picture:</label>
			<input type="file" name="file" accept="image/jpg">
			<br>
		</div>
		<div class="input-group">
			<label>Units In Stock:</label>
			<input type="number" name="uis" min="0" required>
		</div>
		<div class="input-group">
			<label>Unit Price:</label>
			<input type="number" name="up" min="0" step="any" required>
			<span class="unit">₹    </span>
		</div>
		<div class="input-group">
			<label>Price:</label>
			<input type="number" name="price" min="0" step="any" required>
			<span class="unit">₹    </span>
		</div>
		<div class="input-group">
			<label>Discount:</label>
			<input type="number" name="discount" step="0.1" min="0" required>
		</div>
		<div class="input-group">
			<label>Avaiable Size:</label>
			<input type="text" name="size"  required>
		</div>
		<div class="input-group">
			<label>Avaiable Color:</label>
			<input type="text" name="color" required>
		</div>
		<div class="input-group">
			</center><button type="submit" name="add" class="btn">Add</button>
		</div>
	</form><br><br>
</body>
</html>