<?php
	$filepath=realpath(dirname(__FILE__));
	include_once $filepath.'/../lib/Session.php';
	Session::init();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login And Register System With PHP OOP</title>
		<link rel="stylesheet" type="text/css" href="inc/bootstrap.min.css">
		<script type="text/javascript" src="inc/jquery.min.js"></script>
		<script type="text/javascript" src="inc/bootstrap.min.js"></script>
	</head>
	<?php
		if(isset($_GET['action']) && $_GET['action'] == "logout"){
			Session::destroySession();
		}
	?>
	<body>
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="index.php">Login And Register System With PHP OOP</a>
					</div>
				</div>
				<ul class="nav navbar-nav pull-right">
				<?php
						$id=Session::getSession("id");
						$login=Session::getSession("login");
						if($login==true){
					?>
					<li><a href="index.php">Home</a></li>
					<li><a href="profile.php?id=<?php echo $id; ?>">Profile</a></li>
					<li><a href="?action=logout">Logout</a></li>
					<?php
						}else{
					?>
					<li><a href="login.php">Login</a></li>
					<li><a href="register.php">Register</a></li>
					<?php
						}
					?>
				</ul>
			</nav>