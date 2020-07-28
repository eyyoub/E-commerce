<?php 

		session_start();
		
		$noNavbar = ''; // pour ne pas afficher la page de navigation 'navbar'
		$pageTitle = 'Login';

		if (isset($_SESSION['Username'])){
			header('Location: dashboard.php');
		}
		
		include'init.php';
		
		// Check If User Coming From HTTP Post Request

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$username = $_POST['user'];
			$password = $_POST['pass'];
			$hashedpass = sha1($password);

			// Check If The User Exist In Database

			$stmt = $con->prepare("SELECT userID, UserName, password FROM users WHERE UserName = ? AND password = ? AND GroupID = 1 LIMIT 1");
			$stmt->execute(array($username, $hashedpass));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			// If Count > 0 This Mean The Database Contain Record About This Username

			if ($count > 0) {
				$_SESSION['Username'] = $username; // Register Session Name
				$_SESSION['ID'] = $row['userID']; //Resgester Session ID
				$_SESSION['UserN'] = $row['UserName']; //Resgester Session name
				header('Location: dashboard.php'); // Redirect To Dashboard Page
				exit();
			}
		}
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	<h4 class="text-center"> Admin Login </h4>
	<input class="form-control" type="test" name="user" placeholder="Username" autocomplete="off" />
	<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" /> <!-- had new-passeword bach may39lch 3la lpassword omaykmlch automatiquement -->
	<input class="btn btn-primary btn-block" type="submit" value="Login" />
</form>

<?php include $tpl . 'footer.php'; ?>