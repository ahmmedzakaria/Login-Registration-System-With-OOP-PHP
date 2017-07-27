 <?php 
 	include 'inc/header.php';
 	include 'lib/User.php';
 ?>
<?php 
 	$user=new User();
 	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['register'])){
 		$userRegi=$user->userRegistration($_POST);
 	}
 ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>User Registration</h2>
				</div>

				<div panel-body>
					<div style="max-width: 600px; margin: 15px auto;">
					<?php
							if(isset($userRegi)){
								echo $userRegi;
							}
						?>
						<form action="" method="POST">
							<div class="form-group">
								<label for="name">Your Name</label>
								<input type="text" name="name" id="name" class="form-control">
							</div>
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" name="username" id="username" class="form-control">
							</div>
							<div class="form-group">
								<label for="email">Email Address</label>
								<input type="text" name="email" id="email" class="form-control">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" id="password" class="form-control">
							</div>
							<button type="submit" name="register" class="btn btn-success">Submit</button>
						</form>
					</div>
				</div>
			</div>
			<?php include 'inc/footer.php';?>

