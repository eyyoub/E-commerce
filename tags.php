<?php include'init.php'; ?>

<div class="container">
	<div class="row">
		<?php 
			if (isset($_GET['name'])){
				$tag = $_GET['name'];
				echo "<h1 class='text-center'>" . $tag . "</h1>";
				foreach (getAllFrom("*", "items", "where tags like '%$tag%'", "AND Approve = 1", "item_ID") as $item) {
					echo '<div class="col-sm-6 col-md-3">';
						echo '<div class="thumbnail item-box">';
							echo '<span class="price-tag">' . $item['Price'] . '</span>';
							if (empty($item['avatar'])) {
									echo "<img class='img-responsive' src='shopping.jpg' alt='pas d\'image' />";
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
			} else { header('Location: index.php');}

		?>
	</div>
</div>
		
<?php include $tpl . 'footer.php'; ?>