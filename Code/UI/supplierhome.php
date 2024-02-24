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
<div class="container1"> 
  <?php 
    $host        = "host = 127.0.0.1";
    $port        = "port = 5432";
    $dbname      = "dbname = ecommerce";
    $credentials = "user = postgres password=root";
    $db = pg_connect( "$host $port $dbname $credentials");
    $temppp = $_SESSION['supplierid'];
    $query = <<<EOF
      select * from products where supplier_id='$temppp';
EOF;
    //echo $temppp;
    $result1=pg_query($db,$query) or die(pg_last_error($db));
    if(pg_num_rows($result1)==0)
   {
      echo "<h1 align='center'><p>No Products Sold by You.</p></h1>";
   }

   if(pg_num_rows($result1)>0)
   {
      echo "<br><h1 align='center'>My products</h1>";

      $strr =  '<table align="center" class="table table-striped" style="width:70%;"><thead><tr><th>Product ID</th><th>Product Name</th><th>Discount</th><th>Units In Stock</th><th>Units On Order</th><th>QPU</th><th>Unit Price</th><th>MSRP</th><th>Avaiable Size</th><th>Avaiable Color</th></tr></thead><tbody>';
      echo $strr;
   }
    while($row = pg_fetch_row($result1))
    {
        echo "<tr><td>". $row[0] ."</td>\n";
        echo "<td>". $row[1] ."</td>\n";
        //echo "Picture = ". $row[1] ."\n";
        echo "<td>". $row[2] ."</td>\n";
        echo "<td>". $row[3] ."</td>\n";
        echo "<td>". $row[4] ."</td>\n";
        echo "<td>". $row[9] ."</td>\n";
        echo "<td>". $row[10] ."</td>\n";
        echo "<td>". $row[11] ."</td>\n";
        echo "<td>". $row[12] ."</td>\n";
        echo "<td>". $row[13] ."</td>\n";
        if($row[14]==1)
        {
          echo "<td><a href='delete.php?pid=$row[0]'>Delete</a></td>";
        }
        if($row[14]==0)
        {
          echo "<td><a href='add.php?pid=$row[0]'>Add</a></td>";
        }
        echo "</tr><br>";
     // echo $row[0];
     // echo "<br>";
    }
     echo "</tbody></table>";
     echo $row;
   //echo "Operation done successfully\n";
   pg_close($db);
  ?>
</div>
</body>
</html>