<?php
	ob_start();
	session_start();

	$pageTitle = 'Homepage';

	include'init.php'; 

?>


<div class="container">
	<div class="row home">
		<?php 
				foreach (getAllFrom('*', 'items', 'where Approve = 1', '', 'item_ID') as $item) {
					echo '<div class="col-sm-6 col-md-3">';
						echo '<div class="thumbnail item-box">';
							echo '<span class="price-tag">' . $item['Price'] . '</span>';
							echo "<td>";
								if (empty($item['avatar'])) {
									echo "<img src='shopping.jpg' alt='pas d\'image' />";
								} else {
									echo "<img src='admin/uploads/avatars/item/" . $item['avatar'] . "' alt='Wrong SRC' />";
								}
							echo "</td>";							
							echo '<div class="caption">';
							echo '<h3><a href="items.php?itemid='. $item['item_ID'] .'">' . $item['Name'] . '</a></h3>';
							echo '<p>' . $item['Description'] . '</p>';
							echo '<div class="date">' . $item['Add_Date'] . '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
		?>
	</div>
</div>

<?php

	include $tpl . 'footer.php'; 
	ob_end_flush();
?>