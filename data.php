<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['login'])) {
	header('location: index.php');
}
?>
<html>
	<head>
		<title>CRUD item</title>
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
						<li><a href="./">Home</a></li>
						<li><a href="./browse.php">Browse</a></li>
					</ul>
					<?php
					if (isset($_SESSION['login'])) {
						?>
					<ul class="nav navbar-nav navbar-right">
						<li class="active"><a href="data.php">Data</a></li>
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
				<div class="col-md-4">
					<form class="form-horizontal" role="form" method="post" action="action.php">
						<div class="form-group">
							<label class="control-label col-sm-4" for="itemName">Item Name</label>
							<div class="col-sm-8">
								<input name="name" type="text" class="form-control" id="itemName" placeholder="Item Name">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="itemPrice">Price</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">Rp</span>
									<input name="price" type="text" class="form-control" id="itemPrice" placeholder="Item Price">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
								<button name="item_submit" type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8">
					<table class="table table-hover" style="font-size:12px;">
						<thead>
							<tr>
								<th>Date Created</th>
								<th>Item Name</th>
								<th>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT * FROM item ORDER BY date_created DESC";
							$sql = mysql_query($query);
							while ($hasil = mysql_fetch_array($sql)) {
								$id = $hasil['id'];
								$date_created = $hasil['date_created'];
								$name = $hasil['name'];
								$price = $hasil['price'];							
							?>
							<tr>
								<td><?php echo $date_created; ?></td>
								<td><?php echo $name; ?></td>
								<td>Rp<?php echo number_format($price); ?></td>
								<td>
									<button type="button" class="btn btn-info btn-edit btn-sm" onclick="edit('<?php echo $id; ?>','<?php echo $name; ?>','<?php echo $price; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
									<button type="button" class="btn btn-danger btn-delete btn-sm" onclick="$('#delete').val('<?php echo $id; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
								</td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<p align="center">Copyright &copy; 2015. Soluhfae Kawanurin. All rights reserved.</p>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title"id="myModalLabel">Edit</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" role="form">
							<input id="itemID" type="hidden" value="">
							<div class="form-group">
								<label class="control-label col-sm-4" for="itemName2">Item Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="itemName2" placeholder="Item Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="itemPrice2">Price</label>
								<div class="col-sm-8">
									<div class="input-group">
										<span class="input-group-addon">Rp</span>
										<input type="text" class="form-control" id="itemPrice2" placeholder="Item Price">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button id="btn_edit" type="button" class="btn btn-info">Edit</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title"id="myModalLabel">Delete</h4>
					</div>
					<div class="modal-body">
						Are your sure want to delete this item?
						<input id="delete" type="hidden" value="">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button id="btn_delete" type="button" class="btn btn-danger">Yes</button>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="dist/js/jquery.js"></script>
		<script type="text/javascript" src="dist/js/bootstrap.js"></script>
		<script type="text/javascript" src="dist/js/modal.js"></script>
		<script type="text/javascript">
		function edit(id,name,price) {
			$('#itemID').val(id);
			$('#itemName2').val(name);
			$('#itemPrice2').val(price);
		}
		$(function() {
			$(document).on('click','.btn-edit',function(e) {
				e.preventDefault();
				$('#modal_edit').modal('show');
			});
		});
		$(function() {
			$(document).on('click','.btn-delete',function(e) {
				e.preventDefault();
				$('#modal_delete').modal('show');
			});
		});
		$('#btn_edit').click(function() {
			var i = $('#itemID').val();
			var n = $('#itemName2').val();
			var p = $('#itemPrice2').val();

			$.post("action.php", {item_edit: true, id: i, name: n, price: p})
			.done(function(data) {
				location.reload();
			});
		});
		$('#btn_delete').click(function() {
			var i = $('#delete').val();

			$.post("action.php", {item_delete: true, id: i})
			.done(function(data) {
				location.reload();
			});
		});
		</script>
	</body>
</html>