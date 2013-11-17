<?php

function build_pin($items, $db)
{
	$html = "";

	foreach($items as $item)
				{
					$name = $item["Name"];
					$itemid = $item["ItemID"];
					$seller = $item["UserID"];
					$ends = $item["Ends"];

					# Get the number of likes
					$comLikes = "SELECT count(*) num_likes from likes where itemid=:itemid";
					$result = $db->prepare($comLikes);
					$result->execute(array(":itemid"=>$itemid));
					$result = $result->fetch();
					$countLikes = $result["num_likes"];

					# Get the number of bids
					$comBids = "SELECT number_of_bids from item where itemid=:itemid";
					$result = $db->prepare($comBids);
					$result->execute(array(":itemid"=>$itemid));
					$result = $result->fetch();
					$countBids = $result["Number_of_Bids"];

					$comCurrently = "SELECT Currently from item where itemid=:itemid";
					$result = $db->prepare($comCurrently);
					$result->execute(array(":itemid"=>$itemid));
					$result = $result->fetch();
					$currently = $result["Currently"];
					
					$comNow = "SELECT now from time";
					$result = $db->prepare($comNow);
					$result->execute();
					$result = $result->fetch();
					$now = $result["now"];

					$status = $ends > $now;
					$pinStatus = ($status == 1 ? "open" : "closed");

					$curdir = dirname(__FILE__);
					$suffix = "metadata/items/";
					$root = $curdir."../".$suffix;
					$image = $root.$itemid.".jpg";
					
					if(!file_exists($image))
					{
						$image = $suffix."default.jpg";
					}
					else	
					{
						$image = $suffix.$itemid.".jpg";
					}
		
					$html = $html.'<div class="thumbnail pin">
						      <img src="'.$image.'" alt="..." />
							<div class="pin-status '.$pinStatus.' ">'.ucfirst($pinStatus).'</div>
							<div class="pin-container">
								<div class="pin-stats">
									<a href="#" class="name">'.$name.'</a>
									<ul>
										<li><i class="icon-heart" ></i> '.$countLikes.'</li>
										<li><span class="glyphicon glyphicon-bullhorn"></span> '.$countBids.' bids</li>
									</ul>
								</div>
								<div class="bid-stats">
									<i class="icon-usd"></i> '.$currently.'
								</div>
					
							      <a class="pin-user">
								 <img src="metadata/users/'.$seller.'.jpg" />
								 <span>'.$seller.'</span>
							      </a>
							</div>
						</div>';
				}

		return $html;
}

?>
