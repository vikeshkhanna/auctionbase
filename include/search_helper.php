<?php

function get_query()
{
	$page = !isset($page) ? 1 : $page;
	
	$length = 10;
	$low = ($page - 1)*$length;
	$high = $low+$length - 1;
		
	if(!isset($sort))
	{
		$sort = 'plh';	
	}
	
	$order = "";

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
	}

	// 0 - closed, 1-open, 2-all
	$status = $_GET['status'];
	$status = empty($status) ? 2: $status;

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

	$db = get_db_handle();
	$db->beginTransaction();
	$result = null;
	$dbq = '%'.$q.'%';
	$dbcat = '%'.$qcategory.'%';

	$replace = array();
	$conditions = array();

	//$replace[':low'] = $low;
	//$replace[':high'] = $high;

	if(!empty($q))
	{
		array_push($conditions, "(upper(name) like :q1 or upper(category) like :q2)");
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
		array_push($conditions, 'category like :dbcat');
		$replace[':dbcat'] = $dbcat;	
	}
	
	$where = implode(' AND ', $conditions);

	$query = "SELECT * from item, itemcategory WHERE item.itemid = itemcategory.itemid and ".$where." ORDER BY ".$order." LIMIT :low, :high";
	e

}

?>
