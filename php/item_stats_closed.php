<?php
	/* Find the winner of the auction and how the auction ended */
	$db = get_db_handle();
	$db->beginTransaction();

	$commWinner = "SELECT * from bid where itemid=:itemid order by amount desc limit 1";
	$result = $db->prepare($commWinner);
	$result->execute(array(":itemid"=>$itemid));
	$result = $result->fetch();
	$db->commit();
	$db=null;

	if(!empty($result))
	{
		$amount = $result['Amount'];
		$reached_buy_price = (isset($buy_price) && $amount == $buy_price);
		$winner = $result['UserID'];
		$winner_image = get_user_image($winner);
	}
?>

<div class="row"> <!--winner (takes all) -->
			<?php
				if(!empty($result))
				{
					echo '<div class="col-md-4 auto-col">
						<img src="'.$winner_image.'" height="100px" />
					      </div>';
				}
			 ?>
		<div class="col-md-12 winner" >
			<?php
				if(empty($result))
				{
					echo '<h1 style="margin-bottom:10px;">No winner</h1>
						<div class="label label-danger status">'.format_date($started).'</div> to <div class="label label-danger status">'.format_date($ends).'</div>';
				}
				else
				{
							echo '<h1><a href="user.php?userid='.$winner.'">'.$winner.'</a></h1> <br />
							<div class="stats-2">
							<i class="icon-dollar">'.$amount.'</i>
							<span>Win amount</span>';
					
							if(isset($buy_price))
							{
								echo ' / <i class="icon-dollar">'.$buy_price.'</i>
								      <span>Buy Price</span>';
							}
	
							echo ' <div class="label label-danger status">'.format_date($started).'</div><span> to </span><div class="label label-danger status">'.format_date($ends).'</div></div>';
					}
				?>
		</div><!--End col-->
</div><!--winner-->
