<?php include(dirname(__FILE__)."/include/sqlitedb.php"); ?>
<?php include(dirname(__FILE__)."/include/utils.php"); ?>

<?php
			$itemid = $_GET['itemid'];
			$item = get_item($itemid);
	
			if(!empty($item))
			{
				// Item variables
				$name = $item['Name'];
				$description = $item['Description'];
				$seller_id = $item['UserID'];
				$seller = get_user($seller_id);
				$seller_rating = $seller['Rating'];
				$number_of_bids = $item['Number_of_Bids'];
				$currently = $item['Currently'];
				$started = $item['Started'];
				$ends = $item['Ends'];
				$item_image = get_item_image($itemid);
				$seller_image = get_user_image($seller_id);
				$time = get_time();
				$is_auction_open = is_auction_open($item, $time);
	 			$status = $is_auction_open ? "open" : "closed";	
				$currently = $item['Currently'];
				$number_of_bids = $item['Number_of_Bids'];
				$likers = get_likes($itemid);
				$buy_price = $item['Buy_Price'];

				// Progress bar variables
				$progress = perc_diff($time, $started, $ends); 
				$progress_status = $progress>75 ? "danger" : "success";

				// Slider variables
				$slider_min = $currently + 0.1;
				$slider_max = isset($buy_price) ? $buy_price : $slider_min + 50;
			}
?>


