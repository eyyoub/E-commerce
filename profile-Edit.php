<?php
	ob_start();
	session_start();

	$pageTitle = 'E-Profile';

		include'init.php'; 

		if (isset($_SESSION['user'])){

	$getUser = $con->prepare("SELECT * FROM users WHERE UserName = ?");

	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();

	$userid = $info['userID'];

?>

		<h1 class="text-center">Edit Profile</h1>
		<div class="container">
			<form class="form-horizontal" action="profile-Update.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="userid" value="<?php echo  $userid ?>" />
				<!-- Start Username Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10 col-md-4">
					<input type="text" name="username" class="form-control" value="<?php echo $info['UserName'] ?>" autocomplete="off" required="required" />
					</div>
				</div>
				<!-- End Username Field -->
				<!-- Start Password Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10 col-md-4">
					<input type="hidden" name="oldpassword" value="<?php echo $info['password'] ?>" />
					<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Don't Want To Change"/>
					</div>
				</div>
				<!-- End Password Field -->
				<!-- Start Email Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-4">
					<input type="email" name="email" value="<?php echo $info['Email'] ?>" class="form-control" required="required" />
					</div>
				</div>
				<!-- End Email Field -->
				<!-- Start Full Name Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10 col-md-4">
					<input type="text" name="full" value="<?php echo $info['FullName'] ?>" class="form-control"  />
					</div>
				</div>
				<!-- End Full Name Field -->
				<!-- Start Avatar Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">User Avatar</label>
						<div class="col-sm-10 col-md-6">
							<input type="file" name="avatar" class="form-control"/>
						</div>
					</div>
				<!-- End Avatar Field -->
				<!-- Start submit Field -->
				<div class="form-group form-group-lg">
					<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Save" class="btn btn-primary" />
					</div>
				</div>
				<!-- End submit Field -->
			</form>
		</div>

	<?php

}

	include $tpl . 'footer.php'; 
	ob_end_flush();

?>