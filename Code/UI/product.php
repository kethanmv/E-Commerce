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

   	$db = pg_connect( "$host $port $dbname $credentials");
   	$id;
	$query;
  $ac = "";
  $as = "";
	$name;
	$qty;
   	if(isset($_GET['key']))
	{
		if(($_GET['key']==""))
		{
    		echo "Page Not Found";
		}
		else 
		{
		    $id = (int)$_GET['key'];
		    $query = <<<EOF
		    SELECT * FROM products WHERE prod_id = $id;
EOF;
		    $result = pg_query($db,$query) or die(pg_last_error($db));
		    $img = "pictures/".$id.".jpg";
		    if(pg_num_rows($result)==0)
		    {
		        echo "Product  doesn't exist.<br>";
		    }
		    else
		    {
		        $row = pg_fetch_row($result);
		        $name= $row[1];
                $supp_id = $row[7];
                $discount = (float)$row[2];
                $supp_id = (int)$supp_id;
                $price= $row[11];
                $desc = $row[5];
                $disc_price = (1 - $discount/100)*$price;
                $available_size = explode(",",$row[12]);
                $available_color = explode(",",$row[13]);
                //echo $available_color;
                //echo $available_size;
                echo "<form action='server.php' method='POST'><input type='hidden' name='productid' value='".$row[0]."'><input type='hidden' name='cid' value='".$temp."'>";
                if($available_color[0]!='NA')
                {
                	$ac =  "Available Colors:<br>
                		<select name='ac'>";
                    foreach($available_color as $key){
                      $ac.="<option value='".$key."'>$key</option>";
                    }
                    $ac.="</select>";
                }
                if($available_size[0]!='NA')
                {
                  $as =  "Available Sizes:<br>
                    <select name='as'>";
                    foreach ($available_size as $key) {
                      $as.="<option value='".$key."'>$key</option>";
                    }
                    $as.="</select>";
                }
                echo "";
                $qty = $row[3] - $row[4];
                $q = <<<EOF
    		select company_name from suppliers where supplier_id=$supp_id;
EOF;
				$res = pg_query($db,$q) or die(pg_last_error($db));
                $row1 = pg_fetch_row($res);
                //echo $row1[0];
                $company_name = $row1[0];
		    }
		}
	}
	else
	{
    	echo "Page Not Found";
	}
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
  <!-- <link rel="stylesheet" type="text/css" href="search-css.css"> -->
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
<br><br>
<div id='box' style="width:70%;height:auto;overflow: hidden;margin:auto;text-align:center;border: 3px solid #2F4F4F;border-radius:25px;">  
            <!--<h2 align="center" font="arial">Product Page</h2> -->
            <br>
            <?php
                if(isset($_GET['key']) && ($_GET['key']!="") )
                {
                    if(pg_num_rows($result)==1)
                    {
                    	if($qty>0)
                		{
                   			 echo "
			                        <img src=$img height='200px' style='max-width:400px'/><br>
			                        <p style='font-size:30px;' ><b>$name</b></p>
			                        <p style='font-size:20px;color:grey;' >Sold By - <b>$company_name</b> </p>
			                        <p style='font-size:15px;padding:25px;' ><b>Product Description:</b> $desc</p><p style='font-size:15px;' ><font color='green'>In Stock</font></p>".$as."<br><br>".$ac."<br><br>Payment Method:<br><select name='paymentmode'><option value='Cash'>Cash</option><option value='Card'>Card</option><option value='Online Payment'>Online Payment</option><option value='Cheque'>Cheque</option><option value='Wallets'>Wallets</option></select><br><br>
                        			<button type='submit' name='buynow'>Buy Now</button></form><br><br><br>
			                        ";
			            }
                    }
                }
            ?>

        </div>
</body>
</html>