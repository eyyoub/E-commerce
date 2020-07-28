<?php 

	ob_start(); // Ouput Buffering Start

		session_start();
		if (isset($_SESSION['Username'])){
			
			$pageTitle = 'Dashboard';

			include 'init.php';

			/* Start Dashboard Page */


			$numUsers = 4;

			$cdtn = 0; // It's The Condition To Hide Admin From The Latest

			$latestUsers = getLatest("*", "users", "GroupID", $cdtn, "userID" , $numUsers);

			$numItems = 6; 

			$latestItems = getLatest("*", "items", "item_ID", "item_ID" ,"item_ID", $numItems);

			$numComments = 4;
			/*
			** getLatest : Fonction Reçoit Les Derniers Membres Inscris
			** $numUsers : Reçoit Le Nombre Des Derniers Membres Inscris
			*/

			
			?>

			<div class="container home-stats text-center">

				<h1>Dashboard</h1>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st-members">
							<i class="fa fa-users"></i>
							<div class="info">
								Total Members
								<span>
									<a href="members.php"><?php echo countItems('userID', 'users') ?></a>
								</span>	
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-pending">
							<i class="fa fa-user-plus"></i>
							<div class="info">
									Pending Members
								<span><a href="members.php?do=Manage&page=Pending">
								<?php  echo checkItem("Regstatus", "users", 0) ?></a></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-items">
							<i class="fa fa-tag"></i>
							<div class="info">
									Total Items
								<span><a href="items.php"><?php echo countItems('item_ID', 'items') ?></a></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-comments">
							<i class="fa fa-comments"></i>
							<div class="info">
									Total Comments
								<span><a href="comments.php"><?php echo countItems('C_id', 'comments') ?></a></span>
							</div>	
						</div>
					</div>
				</div>
			</div>

			<div class="container latest">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">							
							<div class="panel-heading">
								<i class="fa fa-users"></i> Latest <?php echo $numUsers;?> Registred Users
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">	
								<ul class="list-unstyled latest-users">						
									<?php
										if(!empty($latestUsers)) {
										foreach($latestUsers as $user) {

											echo '<li>';
												echo $user['UserName'] ;
												echo '<a href="members.php?do=Edit&userid=' . $user['userID'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';
														if ($user['Regstatus'] == 0) {
															echo "<a href='Members.php?do=Activate&userid=" . $user['userID'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check' ></i>Activate</a>";
														}
													echo '</span>';
												echo '</a>';
											echo '</li>';
										}
									}else {
										echo 'Ther\'s No Members To Show';
									}
								?>			
								</ul>					
							</div>	
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> Latest <?php echo $numItems ?> Items
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
										<ul class="list-unstyled latest-users">						
									<?php
										if(!empty($latestItems)) {
											foreach($latestItems as $item) {

												echo '<li>';
													echo $item['Name'] ;
													echo '<a href="items.php?do=Edit&itemid=' . $item['item_ID'] . '">';
														echo '<span class="btn btn-success pull-right">';
															echo '<i class="fa fa-edit"></i> Edit';
															if ($item['Approve'] == 0) {
																echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check' ></i>Approve</a>";
															}
														echo '</span>';
													echo '</a>';
												echo '</li>';
											}

										} else {
										echo 'Ther\'s No Items To Show';
									}

									?>
								</ul>
							</div>	
						</div>
					</div>
				</div>
				<!-- Start Latest Comment --> 
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">							
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i> Latest <?php echo $numComments ?> Comments
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">	
								<?php 
									$stmt = $con->prepare("SELECT 
																comments.*, users.UserName AS User, users.userID
														   FROM
														   		comments
														   INNER JOIN 
														   		users
														   ON
														   		users.userID = comments.user_id
														   	ORDER BY
														   	    C_id DESC
														   	LIMIT $numComments");
									
									// Execute The Statement

									$stmt->execute();

									// Assign To Variable

									$comments = $stmt->fetchAll();

									if (! empty($comments)) {
										foreach ($comments as $comment) {
											echo '<div class="comment-box">';
												echo '<span class="member-n">
													<a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
														' . $comment['User'] . '</a></span>';
												echo '<p class="member-c">' . $comment['Comments'] . '</p>';
											echo '</div>';

											echo '<div class="control-c">';
												echo '<a href="comments.php?do=Edit&comid=' .  $comment['C_id']  . '" class="btn btn-success s1">';
												echo '<i class="fa fa-edit"></i>Edit</a>';
												echo '<a href="comments.php?do=Delete&comid=' .  $comment['C_id']  . '" class="btn btn-danger confirm d1">';
												echo '<i class="fa fa-close"></i>Delete</a>';
																			
												if ($comment['Status'] == 0) {

													echo "<a href='comments.php?do=Approve&comid=".  $comment['C_id'] . "' class='btn btn-info activate confirm a1'><i class='fa fa-check' ></i>Approve</a>";

												}
											echo '</div>';
										}
									} else {
										echo 'There\'s No Comments To Show';
									}

									?>
							</div>	
						</div>
					</div>		
				</div>
				<!-- End Latest Comment --> 
			</div>

			<?php

			/* End Dashboard Page */
			
			

			include $tpl . 'footer.php';
		} else {
			header('Location: index.php');
			exit();
		}


		ob_end_flush();

?>