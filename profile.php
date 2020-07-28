<?php
	
	session_start();
	$pageTitle = 'Profile';
	include'init.php'; 

	if (isset($_SESSION['user'])){

	$getUser = $con->prepare("SELECT * FROM users WHERE UserName = ?");

	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();

	$userid = $info['userID'];
?> 

<h1 class="text-center">My Profile</h1>

<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body profile">
				<?php
				if(!empty($info['avatar'])) { 

								echo "<img class='img-responsive img-thumbnail img-circle center-block' src='admin/uploads/avatars/" . $info['avatar']  . "' alt='' />";
								
					 	    } else { 
							
								echo "<img class='img-responsive img-thumbnail img-circle center-block' src='avatar.png' alt='' />";
					
						 	}
				?>
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>
						<span>Login Name</span> : <?php echo $info['UserName'] ?>
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email</span> : <?php echo $info['Email'] ?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Full Name</span> : <?php echo $info['FullName'] ?>
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Registered Date</span> : <?php echo $info['Date'] ?>
					</li>
				</ul>
				<a href="profile-Edit.php" class="btn btn-default">Edit Information</a>
			</div>
		</div>
	</div>
</div>

<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Items</div>
			<div class="panel-body">
				<?php 	
					if (! empty(getAllFrom("*", "items", "where Member_ID = $userid", "", "Item_ID"))) { 
						echo '<div class="row">';
							foreach (getAllFrom("*", "items", "where Member_ID = $userid", "", "Item_ID") as $item) {
								echo '<div class="col-sm-6 col-md-3">';
									echo '<div class="thumbnail item-box">';
										if ($item['Approve'] == 0) { 
										echo '<span class="approve-status">Waiting Approval</span>'; 
										}
										echo '<span class="price-tag">' . $item['Price'] . '</span>';
										if (empty($item['avatar'])) {
											echo '<img class="img-responsive" src="shopping.jpg" alt"ach hadxi"' ;
										} else {
											echo "<img class='img-responsive' src='admin/uploads/avatars/item/" . $item['avatar'] . "' alt='Wrong SRC' />";
										}
										echo '<div class="caption">';
											echo '<h3><a href="items.php?itemid='. $item['item_ID'] .'">' . $item['Name'] . '</a></h3>';
											echo '<p>' . $item['Description'] . '</p>';
											echo '<div class="date">' . $item['Add_Date'] . '</div>';

										echo '</div>';
									echo '</div>';
								echo '</div>';
							}
						echo '</div>';
					} else {
						echo 'Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a>';
					}

				?>
			</div>
		</div>
	</div>
</div>

<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Latest Comm</div>
			<div class="panel-body">
				<?php	
					$myComments = getAllFrom("Comments", "comments", "where user_id = $userid", "", "C_id");
					
					if (! empty($myComments)) {
						foreach ($myComments as $comment) {
							echo '<p>' . $comment['Comments'] . '</p>';
						}
					} else {
						echo 'There\'s No Comments to Show';
					}
				?>
			</div>
		</div>
	</div>
</div>


<?php

} else {

	header('Location: login.php');
	exit();
}

	include $tpl . 'footer.php'; 

?>