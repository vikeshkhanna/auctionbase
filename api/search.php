<?php
	include("../include/sqlitedb.php");
	include("../include/utils.php");

	$q = $_GET['q'];
	$min_price = $_GET['min_price'];
	$max_price = $_GET['max_price'];

	$qcategory = $_GET['category'];

	$min_buy_price = $_GET['min_buy_price'];
	$max_buy_price = $_GET['max_buy_price'];
	$sort = $_GET['sort'];
	$sort = !isset($sort) ? 'plh' : $sort;	

	$page = $_GET['page'];
	$page = !isset($page) ? 1 : $page;

	$mode = $_GET['mode'];
	$mode = !isset($mode) ? 'lim' : $mode;

	$hardcat = $_GET['hardcat'];
	$hardcat = !isset($hardcat) ? 0 : $hardcat;
	
	$length = 10;
	$low = ($page - 1)*$length;
	$high = $low+$length;
		
	$order = "";

	$response = Array();

	switch($sort)
	{
		case 'plh':
			$order = 'Currently';
			break;
		case 'phl':
			$order = 'Currently Desc';
			break;
		case 'pop':
			$order = 'Number_of_Bids Desc'; 
			break;
		default:
			$response['status'] = 400;
			$response['message'] = 'Invalid sort. Supported values are plh, phl and pop.';
			echo json_encode($response);
			exit;
	}


	// 0 - closed, 1-open, 2-all
	$status = $_GET['status'];
	$status = !isset($status) ? 2: $status;

	// Basic validation
	if(!is_numeric($status) || ($status!=0 && $status!=1 && $status!=2))
	{
		$response['status'] = 400;
		$response['message'] = 'Invalid status. Supported values are 0, 1 and 2.';
		echo json_encode($response);
		exit;
	}

	if(empty($q) and empty($qcategory))
	{
		$response['status'] = 400;
		$response['message'] = 'Must supply query or category';
		echo json_encode($response);
		exit;
	}

	if($mode!='cat' && $mode!='lim')
	{
		$response['status'] = 400;
		$response['message'] = 'Invalid mode. Supported values are cat and lim';
		echo json_encode($response);
		exit;
	}

	$dbq = '%'.$q.'%';
	$dbcat = "%".$qcategory."%";

	$replace = array();
	$conditions = array();


	if(!empty($q))
	{
		array_push($conditions, "(upper(name) like upper(:q1) or upper(category) like upper(:q2))");
		$replace[':q1'] = $dbq;
		$replace[':q2'] = $dbq;
	}

	// Construct the query
	if(is_numeric($min_price))
	{
		array_push($conditions, "Currently > :min_price");
		$replace[':min_price'] = $min_price;
	}

	if(is_numeric($max_price))
	{
		array_push($conditions, "Currently < :max_price");
		$replace[':max_price'] = $max_price;
	}

	if(is_numeric($min_buy_price))
	{
		array_push($conditions, "Buy_Price > :min_buy_price");
		$replace[':min_buy_price'] = $min_buy_price;
	}

	if(is_numeric($max_buy_price))
	{
		array_push($conditions, "Buy_Price > :max_buy_price");
		$replace[':max_buy_price'] = $max_buy_price;
	}

	$clause = '';
	
	switch($status)
	{
		case 0:
			$clause = 'julianday(Ends) < (select julianday(now) from time)';
			break;

		case 1:
			$clause = 'julianday(Started) < (select julianday(now) from time) AND julianday(Ends) > (select julianday(now) from time)';
			break;
	}

	if(!empty($clause))
	{
		array_push($conditions, $clause);
	}

	if(isset($qcategory) && !empty($qcategory))
	{
		$op = 'like';
		$replace[':dbcat'] = $dbcat;	

		if($hardcat == 1)
		{
			$op = '=';
			$replace[':dbcat'] = $qcategory;
		}

		array_push($conditions, "upper(category) ".$op." upper(:dbcat)");
	}
	
	$where = implode(' AND ', $conditions);

	// Add limit, returns a random category
	if($mode=='lim')
	{
		$query = "SELECT * from item, itemcategory WHERE item.itemid = itemcategory.itemid and ".$where." GROUP BY itemid ORDER BY ".$order." LIMIT :low, :high";
		$replace[':low'] = $low;
		$replace[':high'] = $high;
	}
	else
	{
		$query = "SELECT * from item, itemcategory WHERE item.itemid = itemcategory.itemid and ".$where." ORDER BY ".$order;
	}

	echo $query;
	//print_r($replace);
	try
	{
		$db = get_db_handle();
		$db->beginTransaction();
		$db->prepare($query);
		$result = $db->prepare($query);
		$result->execute($replace);
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		$time = get_time();

		$items = array();
		$categories = array();

		// If mode is not cat, the categories array gives the count of only the paginated items
		foreach($rows as $row)
		{
			$auction_status = is_auction_open($row, $time);
			$category = $row['Category'];
			$row['open'] = $auction_status;	
			$row['img'] = get_item_image($row['ItemID']);
				
			$seller_id = $row['UserID'];
			$row['seller'] = array('userid'=> $seller_id, 'img' => get_user_image($seller_id));
			$categories[$category]+=1;
			array_push($items, $row);
		}
		
		// Only required if mode is cat
		if($mode=='cat')
		{
			$items = array_slice($items, $low, $length);
		}

		arsort($categories);
		
		$response['status'] = 200;
		$response['items' ] = $items;
		$response['categories'] = $categories;
	}
	catch(Exception $e)
	{
		$response['status'] = 500;
		$response['message'] = $e->getMessage();
	}

	$db->commit();
	$db = null;

	echo json_encode($response);
?>
