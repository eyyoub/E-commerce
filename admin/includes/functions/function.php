<?php

/*
	** Get All Function v2.0
	** Function To Get All Records From Any Database Table
	*/

	function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;

	}
	


/*
** Title Function v1.0
** Title Function That The Page Title In Case The Page 
** Has The Variable $pageTitle And Echo Default Tiltes For Other Pages
*/

function getTitle() {

	global $pageTitle;

	if(isset($pageTitle)){

		echo $pageTitle;

	} else {

		echo 'Default';
		
	}

}

/*
** Home Redirect Function v2.0
** This Function Accept Parametres 
** $theMsg = Echo The Error Message [Error | Success | Warning ]
** $url = The Link You Want To Redirect To
** $seconds = Seconds Before Redirecting
*/

function redirectHome($theMsg, $url = null , $seconds = 3){

	if ($url === null) {

		$url = 'index.php';

		$link = 'HomePage';

	} else {

		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
			
			$url = $_SERVER['HTTP_REFERER'];

		    $link = 'Previous Page';

		} else {

			$url = 'index.php';

			$link = 'HomePage';
		}  

    }

	echo $theMsg;

	echo "<div class='alert alert-info'> You Will Be Redirected To $link After $seconds Secondes.</div>";

	header("refresh:$seconds;url=$url");

	exit();
}

/*
** Check Items Function v1.0
** Function To Check Item In Database [ This Function Accept Parametres ]
** $select = The Item To Select [ Example: user, item, category ]
** $from = The Table To Select From [ Example: users, items, categories]
** $value = The Value Of Select [Example: youssef, Box , Electronics ]
*/

function checkItem($select, $from, $value){

	global $con;

	$stmt1 = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

	$stmt1->execute(array($value));

	$count = $stmt1->rowCount();

	return $count;

}

/*
** Count Number Of Items Function v1.0
** Function To Count Number Of Items Rows
** $item = The Item To Count 
** $table = The Tbale To Choose From
*/

function countItems($item, $table) {

	global $con;

	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

	$stmt2->execute();

	return $stmt2->fetchColumn();

}

/*
** Get Latest Records Function v1.0
** Function To Get Latest Items From Database [ Users, Items, Comments ]
** $select = Field To Select
** $table = The Table To Chose From
** $order = The Desc Ordering
** $limit = Number Of Records To Get
*/

function getLatest($select, $table, $gid, $cdtn , $order, $limit = 5) {

	global $con;

	$getStmt = $con->prepare("SELECT $select FROM $table WHERE $gid = $cdtn ORDER BY $order DESC LIMIT $limit");

	$getStmt->execute();

	$rows = $getStmt->fetchAll();

	return $rows;

}
