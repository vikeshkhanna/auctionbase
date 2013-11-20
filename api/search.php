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
	$page = $_GET['page'];

	$page = !isset($page) ? 1 : $page;
	
	$length = 10;
	$low = ($page - 1)*$length;
		
	if(!isset($sort))
	{
		$sort = 'plh';	
	}
	
	$order = "";

	switch($sort)
	{
		case 'plh':
			$order = 'ORDER BY Currently';
			break;
		case 'phl':
			$order = 'ORDER BY Currently Desc';
			break;
		case 'pop':
			$order = 'ORDER BY Number_of_Bids Desc'; 
			break;
	}

	// 0 - closed, 1-open, 2-all
	$status = $_GET['status'];
	
	// Construct the query
	$comm = "SELECT * from item, itemcategory where item.itemid = itemcategory.itemid and (upper(name) like upper(:q1) or upper(category) like upper(:q2)) ".$order;

	$items = array();

	// Execute the query	
	$db = get_db_handle();
	$db->beginTransaction();
	
	$dbq = '%'.$q.'%';
	$result = $db->prepare($comm);
	
	$result->execute(array(':q1' => $dbq, ':q2' => $dbq));
	
	$rows = $result->fetchAll(PDO::FETCH_ASSOC);
	$categories = array();
	$time = get_time();

	foreach($rows as $row)
	{
		$price = $row['Currently'];
		$buy_price = $row['Buy_Price'];
		$category = $row['Category'];

		if(is_numeric($min_price) && $price < $min_price)
		{
			//echo "min_price_failed";
			continue;
		}

		if(is_numeric($max_price) && $price > $max_price)
		{
			//echo "max_price_failed";
			continue;
		}

		if(isset($buy_price))
		{
			if(is_numeric($min_buy_price) && $buy_price < $min_buy_price)
			{
				//echo "min_buy_price_failed";
				continue;
			}
	
			if(is_numeric($max_buy_price) && $buy_price > $max_buy_price)
			{
				//echo "max_buy_price_failed";
				continue;
			}
		}

		$auction_status = is_auction_open($row, $time);

		if(isset($status))
		{
			if(($status==0 && $auction_status) ||
				($status==1 && !$auction_status))
			{
				//echo "status_failed";
				continue;
			}	
		}

		if(isset($qcategory) && strcmp(strtoupper($category), strtoupper($qcategory)))
		{
			//echo "category_failed";
			continue;						
		}
		
		$row['open'] = $auction_status;
		$categories[$category]+=1;
		array_push($items, $row);
	}

	$items = array_slice($items, $low, $length);

	$response = array();
	$response['status'] = 200;
	$response['items' ] = $items;
	$response['categories'] = $categories;
	
	echo json_encode($response);
	$db->commit();
	$db = null;
?>
