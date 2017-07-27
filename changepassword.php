<?php 
	include 'lib/User.php';
	include 'inc/header.php';

?>

<?php
	if(isset($_GET['id'])){
		$userid=(int)$_GET['id'];
		$sessionid=Session::getSession('id');
		if($sessionid != $userid){
			header("Location: index.php");
		}
	}
	$user = new User();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['updatepassword'])){
 		$userupdate=$user->updatePassword($userid, $_POST);
 	}
?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Change Password <span class="pull-right"><a href="profile.php" class="btn btn-primary">Back</a></span></h2>
				</div>

				<div panel-body>
				<div style="max-width: 600px; margin: 15px auto;">
					<?php
						if(isset($userupdate)){
							echo $userupdate;
						}
					?>
						<form action="" method="POST">
						<div class="form-group">
								<label for="oldpassword">Old Pasword</label>
								<input type="password" name="oldpassword" id="oldpassword" class="form-control">
							</div>
							<div class="form-group">
								<label for="newpassword">New Password</label>
								<input type="password" name="newpassword" id="newpassword" class="form-control">
							</div>
							<?php
								$sessionid=Session::getSession('id');
								if($sessionid == $userid){
							?>
							<button type="submit" name="updatepassword" class="btn btn-success">Update</button>
							<?php }?>
						</form>
					</div>
				</div>
			</div>
			<?php include 'inc/footer.php';?>

