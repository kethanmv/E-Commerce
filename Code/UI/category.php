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
   	if(isset($_GET['catid']) && ($_GET['catid']!=""))
	{
		$cat_id = $_GET['catid'];
		$q1 = <<<EOF
    		select category_name from category where category_id=$cat_id;
EOF;
		$res = pg_query($db,$q1) or die(pg_last_error($db));
		$row1 = pg_fetch_row($res);
		$cat_name = $row1[0];
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
<div class="container1" > 
        <!--style="width:1000px;margin:auto;border: 3px solid green;padding:50px;border-radius:50px;"--> 
        <p style='font-size:50px;margin-top:25px;margin-bottom:25px;'align="center"><?php echo "$cat_name";?></p> 
            <?php  
            $host        = "host = 127.0.0.1";
   			$port        = "port = 5432";
   			$dbname      = "dbname = ecommerce";
   			$credentials = "user = postgres password=root";
   			$temp = $_SESSION['uemail'];
   			$db = pg_connect( "$host $port $dbname $credentials");
   			if(isset($_GET['catid']) && ($_GET['catid']!=""))
			{
				$cat_id = (int)$_GET['catid'];
				$query = <<<EOF
    		select * from products where category_id=$cat_id;
EOF; 
			$result = pg_query($db,$query) or die(pg_last_error($db));
			if(pg_num_rows($result)==0)
            {
                echo "No products available.<br>";
            }
            while($row = pg_fetch_row($result))  
            {
                if($row[14]==1)
                {
                  $id = $row[0];
                $img = "pictures/".$id.".jpg";  
                $name= $row[1];
                $supp_id = $row[7];
                $discount = (float)$row[2];
                $supp_id = (int)$supp_id;
                $price= $row[11];
                $disc_price = (1 - $discount/100)*$price;
                $qty = $row[3] - $row[4];
                $q = <<<EOF
        select company_name from suppliers where supplier_id=$supp_id;
EOF;
                $res = pg_query($db,$q) or die(pg_last_error($db));
                $row1 = pg_fetch_row($res);
                //echo $row1[0];
                $company_name = $row1[0];
                if($qty>0){$av = "<font color='green'>In Stock</font>";}
                else{$av = "<font color='red'>Out of Stock</font>";}
                /*echo " 
                    <a href='product.php?key=$id' style='text-decoration: none;'>
                    <div class='prcont' style='margin:25px;padding: 25px;width:250px;height:400px;background-color:white;border-radius:25px;border: 3px solid black;text-align: center;display:inline-block;'> 
                        <img src=$img height='100px' style='max-height:150px;max-width:200px'/>
                        <p style='color:black;font-size:18px;margin-bottom:5px;'>$name</p>
                        <p style='color:grey;font-size:12px;margin-top:5px;'>Sold By - $company_name</p>"; */
                    if($discount>0)
                    {
                      echo "<a href='product.php?key=$id' style='text-decoration: none;'>
                    <div class='prcont' style='margin:25px;padding: 22px;width:250px;height:400px;background-color:white;border-radius:25px;border: 3px solid black;text-align: center;display:inline-block;'> 
                        <img src=$img height='100px' style='max-height:150px;max-width:200px'/>
                        <p style='color:black;font-size:18px;margin-bottom:5px;'>$name</p>
                        <p style='color:grey;font-size:12px;margin-top:5px;'>Sold By - $company_name</p>
                        <p style='color:black;font-size:20px;'>Price - <strike>Rs.$price</strike></p>
                        <p style='color:#B12704;font-size:20px;'>                Rs.$disc_price</p>";
                        echo "<p>$av</p>
                    </div> </a>
                    ";
                    }
                    else{
                      echo "<a href='product.php?key=$id' style='text-decoration: none;'>
                    <div class='prcont' style='margin:25px;padding: 22px;width:250px;height:400px;background-color:white;border-radius:25px;border: 3px solid black;text-align: center;display:inline-block;'> 
                        <img src=$img height='100px' style='max-height:150px;max-width:200px'/>
                        <p style='color:black;font-size:18px;margin-bottom:5px;'>$name</p>
                        <p style='color:grey;font-size:12px;margin-top:5px;'>Sold By - $company_name</p>
                        <p style='color:black;font-size:20px;'>Price - Rs.$price</p>";
                        echo "<p>$av</p>
                    </div> </a>
                    ";
                    }
                } 
            }
			}
            /*else
            {
                echo "<table class='pricing-table' align='center' id='pricing-table'>  
                <tr>  
                    <th>Image</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Availability<th>  
                </tr> ";
            } */   
            ?>  
            </table>  
        </div>
</body>
</html>
