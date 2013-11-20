<?php
	include('../include/sqlitedb.php');
	include('../include/utils.php');
	
	$itemid = $_GET['itemid']; 
	$userid = $_GET['userid'];
	$amount = $_GET['amount'];
	$time = get_time();

	$user = get_user($userid);
	$item = get_item($itemid);

	$response = array();
	$amount = round($amount, 2);

	// Do prelimiary checks here itself although they are implemented in the DB layer as well (in the form of constraints and triggers)
	if(empty($user))
	{
		$response['status'] = 400;
		$response['message'] = 'User \''.$userid.'\' does not exist';
	}
	else if(empty($item))
	{
		$response['status'] = 400;
		$resonse['message'] = 'Item with ID '.$itemid.' does not exist';
	}	
	else
	{	
		$db = get_db_handle();
		$db->beginTransaction();
		$comm = "insert into bid values(:userid, :itemid, :time, :amount)";

		try {
			$result = $db->prepare($comm);
			$result->execute(array(":userid"=> $userid, ":itemid"=>$itemid, ":time"=>$time, ":amount"=>$amount));
			$db->commit();
			$response['status'] = 200;		
		} 
		catch (PDOException $e) {
			$response['status'] = 400;
			$response['message'] = $e->getMessage();
		}
	}

	echo json_encode($response);
?>
