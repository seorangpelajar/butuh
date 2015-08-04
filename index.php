<?php
session_start();
include 'connect.php';
?>
<html>
	<head>
		<title>Butuh - All daily needs</title>
		<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="javascript:;" class="navbar-brand">Butuh.com</a>
				</div>

				<div class="collapse navbar-collapse" id="navbar1">
					<ul class="nav navbar-nav">
						<li class="active"><a href="./">Home</a></li>
						<li><a href="./browse.php">Browse</a></li>
					</ul>
					<?php
					if (isset($_SESSION['login'])) {
						?>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="data.php">Data</a></li>
						<li><a href="action.php?logout=true">Logout</a></li>
					</ul>
						<?php
					} else {
					?>
					<form class="navbar-form navbar-right" role="login" method="post" action="action.php">
						<div class="form-group">
							<input name="user" type="text" class="form-control" placeholder="Username">
						</div>
						<div class="form-group">
							<input name="pass" type="password" class="form-control" placeholder="Password">
						</div>
						<button name="submit_login" type="submit" class="btn btn-default">Login</button>
					</form>
					<?php
					}
					?>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="row" style="margin-top:60px;">
				<div class="col-md-6">
					<legend>Recently Added</legend>
					<table class="table table-hover" style="font-size:12px;">
						<thead>
							<tr>
								<th>Date Created</th>
								<th>Item Name</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT * FROM item ORDER BY id DESC LIMIT 0,10";
							$sql = mysql_query($query);
							while ($hasil = mysql_fetch_array($sql)) {
								$date_created = $hasil['date_created'];
								$name = $hasil['name'];
								$price = $hasil['price'];
							?>
							<tr>
								<td><?php echo $date_created; ?></td>
								<td><?php echo $name; ?></td>
								<td>Rp<?php echo number_format($price); ?></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<legend>Total Daily Needs Budget</legend>
					<?php
					$query = "SELECT price FROM item";
					$sql = mysql_query($query);
					$prices=0;
					while ($hasil = mysql_fetch_array($sql)) {
						$price = $hasil['price'];
						$prices = $prices + $price;
					}
					?>
					<h2 align="center">Rp<?php echo number_format($prices); ?></h2>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<p align="center">Copyright &copy; 2015. Soluhfae Kawanurin. All rights reserved.</p>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="dist/js/jquery.js"></script>
		<script type="text/javascript" src="dist/js/bootstrap.js"></script>
	</body>
</html>