<html>
	<head>
		<title><?php echo $name ?></title>
		
		 <!-- Bootstrap core CSS -->
		 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 	 <link href="assets/css/main.css" rel="stylesheet">
	 	 <link href="assets/css/item.css" rel="stylesheet">
		 <link href="assets/css/bootstrap-custom.css" rel="stylesheet">
		 <link href="assets/css/carousel.css" rel="stylesheet">
		 <link href="assets/slider/css/slider.css" rel="stylesheet">
		 <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/masonry/masonry.pkgd.min.js"></script>
		<script src="assets/slider/js/bootstrap-slider.js"></script>

		<script>
			
			var slider_min = <?php echo (!isset($slider_min) ? 0 : $slider_min); ?>;
			var slider_max =  <?php echo (!isset($slider_max) ? 0 : $slider_max); ?>; 
			var currently = <?php echo (!isset($currently) ? 0 : $currently); ?>;
			var buy_price = <?php echo (isset($buy_price) ? $buy_price : -1); ?>;
			var itemid = <?php echo (!isset($itemid) ? 0 : $itemid);  ?>;

			function get_amount_error()
			{
				var msg = "You must bid at least $" + slider_min;

				if(buy_price > -1)
				{
					msg +=  " and no more than $" + buy_price;
				}

				return msg;
			}
	
			function set_amount_state()
			{
				var val = $("#bid-amount").val();
				var amount_group = $("#amount-group");
				var help_elem = $("#help-bid-amount");
				var bid_button = $("#bid-button");

				if(val<=currently || (buy_price > -1 && val > buy_price))
				{
					amount_group.removeClass("has-success");
					amount_group.addClass("has-error");
					help_elem.html(get_amount_error());
					bid_button.prop('disabled', true);
				}
				else
				{
					amount_group.removeClass("has-error");
					amount_group.addClass("has-success");
					bid_button.prop('disabled', false);
					help_elem.html("");
				}
			}

			function user_status(userid, callback)
			{
				$.ajax({
					url:"api/user_exists.php?userid="+userid,
					type: 'GET',
					dataType: 'json',
					
					success: function(data){
						callback(data);
					}
				});			
			}

			function bid()
			{
				$("#preloader").show();		
				$("#error-box").hide();

				var userid = $("#bid-userid").val();
				var amount = $("#bid-amount").val();

				user_status(userid, function(response){
					if(response['status'] == 200)
					{
						// Ajax call bid
						$.ajax({
							url:"api/do_bid.php",
							data: {'userid':userid, 'itemid':itemid, 'amount':amount},
							type: 'GET',
							dataType: 'json',
							
							success: function(response){
								if(response['status']==200)
								{
									// Hide everything and show success
									$("#preloader").hide();
									$("#success-box").show();
									$("#bid-form").hide();
								}
								else
								{
									$("#error-box").html(response['message']);
									$("#error-box").show();
									$("#preloader").hide();
								}
							},
		
							fail : function(){
								$("#error-box").html("Server error. Try again later");
								$("#error-box").show();
								$("#preloader").hide();
							}
						});		
					}
					else
					{
						$("#userid-group").addClass("has-error");	
						$("#help-bid-userid").html(response['message']);
						$("#preloader").hide();
					}
				});
			}
		
			$(document).ready(function(){
				$("#bidders-also-bid").masonry({
					columnWidth:180,
					itemSelector:".pin"
				});	

				$("#other-items").masonry({
					columnWidth:180,
					itemSelector:".pin"
				});	


				$("#recent-bidders").masonry({
					columnWidth:180,
					itemSelector:".pin"
				});	
	
				var slider = $(".slider").slider({
					min:slider_min,
					max:slider_max,
					step:1,
					tooltip:'hide'
				})

				slider.slider().on('slide', function(ev) { 
					$("#bid-amount").val(ev.value);
					set_amount_state();
				});

				// Form validation
				// Amount
				$("#bid-amount").change(function(){
					});

				$("#bid-amount").keyup(function() {
					slider.slider('setValue', $(this).val());
					set_amount_state();	
				});

				// userid
				$("#bid-userid").focus(function(){
					$("#userid-group").removeClass("has-error");
					$("#help-bid-userid").html("");
				});
			});

		</script>

		<style>
		</style>
	</head>

	<body>

	<!--Header-->
	<?php include(dirname(__FILE__)."/include/header.php"); ?>
	
	<div class="container skip-header">	
		<!--If itemid is wrong-->
		<?php
			if(!empty($item))
			{
						include("php/item_stats.php");
			}	
			else
			{
				echo '<div class="bs bs-callout bs-callout-danger">
					<div class="alert alert-danger">This item does not exist.</div>
				      </div>';
			}
		?>
		
		<!--Desc and seller-->
		<div class="row" style="margin-top:60px;">
			<div class="col-md-8"><!--desc col-->
				<div class="megatron">
					<h1 class="extra-bold">Description</h1>		
					<div class="content">
					<p><?php echo $description ?></p>
					</div>
				</div>

				<div class="category-container" style="margin-top:10px;">
					<h4>Categories</h4> <br />
						<?php
							$categories = get_categories($itemid);
							
							foreach($categories as $category)
							{	
								$cat = $category['Category'];
								echo "<a href='search.php?q=".urlencode($cat)."'>".$cat."</a>";
							}
						?>

				</div>
			</div><!--desc column end-->
			
			<div class="col-md-3"><!--seller-->
				<div class="megatron seller">
					<h1 class="extra-bold">Seller</h1>
					<div class="content">
						<img src="<?php echo $seller_image ?>" />
						<div class="inner">
							<a href='user.php?userid=<?php echo $seller_id ?>'><?php echo $seller_id ?></a>
							<p class="stats-2"><?php echo $seller_rating ?><span> Rating</span></p>
						</div>
					</div>
				</div>
			</div><!--seller col-->
			<a id="anchor-recent-bidders" style="visibility:hidden"></a>
		</div><!--desc and seller-->

		<!--Recent Bidders-->
		<div class="row heading-hr heading-hr">
			<div class="col-md-1">
				<hr />
			</div>

			<div class="col-md-3 auto-col">
				<h1>Recent bidders</h1>	
			</div>
		
			<div class="col-md-12">
				<hr />
			</div>
		</div>

		<div class="row">
			<div class="col-md-12" id="recent-bidders">
				<?php 
					$db = get_db_handle();
					$db->beginTransaction();

					$comm = "SELECT * from bid where itemid=:itemid order by julianday(Time) desc";

					$result = $db->prepare($comm);
					$result->execute(array(":itemid"=>$itemid));
					$bids = $result->fetchAll();
					echo build_user_bid_pins($bids);
					$db->commit();
					$db = null;
				?>	
			</div>
		</div>
		<!--End recent Bidders-->

		<!--Bidders also bid on-->
		<div class="row heading-hr heading-hr-mild">
			<div class="col-md-1">
				<hr />
			</div>

			<div class="col-md-3 auto-col">
				<h1 class="extra-bold">Bidders also bid on</h1>	
			</div>
		
			<div class="col-md-12">
				<hr />
			</div>
		</div>

		<div id="bidders-also-bid">
			<?php 
				$db = get_db_handle();
				$db->beginTransaction();

				$comm_similar = "select * from item where itemid in (select itemid from itemcategory where category = (select category from itemcategory where itemid=:itemid)) and ends > (select now from time) order by random() limit 6";

				$result = $db->prepare($comm_similar);
				$result->execute(array(":itemid"=>$itemid));
				$items = $result->fetchAll();
				echo build_pins($items);
				$db->commit();
				$db = null;
			?>
		</div>


		<div class="row heading-hr heading-hr-mild">
			<div class="col-md-1">
				<hr />
			</div>

			<div class="col-md-3 auto-col">
				<h1 class="extra-bold">Other items from seller</h1>	
			</div>
		
			<div class="col-md-12">
				<hr />
			</div>
		</div>

		<div id="other-items">
			<?php 
				$db = get_db_handle();
				$db->beginTransaction();
				$com1 = "SELECT * from item where userid=:seller_id limit 6;";
				$result = $db->prepare($com1);
				$result->execute(array(":seller_id"=>$seller_id));
				$items = $result->fetchAll();
				echo build_pins($items, $db);
				$db->commit();
				$db=null;
			?>
		</div>

		<!--Bid modal-->
		<div class="modal fade" id="bidModal" tabindex="-1" role="dialog" aria-labelledby="bidModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="bidModalLabel">Bid Now!</h4>
		      </div>
		      <div class="modal-body">
				<form class="form-horizontal" role="form" id="bid-form">
					<div class="form-group">
						<label for="userid" class="col-sm-2 control-label">Item ID</label>	
							<div class="col-sm-10">
								<p class="form-control-static"><?php echo $itemid; ?></p>
							</div>
					</div>

					<div class="form-group" id="userid-group">
						<label for="userid" class="col-sm-2 control-label">User ID</label>	
						<div class="col-sm-10">
							<input type="text" class="form-control" id="bid-userid" placeholder="Enter UserID" />
							<p class="help-block" id="help-bid-userid"></p>
						</div>
					</div>

					<div class="form-group" id="amount-group"><!--Amount group begins-->
						<label for="userid" class="col-sm-2 control-label">Amount</label>	
						<div class="col-sm-10">
							<div class="row"><!--slider row-->
								<div class="col-sm-7">
									<div class="form-control-plain">
										<b><?php echo $slider_min ?></b><div class="slider slider-horizontal" style="width:160px;" id="amount-slider"></div><b><?php echo $slider_max ?></b>									</div>
								</div>
				
								<div class="col-sm-4">
									<input type="number" class="form-control" id="bid-amount" placeholder="Amount" value=<?php echo $slider_min ?> />
								</div>
							</div><!--slider row ends-->
	
							<div class="row"> <!--help text row-->
								<div class="col-md-12">
									<p class="help-block">
											<?php 
												if(!isset($buy_price))
												{
													echo 'No buy price. Bid any value above <i class="icon-dollar">'.$currently.'</i>';
												}
												else
												{
													echo 'Win this auction by bidding <i class="icon-dollar">'.$buy_price.'</i>';
												}
											?>
										</p>
										<p class="help-block" id="help-bid-amount"></p>
								</div>
							</div><!--help text row ends-->
						</div>
					</div><!--Amount-group ends-->
				</form>
				<div class="alert alert-danger" style="display:none;" id="error-box"> Error!</div>
				<div class="alert alert-success" style="display:none;" id="success-box"> Thank you! Your bid has been recorded! Please <a href="item.php?itemid=<?php echo $itemid ?>"> refresh </a> the page to find yourself in the recent bidders. </div>
		      </div>
		      <div class="modal-footer">
			<img src="assets/img/preloader.gif" id="preloader" style="display:none;" />	
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-success" id="bid-button" onclick="bid();">Bid!</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		</div>
		
	<?php include("include/footer.php"); ?>
	</body>
</html>


