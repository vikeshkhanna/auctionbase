<?php
	include("../include/sqlitedb.php");

	$MM = $_GET["MM"];
	$dd = $_GET["dd"];
	$yyyy = $_GET["yyyy"];
	$HH = $_GET["HH"];
	$mm = $_GET["mm"];
	$ss = $_GET["ss"];    

	if(checkdate($MM, $dd, $yyyy))
	{
		if($HH>=0 && $HH<24 && $mm>=0 && $mm<60 && $ss>=0 && $ss<60)
		{
			$date = $yyyy.'-'.$MM.'-'.$dd.' '.$HH.':'.$mm.':'.$ss;
	
			if(strtotime($date))
			{
				try
				{
					$db = get_db_handle();
					$db->beginTransaction();

					$comm = "UPDATE time set now=:date";
					$db->prepare($comm);
					$result = $db->prepare($comm);
					$result->execute(array(":date"=>$date));
					$db->commit();
					$db = null;

					$response['status'] = 200;
				}
				catch(PDOException $e)
				{
					$response['status'] = 500;
					$response['message'] = $e->getMessage();
				}
			}
		}
	}
	else
	{
		$response['status'] = 400;
		$response['message'] = 'Invalid year, month or day.';
	}

	echo json_encode($response);
?>

