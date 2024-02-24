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
	if(isset($_GET['pid'])) {
		$id = $_GET['pid'];
		$query = <<<EOF
      update products set active=0 where prod_id=$id;
EOF;
		$result = pg_query($db,$query) or die(pg_last_error($db));
	}
	sleep(1);
	header('location:supplierhome.php');
?>