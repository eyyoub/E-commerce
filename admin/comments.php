<?php

	/*
	=======================================================
	== Manage Comments Page
	== You Can Edit | Delete | Approve Comments From Here
	=======================================================
	*/

	session_start();

	$pageTitle = 'Comments';

		if (isset($_SESSION['Username'])){
			
			include 'init.php';
			
			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // hadi kat3ni ila kan do fiha ch haja ktbha sinn ktab 'Manage'

			// Start Manage Page

			if ($do == 'Manage'){ // Manage Comment Page 


				// Select All Users Users Except Admin

				$stmt = $con->prepare("SELECT 
											comments.*, items.Name AS Item_Name, users.UserName AS User
									   FROM
									   		comments
									   INNER JOIN 
									   		items
									   ON
									   		items.item_ID = comments.item_id
									   INNER JOIN 
									   		users
									   ON
									   		users.userID = comments.user_id
									   ORDER BY 
									   		C_id DESC");
				
				// Execute The Statement

				$stmt->execute();

				// Assign To Variable

				$comments = $stmt->fetchAll();

				if (!empty($comments)) {

					?>

					<h1 class="text-center">Manage Comments</h1>
					<div class="container">
						<div class="table-responsive">
							<table class="main-table text-center table table-bordered">
								<tr>
									<td>#ID</td>
									<td>Comments</td>
									<td>Item Name</td>
									<td>User Name</td>
									<td>Added Date</td>
									<td>Control</td>
								</tr>

								<?php

								foreach ($comments as $comment) {

									echo"<tr>";
										echo "<td>" . $comment['C_id'] . "</td>";
										echo "<td>" . $comment['Comments'] . "</td>";
										echo "<td>" . $comment['Item_Name'] . "</td>";
										echo "<td>" . $comment['User'] . "</td>";
										echo "<td>" . $comment['C_Date'] . "</td>";
										echo "<td>
										<a href='comments.php?do=Edit&comid=" . $comment['C_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='comments.php?do=Delete&comid=" . $comment['C_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close' ></i>Delete</a>";
										
										if ($comment['Status'] == 0) {

											echo "<a href='comments.php?do=Approve&comid=" . $comment['C_id'] . "' class='btn btn-info activate'><i class='fa fa-check' ></i>Approve</a>";

										}
										echo "</td>" ;
									echo "</tr>";
								}

								?>

							</table>
						</div>
					</div>

				<?php } else{

					echo '<div class="container"';
						echo "</br>";
						echo '<center><div class="alert alert-info">There\'s No Comments To Manage</div></center>';
					echo '</div>';

					} ?>

			<?php 

			} elseif ($do == 'Edit'){ // Edit Page

				// Check If Get Request userID Is Numeric & Get The Integer Value Of It

				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
				
				// Select All Data Depend On This ID

				$stmt = $con->prepare("SELECT * FROM comments WHERE C_id = ?");
				
				// Execute Query

				$stmt->execute(array($comid));
				
				// Fetch The Data

				$comments = $stmt->fetch();
					
				// The Tow Count

				$count = $stmt->rowCount();

				// If There's Such ID Show The Form

				if ($count > 0){ ?>

					<h1 class="text-center">Edit Comment</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Update" method="POST">
							<input type="hidden" name="comid" value="<?php echo  $comid ?>" />
							<!-- Start Comment Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Comment</label>
								<div class="col-sm-10 col-md-4">
									<textarea class="form-control" cols="100" rows="10" name="comment"><?php echo $comments['Comments'] ?></textarea>
								</div>
							</div>
							<!-- End Comment Field -->				
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

					// 	Get Variables From The Form

					$comid 	= $_POST['comid'];
					$comment 	= $_POST['comment'];
	

					// Update The Database With This Info

					$stmt = $con->prepare("UPDATE comments SET Comments = ? WHERE C_id = ?");

					$stmt->execute(array($comment ,$comid));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirectHome($theMsg, 'back');
				

				} else {

					$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly </div>';

					redirectHome($theMsg);
				}

				echo "</div>";

			} elseif ($do == 'Delete') { // Delete Comment Page

				echo "<h1 class='text-center'>Delete Comment</h1>";
				echo "<div class='container'>";

					// Check If Get Request userID Is Numeric & Get The Integer Value Of It

					$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
					
					// Select All Data Depend On This ID

					$check = checkItem("C_id", "comments", $comid);
					
					// If There's Such ID Show The Form

					if ($check > 0){ 

							$stmt = $con->prepare("DELETE FROM comments WHERE C_id = :yid");

							$stmt->bindParam(":yid" , $comid);

							$stmt->execute();

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

						redirectHome($theMsg, 'back');

					} else {

						$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

						redirectHome($theMsg);
					}

				echo '</div>';
	
			} elseif ($do == 'Approve') { // Approve Comment Page

				echo "<h1 class='text-center'>Approve Comment</h1>";
				echo "<div class='container'>";

					// Check If Get Request comid Is Numeric & Get The Integer Value Of It

					$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
					
					// Select All Data Depend On This ID

					$check = checkItem("C_id", "comments", $comid);
					
					// If There's Such ID Show The Form

					if ($check > 0){ 

							$stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_id = ?");

							$stmt->execute(array($comid));

							// Echo Success Message

							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approved</div>';

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