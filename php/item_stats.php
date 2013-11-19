<!--Stats start-->
<div class="row">
		<div class="col-md-3 auto-col">
			<div class="prod-image">
				<img class="image" src="<?php echo $item_image ?>" />
				<span class="auction-status <?php echo $status ?>"><?php echo ucfirst($status); ?></span>
			</div>
		</div><!--Image-->

		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12 item-name-container"><!--heading column-->
					<h1><?php echo $name; ?></h1>
					<span>ItemID: <?php echo $itemid ?></span>
					<hr />
				</div><!--heading-->
			</div>

			<?php 
				if($is_auction_open)
				{
					include("php/item_stats_open.php");
				}	
				else
				{
					include("php/item_stats_closed.php");
				}
			?>
		</div><!--stats-->
</div><!--row, big table, stats end -->
