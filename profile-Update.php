<?php
	ob_start();
	session_start();

	$pageTitle = 'U-Profile';

		include'init.php'; 

		echo "<h1 class='text-center'>Update Profile</h1>";
		echo "<div class='container'>";


		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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

				move_uploaded_file($avatarTmp, "admin\uploads\avatars\\" . $avatar);
				
				$stmt2 = $con->prepare("SELECT
											* 
										FROM 
											users
										WHERE 
											UserName = ? 
										AND 
											userID != ?");

				$stmt2->execute(array($user, $id));

				$count = $stmt2->rowCount();

				if($count == 1) {

					$theMsg = '<div class="alert alert-danger"> Sorry This User Is Exist </div>';

					redirectHome($theMsg, 'back');

				} else {

					// Update The Database With This Info

					$stmt = $con->prepare("UPDATE users SET UserName = ?, Email = ?,FullName = ?, password = ? , avatar = ? WHERE userID = ?");
					$stmt->execute(array($user , $email , $name, $pass, $avatar, $id));

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


	include $tpl . 'footer.php'; 
	ob_end_flush();

?>