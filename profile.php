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

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update'])){
		$userupdate=$user->updateUserData($userid, $_POST);
		// if($userdata->name==$_POST['name'] AND $userdata->username==$_POST['username'] AND $userdata->email==$_POST['email']){
		/*	echo "<div class='alert alert-danger'><strong>Error!</strong> No Change Found</div>";;
		}else{
	 		
	 	}*/
 	}
?>


			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>User list <span class="pull-right"><a href="index.php" class="btn btn-primary">Back</a></span></h2>
				</div>

				<div panel-body>
					<div style="max-width: 600px; margin: 15px auto;">
					<?php
						if(isset($userupdate)){
							echo $userupdate;
						}
					?>
					<?php
						$userdata=$user->getUserById($userid);
						if($userdata){
					?>
						<form action="" method="POST">
						<div class="form-group">
								<label for="name">Your Name</label>
								<input type="text" name="name" id="name" class="form-control" value="<?php echo $userdata->name;?>">
							</div>
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" name="username" id="username" class="form-control" value="<?php echo $userdata->username;?>">
							</div>
							<div class="form-group">
								<label for="email">Email Address</label>
								<input type="text" name="email" id="email" class="form-control" value="<?php echo $userdata->email;?>">
							</div>
							<?php }?>
							<?php
								$sessionid=Session::getSession('id');
								if($sessionid == $userid){
							?>
							<button type="submit" name="update" class="btn btn-success">Update</button>
							<a class="btn btn-info" href="changepassword.php?id=<?php echo $userid; ?>">Change Password</a>
							<?php }?>
						</form>
					</div>
				</div>
			</div>
			<?php include 'inc/footer.php';?>

