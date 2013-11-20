<?php
/*
@author: Vikesh Khanna
#quick #dirty
*/

function get_image($root, $suffix, $id)
{
	$image = $root.$id.".jpg";

	if(!file_exists($image))
	{
		$image = $suffix."default.jpg";
	}
	else	
	{
		$image = $suffix.$id.".jpg";
	}

	return $image;
}

// Get the current time from the DB
function get_time()
{
	$db = get_db_handle();
	$db->beginTransaction();
	$comm = "SELECT now from Time";
	$result = $db->prepare($comm);
	$result->execute();
	$result = $result->fetch();
	$db->commit();
	$db = null;
	return $result['now'];
}

// Get the image of the item from the ID
function get_item_image($itemid)
{
	$curdir = dirname(__FILE__);
	$suffix = "metadata/items/";
	$root = $curdir."/../".$suffix;
	return get_image($root, $suffix, $itemid);
}

// Get the image of a user from the ID
function get_user_image($userid)
{
	$curdir = dirname(__FILE__);
	$suffix = "metadata/users/";
	$root = $curdir."/../".$suffix;
	return get_image($root, $suffix, $userid);
}

// Get the item object from the itemid
function get_item($itemid)
{
	$db = get_db_handle();
	$db->beginTransaction();
	$comm = "SELECT * from item where  itemid=:itemid";
	$result = $db->prepare($comm);
	$result->execute(array(":itemid"=>$itemid));
	$result = $result->fetch();
	$db->commit();
	return $result;
}

// Get the category of an item
function get_categories($itemid)
{
	$db = get_db_handle();
	$db->beginTransaction();
	$comm = "SELECT * from itemcategory where  itemid=:itemid";
	$result = $db->prepare($comm);
	$result->execute(array(":itemid"=>$itemid));
	$result = $result->fetch();
	$db->commit();
	return $result;
}

function is_auction_open($item, $time)
{
	$started = $item['Started'];
	$ends = $item['Ends'];
	$buy_price = $item['Buy_Price'];
	$currently = $item['Currently'];

	return ($started < $time && $ends > $time && (!isset($buy_price) || $currently < $buy_price));
}

// Get the users who like an item
function get_likes($itemid)
{
	$db = get_db_handle();
	$db->beginTransaction();	

	# Get the number of likes
	$comLikes = "SELECT *  from likes where itemid=:itemid";
	$result = $db->prepare($comLikes);
	$result->execute(array(":itemid"=>$itemid));
	$result = $result->fetchAll();
	$db->commit();
	$db = null;
	return $result;
}


// Get the seller from the userid of the seller
function get_user($userid)
{
	$db = get_db_handle();
	$db->beginTransaction();
	$comm = "SELECT * FROM user WHERE userid=:userid";
	$result = $db->prepare($comm);
	$result->execute(array(":userid"=>$userid));
	$user = $result->fetch();
	$db->commit();
	$db=null;
	return $user;
}

function format_date($date)
{
	return date('d M Y H:i', strtotime($date));
}


// Gets the difference, date1 < date2
function date_interval($date1, $date2)
{
	return  date_diff(new DateTime($date1), new DateTime($date2));
}

// Gives the str equivalent of the date difference
function str_diff($diff)
{		
	$str_val = "";
	$years = $diff->y;
	$months = $diff->m;
	$days = $diff->d;
	$hours = $diff->h;
	$minutes = $diff->i;

	if($years>0)
	{
		return $years;
	}	
	else if($months>0)
	{
		return $months;
	}
	else if($days>0)
	{
		return $days." days, ".$hours." hours";		
	}
	else
	{
		return $hours." hours, ".$minutes." minutes";
	}
}

function perc_diff($time, $started, $ends)
{
	$sstarted = strtotime($started);
	$sends  = strtotime($ends);
	$stime = strtotime($time);

	$diff = (($stime - $sstarted)/($sends - $sstarted))*100;	
	return $diff;
}

function build_pins($items)
{
	$html = "";
	$db = get_db_handle();
	$db->beginTransaction();
	$time = get_time();

	foreach($items as $item)
				{
					$name = $item["Name"];
					$itemid = $item["ItemID"];
					$seller = $item["UserID"];
					$ends = $item["Ends"];
					$started = $item["Started"];
					$number_of_bids = $item['Number_of_Bids'];
					$currently = $item['Currently'];
					
					# Get the number of bids
					$pinStatus = is_auction_open($item, $time) ? "open" : "closed";
					$image = get_item_image($itemid);
					$countLikes = count(get_likes($itemid));

					$html = $html.'<div class="thumbnail pin">
						      <img src="'.$image.'" alt="..." />
							<div class="pin-status '.$pinStatus.' ">'.ucfirst($pinStatus).'</div>
							<div class="pin-container">
								<div class="pin-stats">
									<a href="item.php?itemid='.$itemid.'" class="name">'.$name.'</a>
									<ul>
										<li><i class="icon-heart" ></i> '.$countLikes.'</li>
										<li><span class="glyphicon glyphicon-bullhorn"></span> '.$number_of_bids.' bids</li>
									</ul>
								</div>
								<div class="bid-stats">
									<i class="icon-usd"></i> '.$currently.'
								</div>
					
							      <a class="pin-user" href=user.php?userid='.$seller.'>
								 <img src="metadata/users/'.$seller.'.jpg" />
								 <span>'.$seller.'</span>
							      </a>
							</div>
						</div>';
				}
		$db->commit();
		return $html;
}


function build_item_bid_pin($bid)
{
	$amount = $bid['Amount'];
	$date = $bid['Time'];
	$userid = $bid['UserID'];
	$itemid = $bid['ItemID'];
	$name = get_item($itemid);

	$item_image = get_item_image($itemid);
	$user_image = get_user_image($userid);

	$html = '<div class="thumbnail pin">
			<img src="'.$item_image.'" />
			<div class="pin-status"><i class="icon-dollar"></i> '.$amount.'</div>
			<div class="pin-container">
				<div class="pin-stats"><a href="item.php?itemid='.$itemid.'">'.$name.'</a></div>
				<div class="bid-stats mild">'.format_date($date).'</div>
				<a class="pin-user" href="user.php?userid='.$userid.'">
					 <img src="'.$user_image.'">
					 <span>'.$user.'</span>
			      </a>
			</div>
		</div>';

	return $html;
}

function build_user_bid_pin($bid)
{
	$amount = $bid['Amount'];
	$date = $bid['Time'];
	$userid = $bid['UserID'];
	$itemid = $bid['ItemID'];
	$name = get_item($itemid);

	$item_image = get_item_image($itemid);
	$user_image = get_user_image($userid);

	$html = '<div class="thumbnail pin">
			<img src="'.$user_image.'" />
			<div class="pin-status heavy"><i class="icon-dollar"></i> '.$amount.'</div>
			<div class="pin-container">
				<div class="pin-stats"><a href="user.php?userid='.$userid.'">'.$userid.'</a></div>
				<div class="bid-stats mild">'.format_date($date).'</div>
			      </a>
			</div>
		</div>';

	return $html;
}

function build_user_bid_pins($bids)
{
	$html = "";

	foreach($bids as $bid)
	{
		$html = $html.build_user_bid_pin($bid);
	}
	
	return $html;
}

?>
