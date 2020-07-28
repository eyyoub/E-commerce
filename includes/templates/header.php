<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php getTitle() ?></title>

		<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />	
		<link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>front.css" />
	</head>
	<body>
	<div class="upper-bar">
		<div class="container">
			<?php 
				if (isset($_SESSION['user'])) { 

						$userid = $_SESSION['uid'];

						$stmt2 = $con->prepare("SELECT
													* 
												FROM 
													users
												WHERE 
													userID = ?");

						$stmt2->execute(array($userid));

						$avatar = $stmt2->fetch();

				?>
					<div class="pull-right">
						<?php 
							if(!empty($avatar['avatar'])) { 

								echo "<img class='my-image img-thumbnail img-circle' src='admin/uploads/avatars/" . $avatar['avatar']  . "' alt='' />";
								
					 	    } else { 
							
								echo "<img class='my-image img-thumbnail img-circle' src='avatar.png' alt='' />";
					
						 	}
						?>
						<div class="btn-group my-info">
							<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<?php echo $sessionUser ?>
								<span class="caret"></span>
							</span>
							<ul class="dropdown-menu">
								<li><a href="profile.php">My Profile</a></li>
								<li><a href="newad.php">New Item</a></li>
								<?php 
								if($avatar['GroupID'] == 1){
									echo "<li><a href='admin/index.php'> Visit Admin </a></li>";		
								}
								?>
								<li><a href="profile.php#my-ads">My Items</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</div>
					</div>
					<?php

				} else {

			?>
			<a href="login.php">
			<span class="pull-right">Login/Signup</span>
			</a>
			<?php } ?>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="index.php">Homepage</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="app-nav">
	      <ul class="nav navbar-nav navbar-right">
	      	<?php 
	      		foreach (getAllFrom('*' ,'categories', 'where parent = 0', '', 'ID') as $cat) {
	      			echo '<li>
	      					<a href="categories.php?pageid='. $cat['ID'] .'&pagename=' . str_replace(' ', '-', $cat['Name']) . '">
	      						' . $cat['Name'] . '
	      					</a>
	      				  </li>';
	      		}
	        ?>
	      </ul>  
	    </div>
	  </div>
	</nav>
	