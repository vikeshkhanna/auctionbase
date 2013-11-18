<?php include(dirname(__FILE__)."/include/sqlitedb.php"); ?>
<?php include(dirname(__FILE__)."/include/utils.php"); ?>

<html>
	<head>
		<title>Tea set!</title>
		
		 <!-- Bootstrap core CSS -->
		 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 	 <link href="assets/css/main.css" rel="stylesheet">
	 	 <link href="assets/css/item.css" rel="stylesheet">
		 <link href="assets/css/bootstrap-custom.css" rel="stylesheet">
		 <link href="assets/css/carousel.css" rel="stylesheet">
		 <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/masonry/masonry.pkgd.min.js"></script>

		<script>

			$(document).ready(function(){
			
			})

		</script>

		<style>
		</style>
	</head>

	<body>

	<!--Header-->
	<?php include(dirname(__FILE__)."/include/header.php"); ?>
	
	<?php
		$itemid = $_GET['itemid'];	
	?>

	<div class="container skip-header">	
		<div class="row">
			<div class="col-md-3 auto-col">
				<img class="image" src="metadata/items/default.jpg" />
			</div><!--Image-->

			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12"><!--heading column-->
						<h1 class="helvetica">Fur catball, hello kitty, little ball of fur (vintage)</h1>
						<hr />
					</div><!--heading-->
				</div>

				<div class="row"> <!--time-->
					<div class="col-md-6"><!--Pointless progress bar-->
						<div class="progress">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
						    <span class="sr-only">40% Complete (success)</span>
						  </div>
						</div> 
					</div><!--Pointless progress bar-->

					<!--Open/Closed-->
					<div class="col-md-1">
						<span class="label label-success status">Open</span>
					</div>

					<!--Time remaining-->
					<div class="col-md-3 auto-col">
						<span class="label label-warning status">1 hr 20 minutes left</span>
					</div>

					<!--End date-->
					<div class="col-md-2">
						<span><strong>12th Oct 2013</strong></span>
					</div>
				</div><!--time row-->

				<div class="row stats-2"><!--Dollaran-->
					<div class="col-md-4 auto-col" style="border-right:1px solid grey">
						<i class="icon-dollar"> 244</i><span> Current Bid</span>	
					</div>	

					<div class="col-md-4 auto-col">
						<i class="icon-heart">  4</i><span> Hearts</span>	
					</div>	

					<div class="col-md-4 auto-col" style="border-right:1px solid gray">
						<i class="icon-bullhorn">  4</i><span> Bids</span>
					</div>

					<div class="col-md-4 auto-col">
						<button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#bidModal">Bid Now!</button>	
					</div>
				</div>
			</div><!--stats-->
		</div><!--row, big table-->

		<div class="row" style="margin-top:60px;">
			<div class="col-md-8"><!--desc col-->
				<div class="megatron">
					<h1 class="extra-bold">Description</h1>		
					<div class="content">
					<p> brand new beautiful handmade european blown glass ornament from christopher radko. this particular ornament features a snowman paired with a little girl bundled up in here pale blue coat sledding along on a silver and blue sled filled with packages. the ornament is approximately 5_ tall and 4_ wide. brand new and never displayed, it is in its clear plastic packaging and comes in the signature black radko gift box. PLEASE READ CAREFULLY!!!! payment by cashier's check, money order, or personal check. personal checks must clear before shipping. the hold period will be a minimum of 14 days. I ship with UPS and the buyer is responsible for shipping charges. the shipping rate is dependent on both the weight of the package and the distance that package will travel. the minimum shipping/handling charge is $6 and will increase with distance and weight. shipment will occur within 2 to 5 days after the deposit of funds. a $2 surcharge will apply for all USPS shipments if you cannot have or do not want ups service. If you are in need of rush shipping, please let me know and I_will furnish quotes on availability. the BUY-IT-NOW price includes free domestic shipping (international winners and residents of alaska and hawaii receive a credit of like value applied towards their total) and, as an added convenience, you can pay with paypal if you utilize the feature. paypal is not accepted if you win the auction during the course of the regular bidding-I only accept paypal if the buy it now feature is utilized. thank you for your understanding and good luck! Free Honesty Counters powered by Andale! Payment Details See item description and Payment Instructions, or contact seller for more information. Payment Instructions See item description or contact seller for more informationv</p>
					</div>
				</div>
			</div><!--desc column end-->
			
			<div class="col-md-4">
				<div class="megatron seller">
					<h1 class="extra-bold">Seller</h1>
					<div class="content">
						<img src="assets/img/zepp.jpg" />
					</div>
				</div>
			</div>
		</div>
	
		<!--Bid modal-->
		<div class="modal fade" id="bidModal" tabindex="-1" role="dialog" aria-labelledby="bidModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Bid</h4>
		      </div>
		      <div class="modal-body">
			...
		      </div>
		      <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-success">Bid!</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		</div>
		
	<?php include("include/footer.php"); ?>
	</body>
</html>


