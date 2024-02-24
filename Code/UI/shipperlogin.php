<?php include('server.php'); ?>
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
  <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body style="background: #9cd9eb">
  <div class="header1">
    <h2>Shipper Login</h2>
  </div>
  <form method="post" action="shipperlogin.php">
    <?php include('errors.php') ?>
    <div class="input-group">
      <label>Shipper ID:</label>
      <input type="text" name="shipperid" required>
    </div>
    <div class="input-group">
      </center><button type="submit" name="loginshipper" class="btn" style="color: white">Login</button>
    </div>
  </form>
</body>
</html>