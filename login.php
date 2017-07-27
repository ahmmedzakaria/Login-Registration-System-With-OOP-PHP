<?php
	include 'inc/header.php';
	include 'lib/User.php';
	Session::checkLogin();
?>
<?php 
 	$user=new User();
 	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login'])){
 		$userlogin=$user->userLogin($_POST);
 	}
 ?>


<div class="panel panel-default">
	<div class="panel-heading">
		<h2>User Login</h2>
	</div>

	<div panel-body>
		<div style="max-width: 600px; margin: 15px auto;">
		<?php
			if(isset($userlogin)){
				echo $userlogin;
			}
		?>
			<form action="" method="POST">
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="text" name="email" id="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control">
				</div>
				<button type="submit" name="login" class="btn btn-success">Login</button>
			</form>
		</div>
	</div>
</div>
<?php include 'inc/footer.php';?>

