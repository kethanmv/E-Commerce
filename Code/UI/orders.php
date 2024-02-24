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
    $sql_ord=<<<EOF
      select order_id,order_date,delivery_status from orders where cust_id=(select cust_id from customer where email='$temp');
EOF;
  $result1=pg_query($db,$sql_ord) or die(pg_last_error($db));
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
<?php  
  if(!$result1) {
      echo pg_last_error($db);
      exit;
   } 
   if(pg_num_rows($result1)==0)
   {
   	  echo "<br><h1 align='center'><p>No Orders Yet.</p></h1>";
   }
  /* if(pg_num_rows($result1)>0)
   {
      echo "<style='text-decoration:none;color:black;'><table cellspacing='2px' class='listing-table' align='center' style='border:1px solid #000000;border-radius:5px;width:900px;height:140px;background-color:#ffff99'>";
   }  */
   //echo $strr;
   while($row = pg_fetch_row($result1)) 
   {
   	  $ord = $row[0];
      $order_date = $row[1];
      $del_stat = $row[2];
      $order_date_s = strtotime($row[1]);
      //echo $order_date;
      $curr_date = strtotime(date("Y-m-d"));
      //echo $curr_date;
      $diff = ($curr_date - $order_date_s)/60/60/24; 
      //echo "<br>".$diff;
      $sql_r=<<<EOF
    select product_id from order_details where order_id=$ord;
EOF;
      $result2=pg_query($db,$sql_r) or die(pg_last_error($db));
      while($row2 = pg_fetch_row($result2))
      {
        $pid = $row2[0];
        $sql_p=<<<EOF
    select prod_name,picture,discount,msrp,prod_id from products where prod_id=$pid;
EOF;
      $result3=pg_query($db,$sql_p) or die(pg_last_error($db));
      $row3 = pg_fetch_row($result3);
      //echo $row3[1];
      $image="<td rowspan='2' style='width:130px;'><img src='pictures/".$row3[4].".jpg' style='width:130px;height:130px;border:1px solid black;'></td>";
      //echo "<style=width: 30%; margin:50px auto 10px; color: red; background-color:#000000; text-align: center; border: 1px solid #F9C416; border-bottom: none; border-radius: 10px 10px 0px 0px; padding: 20px>";

      //echo "";
      
      //echo "<style='text-decoration:none;color:black;'><table cellspacing='2px' class='listing-table' align='center' style='border:1px solid #000000;border-radius:5px;width:900px;height:40px;background-color:#000000'>";
      echo "<style='text-decoration:none;color:black;'><table cellspacing='2px' class='listing-table' align='center' style='border-radius:5px;width:900px;height:140px;background-color:#2badd3'>";
      $dis=$row3[3] - ($row3[2] * $row3[3]/100);

      $blah='           ';

      echo "<tr style='color:black;width:900px;height:40px;border-radius:5px'><td colspan='3' style='background-color:black;width:900px;height:40px;color:white;'>Order ID : ".$ord."</td></tr>";

      echo "<tr>". $image ."

              <td valign='top' align='left'><h3 style='font-size:20px;'><span style='text-align:left;'>".$row3[0]."</h3></span></td>
                  <td style='width:150px;' valign='top'><p style = 'font-size:25px'>&#8377<strong style='font-size:30px;'>".$row3[3]."</strong></p><p style = 'font-size:18px; color:red;'>&#8377<strong style='font-size:20px;'>".$dis."</strong></p></td>
                  </tr>"; 
                  echo "<tr><td valign='top'>Order Date>>$order_date<br>Order Status>>$row[2]</td>";
      if($diff <=5 && ($del_stat!='Delivered') && ($del_stat!='Cancelled'))
      {
         echo "<td style='text-align:center' width='100px'><a href='delete1.php?id=$ord&&prod_id=$pid'><div><img src='delete.png'></div></a></td></tr>";
      }
      //echo "Picture = ". $row[1] ."\n";
      echo "<br>";
      echo "</tbody></table>";
      
      }
   //echo pg_last_error($db);
   
      }
      //echo pg_last_error($db);
   	  /*foreach ($ttt as $item) {
    echo $item;
}*/     
   //echo $row;
   //echo "Operation done successfully\n";
   pg_close($db);
?>
</body>
</html>