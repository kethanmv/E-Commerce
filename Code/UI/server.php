<?php
	session_start();
	$host        = "host = 127.0.0.1";
   	$port        = "port = 5432";
   	$dbname      = "dbname = ecommerce";
   	$credentials = "user = postgres password=root";

   	$db = pg_connect( "$host $port $dbname $credentials");

	$username = "";
	$email = "";
	$errors = array();

	if(isset($_POST['register'])){
		$uemail = pg_escape_string($db,$_POST['email']);
		$GLOBALS['uemail'] = $uemail;
		$password = pg_escape_string($db,$_POST['password']);
		$cpassword = pg_escape_string($db,$_POST['cpassword']);
		$fname = pg_escape_string($db,$_POST['fname']);
		$lname = pg_escape_string($db,$_POST['lname']);
		$phone = pg_escape_string($db,$_POST['phno']);
		$sa = pg_escape_string($db,$_POST['sa']);
		$ba = pg_escape_string($db,$_POST['ba']);
		$country = pg_escape_string($db,$_POST['country']);
		$state= pg_escape_string($db,$_POST['state']);
		$city = pg_escape_string($db,$_POST['city']);
		$street = pg_escape_string($db,$_POST['street']);
		$hno = pg_escape_string($db,$_POST['hno']);
		$pinc = pg_escape_string($db,$_POST['postal']);
		$pinc = (int)$pinc;
		//$sql_u="SELECT * FROM users WHERE email='$uemail'";
		$sql_u=<<<EOF
    	select * from customer where email='$uemail';
EOF;
		$res_u=pg_query($db,$sql_u) or die(pg_last_error($db));
	    //$res_e=mysqli_query($db,$sql_e) or die(mysqli_error($db));

	    if (pg_num_rows($res_u)>0) {
	    	array_push($errors,"Email already exists.");
	    }
		
		if ($password!=$cpassword) {
			array_push($errors,"Passwords don't match.");
		}

		if(count($errors)==0){

			//$sql = "INSERT INTO customer (fname,lname,phone,email,password,ship_address,billing_address,country,state,city,street,hno,postal) VALUES('$fname','$lname','$phone','$uemail','$password','$sa','$ba','$country','$state','$city','$street','$hno','$pinc')";
			$cust_id = rand(10000,99999);
			$date_joined = date("Y/m/d");
			$sql =<<<EOF
			INSERT INTO customer (cust_id,date_joined,fname,lname,phone,email,password,ship_address,billing_address,country,state,city,street,hno,postal) VALUES('$cust_id','$date_joined','$fname','$lname','$phone','$uemail','$password','$sa','$ba','$country','$state','$city','$street','$hno','$pinc');
EOF;
			pg_query($db,$sql);
			$_SESSION['uemail'] = $uemail;
			$_SESSION['login'] = true;
			header("location: index.php");
		}
	}

	if(isset($_POST['login'])){
		$uemail = pg_escape_string($db,$_POST['uemail']);
		$password = pg_escape_string($db,$_POST['password']);
		//$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$query = <<<EOF
      SELECT * from customer where email='$uemail' AND password='$password';
EOF;
		$result = pg_query($db, $query);
		if(pg_num_rows($result) == 1){
			$_SESSION['uemail'] = $uemail;
			$_SESSION['login'] = "You are now logged in";
			header('location:index.php');
		}
		else{
			array_push($errors, "Wrong username/password.");
		}
	}

	if(isset($_POST['loginsupplier'])){
		$supplierid = pg_escape_string($db,$_POST['supplierid']);
		
		//$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$query = <<<EOF
      SELECT * from suppliers where supplier_id='$supplierid';
EOF;
		$result = pg_query($db, $query);
		if(pg_num_rows($result) == 1){
			$_SESSION['supplierid'] = $supplierid;
			$_SESSION['loginsupplier'] = "You are now logged in";
			header('location:supplierhome.php');
		}
		else{
			array_push($errors, "Wrong Supplier ID");
		}
	}

	if(isset($_POST['loginshipper'])){
		$shipperid = pg_escape_string($db,$_POST['shipperid']);
		
		//$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$query = <<<EOF
      SELECT * from shippers where shipper_id='$shipperid';
EOF;
		$result = pg_query($db, $query);
		if(pg_num_rows($result) == 1){
			$_SESSION['shipperid'] = $shipperid;
			$_SESSION['loginshipper'] = "You are now logged in";
			header('location:shipperhome.php');
		}
		else{
			array_push($errors, "Wrong Shipper ID");
		}
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION['username']);
		header('location:index.php');
	}
	if(isset($_GET['suplogout'])){
		session_destroy();
		unset($_SESSION['supplierid']);
		header('location:supplierhome.php');
	}
	if(isset($_GET['shiplogout'])){
		session_destroy();
		unset($_SESSION['shipperid']);
		header('location:shipperhome.php');
	}
	if(isset($_POST['add']))
	{
		$p_id = rand(100,999);
		$target_path = "E:/Sem 4/DBMS/Project/Code/UI/pictures/";  
		$temp = explode(".", $_FILES["file"]["name"]);
		$newfilename = $p_id . '.' . end($temp);
		move_uploaded_file($_FILES['file']['tmp_name'], $target_path.$newfilename);
		$pname = pg_escape_string($db,$_POST['productname']);
		$pdesc = pg_escape_string($db,$_POST['productdescription']);
		$uod = 0;
		$category = $_POST['category'];
		$sid = $_SESSION['supplierid'];
		$qpu = 1;
		$temp = "E:\Sem 4\DBMS\Project\Code\UI\pictures\\".$p_id.".jpg";
		$uis = $_POST['uis'];
		$up = $_POST['up'];
		$price = $_POST['price'];
		$dis = $_POST['discount'];
		$asize = pg_escape_string($db,$_POST['size']);
		$acolor = pg_escape_string($db,$_POST['color']);

		$sql =<<<EOF
			INSERT INTO products VALUES($p_id,'$pname',$dis,$uis,$uod,'$pdesc','$temp',$sid,'$category',$qpu,$up,$price,'$asize','$acolor',1);
EOF;
		pg_query($db, $sql);
		header("location: supplierhome.php");
	}

	if(isset($_POST['update']))
	{
		$order_id = $_POST['orderid'];
		$status = $_POST['updatestat'];
		$query = <<<EOF
      update orders set delivery_status='$status' where order_id=$order_id;
EOF;
      	pg_query($db, $query);
	}

	if(isset($_POST['buynow']))
	{
		date_default_timezone_set('Asia/Kolkata');
		$productid = $_POST['productid'];
		$payment = $_POST['paymentmode'];
		$oid = rand(100000,999999);
		$curr_date = date("Y-m-d");
		$trstat = "Succeed";
		$delivery_status = "Order Placed";
		$ts = date("Y-m-d h:i:sa");
		$a = array(98123708984,56593014469,31173585882,63563292309,33774310543,35379417980,70258362679,45815337581);
		$rand = array_rand($a);
		$shipper_id = $a[$rand];
		$size = 'NA';
		$color = 'NA';
		if(isset($_POST['ac']))
			$color=$_POST['ac'];
		if(isset($_POST['as']))
			$size = $_POST['as'];
		$payment_id=rand(100000000,999999999);
		$temp = $_POST['cid'];
		

		$queryt = <<<EOF
      select cust_id from customer where email='$temp';
EOF;
		$queryt1 = <<<EOF
      select msrp,discount from products where prod_id=$productid;
EOF;
		$res = pg_query($db,$queryt) or die(pg_last_error($db));
		$res1 = pg_query($db,$queryt1) or die(pg_last_error($db));
		$row = pg_fetch_row($res);
		$row1 = pg_fetch_row($res1);
		$cust_id = $row[0];
		$disc = $row1[1];
		$price = (100 - $disc) * $row1[0]/100;
		

		$query1 = <<<EOF
      insert into payment values($payment_id,'$payment');
EOF;
		$query3 = <<<EOF
      insert into orders values($oid,'$curr_date',$cust_id,$payment_id,'$curr_date','$curr_date',$shipper_id,'$ts','$trstat','$delivery_status');
EOF;
		$query4 = <<<EOF
      insert into order_details values($oid,'$curr_date','$curr_date',$productid,$price,1,$disc,'$size','$color');
EOF;
		//echo "email=".$temp."<br>order id=".$oid."<br>payment id=".$payment_id."<br>".$cust_id."<br>";
		echo $disc;
		pg_query($db,$query1) or die(pg_last_error($db));
		//pg_query($db,$query2) or die(pg_last_error($db));
		pg_query($db,$query3) or die(pg_last_error($db));
		pg_query($db,$query4) or die(pg_last_error($db));
		header("location: payconf.php");
	}
	
?>