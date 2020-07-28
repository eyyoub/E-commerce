<?php

	/*
	=======================================================
	== Manage Members Page
	== You Can Add | Edit | Delete Members From Here
	=======================================================
	*/

	session_start();

	$pageTitle = 'Members';

		if (isset($_SESSION['Username'])){
			
			include 'init.php';
			
			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // hadi kat3ni ila kan do fiha ch haja ktbha sinn ktab 'Manage'

			// Start Manage Page

			if ($do == 'Manage'){ // Manage Members Page 

				$query = '';

				if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

					$query = 'AND Regstatus = 0';
				}


				// Select All Users Users Except Admin

				$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY userID DESC");
				
				// Execute The Statement

				$stmt->execute();

				// Assign To Variable

				$rows = $stmt->fetchAll();

				if (!empty($rows)) {

					?>

					<h1 class="text-center">Manage Members</h1>
					<div class="container">
						<div class="table-responsive">
							<table class="main-table manage-members text-center table table-bordered">
								<tr>
									<td>#ID</td>
									<td>Avatar</td>
									<td>Username</td>
									<td>Email</td>
									<td>Full Nmae</td>
									<td>Registred Date</td>
									<td>Control</td>
								</tr>

								<?php

								foreach ($rows as $row) {

									echo"<tr>";
										echo "<td>" . $row['userID'] . "</td>";
										echo "<td>";
										if (empty($row['avatar'])) {
											echo 'No Image';
										} else {
											echo "<img src='uploads/avatars/" . $row['avatar'] . "' alt='' />";
										}
										echo "</td>";
										echo "<td>" . $row['UserName'] . "</td>";
										echo "<td>" . $row['Email'] . "</td>";
										echo "<td>" . $row['FullName'] . "</td>";
										echo "<td>" . $row['Date'] . "</td>";
										echo "<td>
										<a href='Members.php?do=Edit&userid=" . $row['userID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='Members.php?do=Delete&userid=" . $row['userID'] . "' class='btn btn-danger confirm'><i class='fa fa-close' ></i>Delete</a>";
										
										if ($row['Regstatus'] == 0) {

											echo "<a href='Members.php?do=Activate&userid=" . $row['userID'] . "' class='btn btn-info activate'><i class='fa fa-check' ></i>Activate</a>";

										}
										echo "</td>" ;
									echo "</tr>";
								}


								?>
								
							</table>
						</div>
						<a href="Members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
					</div>

					<?php } else{

						echo '<div class="container"';
							echo "</br>";
							echo '<center><div class="alert alert-info">There\'s No Members To Manage</div></center>';
							echo '<a href="Members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>';
						echo '</div>';

						}?>
			<?php 

			} elseif ($do == 'Add') { ?>
				
				<!-- Add Members Page -->

				<h1 class="text-center">Add New Member</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
							<!-- Start Username Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop"/>
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Password Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10 col-md-4">
									<input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Be Hard And Complex"/>
									<i class="show-pass fa fa-eye fa-2x"></i>
								</div>
							</div>
							<!-- End Password Field -->
							<!-- Start Email Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10 col-md-4">
								<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
								</div>
							</div>
							<!-- End Email Field -->
							<!-- Start Full Name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Full Name</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page" />
								</div>
							</div>
							<!-- End Full Name Field -->
							<!-- Start Avatar Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">User Avatar</label>
								<div class="col-sm-10 col-md-6">
									<input type="file" name="avatar" class="form-control" required="required" />
								</div>
							</div>
							<!-- End Avatar Field -->
							<!-- Start submit Field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
								</div>
							</div>
							<!-- End submit Field -->
						</form>
					</div>

		<?php	

			}elseif ($do == 'Insert') {
				
				// Insert Member Page

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					echo "<h1 class='text-center'>Insert Member</h1>";
					echo "<div class='container'";

					// Upload Variables

					$avatarName = $_FILES['avatar']['name'];
					$avatarSize = $_FILES['avatar']['size'];
					$avatarTmp	= $_FILES['avatar']['tmp_name'];
					$avatarType = $_FILES['avatar']['type'];

					// List Of Allowed File Typed To Upload

					$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

					// Get Avatar Extension

					$serchextention = explode('.', $avatarName); 

					$extension = end($serchextention);

					$avatarExtension = strtolower($extension);

					// 	Get Variables From The Form

					$user 	= $_POST['username'];
					$pass 	= $_POST['password'];
					$email 	= $_POST['email'];
					$name 	= $_POST['full'];

					$hashpass 	= sha1($_POST['password']);
			
					// Validate The Form

					$formErrors = array();

					echo '</br>';
					
					if (strlen($user) < 4){

						$formErrors[] = 'Username Can\'t be Less Than <strong>4 Characters</strong>';
					}

					if (strlen($user) > 20){

						$formErrors[] = 'Username Can\'t be More Than <strong>20 Characters</strong>';
					}

					if (empty($user)) {

						$formErrors[] = 'Username Can\'t be <strong>Empty</strong>';

					}

					if (empty($pass)) {

						$formErrors[] = 'Password Can\'t be <strong>Empty</strong>';

					}

					if (empty($name)) {

						$formErrors[] = 'Full name Can\'t be <strong>Empty</strong>';
					}

					if (empty($email)) {

						$formErrors[] = 'Email Can\'t be <strong>Empty</strong>';
					}

					if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
						$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
					}

					if (empty($avatarName)) {
						$formErrors[] = 'Avatar Is <strong>Required</strong>';
					}

					if ($avatarSize > 1048576) {
						$formErrors[] = 'Avatar Cant Be Larger Than <strong>1MB</strong>';
					}

					// Loop Into Errors Arrau And Echo It

					foreach ($formErrors as $error) {

						echo  '<div class="alert alert-danger">' .  $error .  '</div>';

					}

					// Check If There's No Errors Proceed The Update Operation

					if (empty($formErrors)) {

						$avatar = rand(0, 1000000000) . '_' . $avatarName;

						move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

						//Check If User Exist In Database
						

						$check = checkItem("UserName", "users", $user);

						if ($check == 1){

							$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

							redirectHome($theMsg, 'back');

						} else {


								// Insert Userinfo In Database

								$stmt = $con->prepare("INSERT INTO users(UserName, password, Email, FullName, Regstatus, Date, avatar)
														VALUES(:yuser, :ypass, :yemail, :yname, 1, now() , :yavatar) ");
								$stmt->execute(array(

									'yuser' => $user,  
									'ypass' => $hashpass,
									'yemail' => $email,
									'yname' => $name,
									'yavatar' => $avatar

									));

								// Echo Success Message

								$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
							
								redirectHome($theMsg, 'back');
							}
					}

				} else {

					echo "<div class='container'>";

					$theMsg = '<div class="alert alert-danger">Sorry You can\'t Browse This Page Directly</div>';

					redirectHome($theMsg);

					echo "</div>";

				}

				echo "</div>";

			} elseif ($do == 'Edit'){ // Edit Page

				// Check If Get Request userID Is Numeric & Get The Integer Value Of It

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				
				// Select All Data Depend On This ID

				$stmt = $con->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
				
				// Execute Query

				$stmt->execute(array($userid));
				
				// Fetch The Data

				$row = $stmt->fetch();
					
				// The Tow Count

				$count = $stmt->rowCount();

				// If There's Such ID Show The Form

				if ($count > 0){ ?>

					<h1 class="text-center">Edit Member</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="userid" value="<?php echo  $userid ?>" />
							<!-- Start Username Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="username" class="form-control" value="<?php echo $row['UserName'] ?>" autocomplete="off" required="required" />
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Password Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10 col-md-4">
								<input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Don't Want To Change"/>
								</div>
							</div>
							<!-- End Password Field -->
							<!-- Start Email Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10 col-md-4">
								<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
								</div>
							</div>
							<!-- End Email Field -->
							<!-- Start Full Name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Full Name</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required" />
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

				// If There's No Such ID Show Error Message

				} else {

					echo "<div class='container'>";

					$theMsg = '<div class="alert alert-danger">There\'s No Such ID</div>';

					redirectHome($theMsg);

					echo "</div>";
				}

			}elseif($do == 'Update') { // Update Page

				echo "<h1 class='text-center'>Update Member</h1>";
				echo "<div class='container'>";


				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$avatarName = $_FILES['avatar']['name'];
					$avatarSize = $_FILES['avatar']['size'];
					$avatarTmp	= $_FILES['avatar']['tmp_name'];
					$avatarType = $_FILES['avatar']['type'];

					// List Of Allowed File Typed To Upload

					$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

					// Get Avatar Extension

					$serchextention = explode('.', $avatarName); 

					$extension = end($serchextention);

					$avatarExtension = strtolower($extension);

					// 	Get Variables From The Form

					$id 	= $_POST['userid'];
					$user 	= $_POST['username'];
					$email 	= $_POST['email'];
					$name 	= $_POST['full'];

					//Password Trick

					// Condition ? True : False;

					$pass = empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']);

					// Validate The Form

					$formErrors = array();

					echo '</br>';
					
					if (strlen($user) < 4){

						$formErrors[] = 'Username Can\'t be Less Than <strong>4 Characters</strong>';
					}

					if (strlen($user) > 20){

						$formErrors[] = 'Username Can\'t be More Than <strong>20 Characters</strong>';
					}

					if (empty($user)) {

						$formErrors[] = 'Username Can\'t be <strong>Empty</strong>';

					}

					if (empty($name)) {

						$formErrors[] = 'Full name Can\'t be <strong>Empty</strong>';
					}

					if (empty($email)) {

						$formErrors[] = 'Email Can\'t be <strong>Empty</strong>';
					}

					if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
						$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
					}

					if (empty($avatarName)) {
						$formErrors[] = 'Avatar Is <strong>Required</strong>';
					}

					if ($avatarSize > 1048576) {
						$formErrors[] = 'Avatar Cant Be Larger Than <strong>1MB</strong>';
					}

					// Loop Into Errors Arrau And Echo It

					foreach ($formErrors as $error) {

						echo  '<div class="alert alert-danger">' .  $error .  '</div>';

					}

					// Check If There's No Errors Proceed The Update Operation

					if (empty($formErrors)) {

						$avatar = rand(0, 1000000000) . '_' . $avatarName;

						move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
						
						$stmt2 = $con->prepare("SELECT
													* 
												FROM 
													users
												WHERE 
													Username = ? 
												AND 
													userid != ?");

						$stmt2->execute(array($user, $id));

						$count = $stmt2->rowCount();

						if($count == 1) {

							$theMsg = '<div class="alert alert-danger"> Sorry This User Is Exist </div>';

							redirectHome($theMsg, 'back');

						} else {

							// Update The Database With This Info

							$stmt = $con->prepare("UPDATE users SET UserName = ?, Email = ?,FullName = ?, password = ? , avatar = ? WHERE userID = ?");
							$stmt->execute(array($user , $email , $name, $pass, $avatar , $id));

							// Echo Success Message

							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

							redirectHome($theMsg, 'back');
						}
					}
						
				} else {

					$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly </div>';

					redirectHome($theMsg);
				}

				echo "</div>";

			} elseif ($do == 'Delete') { // Delete Member Page

				echo "<h1 class='text-center'>Delete Member</h1>";
				echo "<div class='container'>";

					// Check If Get Request userID Is Numeric & Get The Integer Value Of It

					$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
					
					// Select All Data Depend On This ID

					$check = checkItem("Userid", "users", $userid);
					
					// If There's Such ID Show The Form

					if ($check > 0){ 

						$stmt = $con->prepare("DELETE FROM users WHERE userID = :yuser");

						$stmt->bindParam(":yuser" , $userid);

						$stmt->execute();

							// Echo Success Message

							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

							redirectHome($theMsg, 'back');

					} else {

						$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

						redirectHome($theMsg);
					}

				echo '</div>';
	
			} elseif ($do == 'Activate') { // Activate Member Page

				echo "<h1 class='text-center'>Activate Member</h1>";
				echo "<div class='container'>";

					// Check If Get Request userID Is Numeric & Get The Integer Value Of It

					$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
					
					// Select All Data Depend On This ID

					$check = checkItem("Userid", "users", $userid);
					
					// If There's Such ID Show The Form

					if ($check > 0){ 

						$stmt = $con->prepare("UPDATE users SET Regstatus = 1 WHERE userID = ?");

						$stmt->execute(array($userid));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';

						redirectHome($theMsg, 'back');

					} else {

						$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

						redirectHome($theMsg);
					}

				echo '</div>';

			}
			
			include $tpl . 'footer.php';
		
		} else {

			header('Location: index.php');

			exit();
		}