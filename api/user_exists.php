<?php
	include("../include/sqlitedb.php");
	include("../include/utils.php");

	$userid = $_GET['userid'];
	$result  = get_user($userid);
	$response = array();
	
	if(empty($result))
	{
		$response['status'] = 404;
		$response['message'] = 'User \''.$userid.'\' does not exist.';
	}
	else
	{
		$response['status'] = 200;
	}
	
	echo json_encode($response);
?>
