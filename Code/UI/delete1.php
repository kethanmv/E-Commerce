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
    $db = pg_connect( "$host $port $dbname $credentials");
    $temppp = $_SESSION['supplierid'];
	if(isset($_GET['prod_id']) && isset($_GET['id'])) {
		$order_id = $_GET['id'];
		$prod_id = $_GET['prod_id'];
		$query1 = <<<EOF
      update products set units_in_stock=units_in_stock+1 where prod_id=$prod_id;
EOF;
		$query2 = <<<EOF
      update products set units_on_order=units_on_order-1 where prod_id=$prod_id;
EOF;
		$query3 = <<<EOF
      update orders set delivery_status='Cancelled' where order_id=$order_id;
EOF;
		//pg_query($db,$query) or die(pg_last_error($db));
		pg_query($db,$query1) or die(pg_last_error($db));
		pg_query($db,$query2) or die(pg_last_error($db));
		pg_query($db,$query3) or die(pg_last_error($db));
	}
	sleep(1);
	header('location:orders.php');
?>