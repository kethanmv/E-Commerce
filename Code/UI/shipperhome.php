<?php include('server.php'); 
	if(empty($_SESSION['shipperid'])){
		header('location: shipperlogin.php');
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
  <a class="navbar-brand" href="#" style="font-size: 30px">E-commerce Database</a>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="shipperhome.php">Home</a>
    </li>
    <li class="nav-item" style="font-size: 20px;padding-right: 30px;">
      <a class="nav-link" href="shipperhome.php?shiplogout=1">Logout</a>
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
    $temppp = $_SESSION['shipperid'];
    $query = <<<EOF
      select * from orders,order_details where shipper_id='$temppp' AND orders.order_id=order_details.order_id;
EOF;
    //echo $temppp;
    $result1=pg_query($db,$query) or die(pg_last_error($db));
    if(pg_num_rows($result1)==0)
   {
      echo "<h1 align='center'><p>No Orders Being Shipped.</p></h1>";
   }

   if(pg_num_rows($result1)>0)
   {
      echo "<h1 align='center'>Orders Being Shipped</h1>";
      echo "<br><br><br>";

      $strr = '<table align="center" class="table table-striped" style="width:70%;"><thead><tr><th>Order ID</th><th>Payment Date</th><th>Customer ID</th><th>Payment ID</th><th>Order Date</th><th>Ship Date</th><th>Transact Status</th><th>Delivery Status</th></tr></thead><tbody>';
      echo $strr;
   }
    while($row = pg_fetch_row($result1))
    {
      echo "<tr><td>". $row[0] ."</td>\n";
      echo "<td>". $row[1] ."</td>\n";
      echo "<td>". $row[2] ."</td>\n";
      echo "<td>". $row[3] ."</td>\n";
      echo "<td>". $row[4] ."</td>\n";
      echo "<td>". $row[5] ."</td>\n";
      echo "<td>". $row[8] ."</td>\n";
      echo "<td>". $row[9] ."</td>\n";
      if(($row[9]!="Delivered") && ($row[9]!="Cancelled"))
      {
          if($row[9]=="Order Placed")
          {
            echo "<td><form action='shipperhome.php' method='POST'>
             <select name='updatestat'>
             <option value='Delivered'>Delivered</option>
             <option value='In Transit'>In Transit</option>
             </select>
             <input type='hidden' name='orderid' value='".$row[0]."'>
             <div>
             <button type='submit' name='update'>Update</button></div></form></td>\n";
          }
          elseif ($row[9]=="In Transit") {
            echo "<td><form action='shipperhome.php' method='POST'>
             <select name='updatestat'>
             <option value='Delivered'>Delivered</option>
             </select>
             <input type='hidden' name='orderid' value='".$row[0]."'>
             <div>
             <button type='submit' name='update'>Update</button></div></form></td>\n";
          }
      }
     // echo "</tr><br>";

     // echo $row[0];
     // echo "<br>";
    }
     echo "</tbody></table>";
     //echo $row;
   //echo "Operation done successfully\n";
   pg_close($db);
  ?>
</div>


</body>
</html>