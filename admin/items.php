<?php

/*
=====================================================
=== Items Page
=====================================================

*/
	ob_start(); // Ouput Buffering Start

		session_start();

		$pageTitle = 'Items';
		
		if (isset($_SESSION['Username'])){

			include 'init.php';

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

			if ($do == 'Manage') { 
			
				
				$stmt = $con->prepare("SELECT 
											items.*,
									   		categories.Name AS Cat_Name,
									   		users.UserName AS USER 
									   FROM 
									   		items

									   INNER JOIN 
									   		categories 
									   ON 
											categories.ID = items.CAT_ID

									   INNER JOIN 
									   		users 
									   ON 
											users.userID = items.Member_ID
									   ORDER BY 
									   		item_ID DESC");
				
				// Execute The Statement

				$stmt->execute();

				// Assign To Variable

				$items = $stmt->fetchAll();

				if (! empty($items)) {

				?>

				<h1 class="text-center">Manage Items</h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table manage-items text-center table table-bordered ">
							<tr>
								<td>#ID</td>
								<td>Avatar</td>
								<td>Name</td>
								<td>Description</td>
								<td>Price</td>
								<td>Adding Date</td>
								<td>Phone Number</td>
								<td>Category</td>
								<td>Username</td>
								<td>Control</td>
							</tr>

							<?php

							foreach ($items as $item) {

								echo"<tr>";
									echo "<td>" . $item['item_ID'] . "</td>";
									echo "<td>";
										if (empty($item['avatar'])) {
											echo 'No Image';
										} else {
											echo "<img src='uploads/avatars/item/" . $item['avatar'] . "' alt='Wrong SRC' />";
										}
									echo "</td>";
									echo "<td>" . $item['Name'] . "</td>";
									echo "<td>" . $item['Description'] . "</td>";
									echo "<td>" . $item['Price'] . "</td>";
									echo "<td>" . $item['Add_Date'] . "</td>";
									echo "<td>" . $item['tel'] . "</td>";
									echo "<td>" . $item['Cat_Name'] . "</td>";
									echo "<td>" . $item['USER'] . "</td>";

									echo "<td>
									<a href='items.php?do=Edit&itemid=" . $item['item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
									<a href='items.php?do=Delete&itemid=" . $item['item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close' ></i>Delete</a>";
									if ($item['Approve'] == 0) {

										echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' class='btn btn-info activate'><i class='fa fa-check' ></i>Approve</a>";

									}
									echo "</td>" ;
								echo "</tr>";
							}


							?>
							
						</table>
					</div>
					<a href="items.php?do=Add" class="btn btn-sm  btn-primary"><i class="fa fa-plus"></i> New Item</a>
				</div>


				<?php } else{

					echo '<div class="container"';
						echo "</br>";
						echo '<center><div class="alert alert-info">There\'s No Items To Manage</div></center>';
						echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> New Item</a>';
					echo '</div>';

					}?>

			<?php 
				

			} elseif ($do == 'Add') { ?>

			<h1 class="text-center">Add New Item</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
							<!-- Start Name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="name" class="form-control" required="required" placeholder="Name of The Item"/>
								</div>
							</div>
							<!-- End Name Field -->
							<!-- Start Description Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="description" class="form-control" required="required" placeholder="Description of The Item"/>
								</div>
							</div>
							<!-- End Description Field -->
							<!-- Start Price Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Price</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="price" class="form-control" required="required" placeholder="Price of The Item"/>
								</div>
							</div>
							<!-- End Price Field -->
							<!-- Start Country Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Country</label>
								<div class="col-sm-10 col-md-4">
								<input type="text" name="country" class="form-control" required="required" placeholder="Country of The Item"/>
								</div>
							</div>
							<!-- End Country Field -->
							<!-- Start Status Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Status</label>
								<div class="col-sm-10 col-md-4">
									<select name="status">
										<option value="0">...</option>
										<option value="1">New</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Very Old</option>
									</select>
								</div>
							</div>
							<!-- End Status Field -->
							<!-- Start Members Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Member</label>
								<div class="col-sm-10 col-md-4">
									<select name="member">
										<option value="0">...</option>
										<?php
											$allmember = getAllFrom("*", "users", "", "", "userID");
											foreach ($allmember as $user) {
												
												echo "<option value='". $user['userID'] ."'>" . $user['UserName'] . "</option>";
											}
										?>
									</select>
								</div>
							</div>
							<!-- End Members Field -->
							<!-- Start Categories Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Categorie</label>
								<div class="col-sm-10 col-md-4">
									<select name="categories">
										<option value="0">...</option>
										<?php
											$allcats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
											foreach ($allcats as $cat) {	
												echo "<option value='". $cat['ID'] ."'>" . $cat['Name'] . "</option>";
												$allchilds = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
												foreach ($allchilds as $child) {
													echo "<option value='". $child['ID'] ."'>" . $child['Name'] . "</option>";
												}
											}
										?>
									</select>
								</div>
							</div>
							<!-- End Categories Field -->
							<!-- Start Avatar Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Item Avatar</label>
								<div class="col-sm-10 col-md-6">
									<input type="file" name="avatar" class="form-control" required="required" />
								</div>
							</div>
							<!-- End Avatar Field -->
							<!-- Start Tel Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Phone Number</label>
								<div class="col-sm-10 col-md-6">
									<input 
										type="text" 
										name="tel" 
										class="form-control" 
										placeholder="For More Chance To By Your Item" />
								</div>
							</div>
							<!-- End Tel Field -->
							<!-- Start Tags Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Tags</label>
								<div class="col-sm-10 col-md-6">
									<input 
										type="text" 
										name="tags" 
										class="form-control" 
										placeholder="Separate Tags With Comma (,)" />
								</div>
							</div>
							<!-- End Tags Field -->
							<!-- Start submit Field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
								</div>
							</div>
							<!-- End submit Field -->
						</form>
					</div>

				<?php


			} elseif ($do == 'Insert') {


				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					echo "<h1 class='text-center'>Insert Item</h1>";
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

					$name 		= $_POST['name'];
					$desc 		= $_POST['description'];
					$price 		= $_POST['price'];
					$country 	= $_POST['country'];
					$status 	= $_POST['status'];
					$tel 	 	= $_POST['tel'];
					$member 	= $_POST['member'];
					$cat 		= $_POST['categories'];
					$tags 		= $_POST['tags'];
	
					// Validate The Form

					$formErrors = array();

					echo '</br>';
					
					if (empty($name)){

						$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
					}

					if (empty($desc)){

						$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';

					}

					if (empty($price)) {

						$formErrors[] = 'Price Can\'t be <strong>Empty</strong>';

					}

					if (empty($country)) {

						$formErrors[] = 'Country Can\'t be <strong>Empty</strong>';

					}

					if ($status == 0) {

						$formErrors[] = 'You Must Chose The <strong>Status</strong>';

					}

					if ($member == 0) {

						$formErrors[] = 'You Must Chose The <strong>Member</strong>';

					}

					if ($cat == 0) {

						$formErrors[] = 'You Must Chose The <strong>Categorie</strong>';

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

							move_uploaded_file($avatarTmp, "uploads\avatars\item\\" . $avatar);

							// Insert Userinfo In Database

							$stmt = $con->prepare("INSERT INTO 
										Items(Name, Description, Price, Country_Made, Status, tel, Approve, Add_Date, Cat_ID, Member_ID, avatar,tags)
								VALUES(:yname, :ydesc, :yprice, :ycountry, :ystatus, :ytel, 1 ,now(), :ycat, :ymember, :yavatar, :ytags)");
							$stmt->execute(array(

								'yname' 	=> $name,  
								'ydesc' 	=> $desc,
								'yprice' 	=> $price,
								'ycountry' 	=> $country,
								'ystatus' 	=> $status,
								'ytel'      => $tel,
								'ycat' 		=> $cat,
								'ymember' 	=> $member,
								'yavatar'   => $avatar,
								'ytags'		=> $tags
								
								));

							// Echo Success Message

							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
						
							redirectHome($theMsg, 'back');
							
					}

				} else {

					echo "<div class='container'>";

					$theMsg = '<div class="alert alert-danger">Sorry You can\'t Browse This Page Directly</div>';

					redirectHome($theMsg);

					echo "</div>";

				}

				echo "</div>";
				
			} elseif ($do == 'Edit') { // Edit Page

				// Check If Get Request item Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				
				// Select All Data Depend On This ID

				$stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");
				
				// Execute Query

				$stmt->execute(array($itemid));
				
				// Fetch The Data

				$item = $stmt->fetch();
					
				// The Tow Count

				$count = $stmt->rowCount();

				// If There's Such ID Show The Form

				if ($count > 0){ ?>

						<h1 class="text-center">Edit Item</h1>
						<div class="container">
							<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="itemid" value="<?php echo  $itemid ?>" />
								<!-- Start Name Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Name</label>
									<div class="col-sm-10 col-md-4">
									<input type="text" name="name" class="form-control" required="required" placeholder="Name of The Item" value="<?php echo $item['Name'] ?>" />
									</div>
								</div>
								<!-- End Name Field -->
								<!-- Start Description Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Description</label>
									<div class="col-sm-10 col-md-4">
									<input type="text" name="description" class="form-control" required="required" placeholder="Description of The Item" value="<?php echo $item['Description'] ?>"/>
									</div>
								</div>
								<!-- End Description Field -->
								<!-- Start Price Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Price</label>
									<div class="col-sm-10 col-md-4">
									<input type="text" name="price" class="form-control" required="required" placeholder="Price of The Item" value="<?php echo $item['Price'] ?>"/>
									</div>
								</div>
								<!-- End Price Field -->
								<!-- Start Country Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Country</label>
									<div class="col-sm-10 col-md-4">
									<input type="text" name="country" class="form-control" required="required" placeholder="Country of The Item" value="<?php echo $item['Country_Made'] ?>"/>
									</div>
								</div>
								<!-- End Country Field -->
								<!-- Start Status Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Status</label>
									<div class="col-sm-10 col-md-4">
										<select name="status">
											<option value="1" <?php if($item['Status'] == 1) { echo 'selected';} ?>>New</option>
											<option value="2" <?php if($item['Status'] == 2) { echo 'selected';} ?>>Like New</option>
											<option value="3" <?php if($item['Status'] == 3) { echo 'selected';} ?>>Used</option>
											<option value="4" <?php if($item['Status'] == 4) { echo 'selected';} ?>>Very Old</option>
										</select>
									</div>
								</div>
								<!-- End Status Field -->
								<!-- Start Members Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Member</label>
									<div class="col-sm-10 col-md-4">
										<select name="member">
											<?php 
												$allmember = getAllFrom("*", "users", "", "", "userID");
												foreach ($allmember as $user) {
													
													echo "<option value='". $user['userID'] ."'"; 
													if($item['Member_ID'] == $user['userID']) { echo 'selected';} 
													echo ">" . $user['UserName'] . "</option>";
												}
											?>
										</select>
									</div>
								</div>
								<!-- End Members Field -->
								<!-- Start Categories Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Categorie</label>
									<div class="col-sm-10 col-md-4">
										<select name="categories">
											<?php 
												$allcats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
												foreach ($allcats as $cat) {	
													echo "<option value='". $cat['ID'] ."'"; 
													if($item['Cat_ID'] == $cat['ID']) { echo 'selected';}
													echo ">" . $cat['Name'] . "</option>";
													$allchilds = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
													foreach ($allchilds as $child) {
														echo "<option value='" . $child['ID'] . "'";
														if($item['Cat_ID'] == $child['ID']) { echo 'selected';}
														echo ">--- " . $child['Name'] . "</option>";
													}
												}
											?>
										</select>
									</div>
								</div>
								<!-- End Categories Field -->
								<!-- Start Avatar Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Item Avatar</label>
									<div class="col-sm-10 col-md-6">
										<input type="file" name="avatar" class="form-control"  />
									</div>
								</div>
								<!-- End Avatar Field -->
								<!-- Start Tel Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Phone Number</label>
									<div class="col-sm-10 col-md-6">
										<input 
											type="text" 
											name="tel" 
											class="form-control" 
											placeholder="For More Chance To By Your Item" 
											value="<?php echo $item['tel'] ?>" />
									</div>
								</div>
								<!-- End Tel Field -->
								<!-- Start Tags Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Tags</label>
									<div class="col-sm-10 col-md-6">
										<input 
											type="text" 
											name="tags" 
											class="form-control" 
											placeholder="Separate Tags With Comma (,)" 
											value="<?php echo $item['tags'] ?>" />
									</div>
								</div>
								<!-- End Tags Field -->
								<!-- Start submit Field -->
								<div class="form-group form-group-lg">
									<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
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


				
			} elseif ($do == 'Update') { // Update Page

					echo "<h1 class='text-center'>Update Item</h1>";
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

						$id 		= $_POST['itemid'];
						$name 		= $_POST['name'];
						$desc 		= $_POST['description'];
						$price 		= $_POST['price'];
						$country 	= $_POST['country'];
						$status 	= $_POST['status'];
						$tel 		= $_POST['tel'];
						$member 	= $_POST['member'];
						$cat 		= $_POST['categories'];
						$tags       = $_POST['tags'];
				
						// Validate The Form

						$formErrors = array();

						echo '</br>';
						
						if (empty($name)){

							$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
						}

						if (empty($desc)){

							$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';

						}

						if (empty($price)) {

							$formErrors[] = 'Price Can\'t be <strong>Empty</strong>';

						}

						if (empty($country)) {

							$formErrors[] = 'Country Can\'t be <strong>Empty</strong>';

						}

						if ($status == 0) {

							$formErrors[] = 'You Must Chose The <strong>Status</strong>';

						}

						if ($member == 0) {

							$formErrors[] = 'You Must Chose The <strong>Member</strong>';

						}

						if ($cat == 0) {

							$formErrors[] = 'You Must Chose The <strong>Categorie</strong>';

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

							move_uploaded_file($avatarTmp, "uploads\avatars\item\\" . $avatar);

							// Update The Database With This Info

							$stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?,Price = ?, Country_Made = ?, Status = ?, tel = ?, Cat_ID = ?, Member_ID = ? , avatar = ?, tags = ? WHERE item_ID = ?");
							$stmt->execute(array($name , $desc , $price, $country, $status, $tel, $cat, $member, $avatar, $tags, $id));

							// Echo Success Message

							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";

							redirectHome($theMsg, 'back');
						}

					} else {

						$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly </div>';

						redirectHome($theMsg);
					}

					echo "</div>";

				
			} elseif ($do == 'Delete') {

				echo "<h1 class='text-center'>Delete Item</h1>";
				echo "<div class='container'>";

					// Check If Get Request itemID Is Numeric & Get The Integer Value Of It

					$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
					
					// Select All Data Depend On This ID

					$check = checkItem("item_ID", "items", $itemid);
					
					// If There's Such ID Show The Form

					if ($check > 0){ 

						$stmt = $con->prepare("DELETE FROM items WHERE item_ID = :yitem");

						$stmt->bindParam(":yitem" , $itemid);

						$stmt->execute();

							// Echo Success Message

							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

							redirectHome($theMsg, 'back');

					} else {

						$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

						redirectHome($theMsg);
					}

				echo '</div>';
				
			} elseif ($do == 'Approve') {

				echo "<h1 class='text-center'>Approve Item</h1>";
				echo "<div class='container'>";

					// Check If Get Request itemID Is Numeric & Get The Integer Value Of It

					$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
					
					// Select All Data Depend On This ID

					$check = checkItem("item_ID", "items", $itemid);
					
					// If There's Such ID Show The Form

					if ($check > 0){ 

						$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ?");

						$stmt->execute(array($itemid));

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

		ob_end_flush(); // Release The Output

?>
			
			
