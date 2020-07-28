<?php 
	ob_start();
	session_start();

	include'init.php'; 

	?>

<div class="container">
	<h1 class="text-center"><?php echo str_replace('-',' ',$_GET['pagename'])?></h1>
	<div class="row">
		<?php 
			if (isset($_GET['pageid']) && isset($_GET['pagename'])){
				$category = intval($_GET['pageid']);
				foreach (getAllFrom("*", "items", "where Cat_ID = {$category}", "AND Approve = 1", "item_ID") as $item) {
					echo '<div class="col-sm-6 col-md-3">';
						echo '<div class="thumbnail item-box">';
							echo '<span class="price-tag">' . $item['Price'] . '</span>';

							if(!empty($item['avatar'])) { 

								echo "<img <img class='img-responsive' src='admin/uploads/avatars/item/" . $item['avatar']  . "' alt='' />";
								
					 	  	} else { 
							
								echo "<img <img class='img-responsive' src='shopping.jpg' alt='' />";
					
						 	}
						 	
							echo '<div class="caption">';
								echo '<h3><a href="items.php?itemid='. $item['item_ID'] .'">' . $item['Name'] . '</a></h3>';
								echo '<p>' . $item['Description'] . '</p>';
								echo '<div class="date">' . $item['Add_Date'] . '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			} else { header('Location: index.php');}

		?>
	</div>
</div>
		
<?php include $tpl . 'footer.php';
		
	  ob_end_flush();	 ?>