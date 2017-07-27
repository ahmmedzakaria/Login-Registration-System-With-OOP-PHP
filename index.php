<?php
 include 'lib/User.php';
 include 'inc/header.php';
 Session::checkSession();
 $user=new User();
?>
<?php
	$loginmsg=Session::getSession("loginmsg");
	if(isset($loginmsg)){
		echo $loginmsg;
	}
	Session::setSession("loginmsg",NULL);
?>



			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>User list <span class="pull-right"> Welcome! <strong>
						<?php
							$name=Session::getSession("name");
							if($name){
								echo $name;
							}
						?>
					</strong></span></h2>
				</div>

				<div panel-body>
					<table class="table table-striped">
						<tr>
							<th width="20%" class="text-center">Sirial</th>
							<th width="20%" class="text-center">Name</th> 
							<th width="20%" class="text-center">Username</th>
							<th width="20%" class="text-center">Email Address</th>
							<th width="20%" class="text-center">Action</th>
						</tr>
						<?php
							$user=new User();
							$userdata=$user->getUserData();
							if($userdata){
								$i=0;
								foreach ($userdata as $data) {
									$i++;
						?>
						<tr>
							<td align="center"><?php echo $i;?></td>
							<td align="center"><?php echo $data['name'];?></td>
							<td align="center"><?php echo $data['username'];?></td>
							<td align="center"><?php echo $data['email'];?></td>
							<td align="center"><a class="btn btn-primary" href="profile.php?id=<?php echo $data['id'];?>">View</a></td>
						</tr>
						<?php
							}
						}else{
						?>
						<tr>
							<td colspan="5"><h2>No user data found</h2></td>
						</tr>
						<?php }?>
					</table>
				</div>
			</div>
			<?php include 'inc/footer.php';?>

