	<div class="row"> <!--time-->
			<!--Start date-->
			<div class="col-md-3 auto-col">
				<span class="date"><?php echo format_date($started); ?></span>
			</div>

			<div class="col-md-4"><!--Pointless progress bar-->
				<div class="progress">
				  <div class="progress-bar progress-bar-<?php echo $progress_status ?>" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress ?>%"> 
				    <span class="sr-only">40% Complete (success)</span>
				  </div>
				</div> 
			</div><!--Pointless progress bar-->

			<!--End date-->
			<div class="col-md-3 auto-col">
				<span class="date"><?php echo format_date($ends); ?></span>
			</div>

			<!--Time remaining-->
			<div class="col-md-3 auto-col">
				<span class="label label-warning status"><?php echo str_diff(date_interval($time, $ends)); ?> left</span>
			</div>
		</div><!--time row-->

		<div class="row stats-2" style="padding-top:15px;"><!--Dollaran-->
			<div class="col-md-4 auto-col" style="border-right:1px solid grey">
				<i class="icon-dollar"> <?php echo $currently ?></i><span> Current Bid</span>	
			</div>	

			<div class="col-md-4 auto-col">
				<i class="icon-heart"> <?php echo count($likers); ?> </i><span> Hearts</span>	
			</div>	

			<a class="col-md-4 auto-col" style="border-right:1px solid gray" href="#anchor-recent-bidders">
				<i class="icon-bullhorn"> <?php echo $number_of_bids ?></i><span> Bids</span>
			</a>

			<div class="col-md-4 auto-col">
				<button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#bidModal">Bid Now!</button>	
			</div>
		</div>

