<?php include(dirname(__FILE__)."/include/sqlitedb.php"); ?>
<?php include(dirname(__FILE__)."/include/utils.php"); ?>

<?php
			$userid = $_GET['userid'];
			$user = get_user($userid);
			$user_image = get_user_image($userid);
?>


<html>
	<head>
		<title><?php echo $userid ?>'s Profile</title>
		
		 <!-- Bootstrap core CSS -->
		 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 	 <link href="assets/css/main.css" rel="stylesheet">
		 <link href="assets/css/item.css" rel="stylesheet">
	 	 <link href="assets/css/user.css" rel="stylesheet">
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
			$(document).ready(function(){
				$("#items-auctioned").masonry();
				$("#items-bid").masonry();
			});

		</script>

		<style>
		</style>
	</head>

	<body>

	<!--Header-->
	<?php include(dirname(__FILE__)."/include/header.php"); ?>
	
	<div class="container skip-header">	
		<div class="row">
		<div class="col-md-3 auto-col">
			<div class="prod-image">
				<img class="image" src="<?php echo $user_image ?>" />
				<span class="auction-status <?php echo $status ?>"><?php echo ucfirst($status); ?></span>
			</div>
		</div><!--Image-->

		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12 item-name-container"><!--heading column-->
					<h1><?php echo $userid ?></h1>
				</div><!--heading-->
			</div>

			<div class="row">
				<div class="col-md-12 user-stats">User Stats</div>	
			</div>

			<?php
				$db = get_db_handle();
				$db->beginTransaction();
				$comm = "SELECT count(*) num_items from item where userid = :userid";
				$result = $db->prepare($comm);
				$result->execute(array(":userid"=>$userid));
				$result = $result->fetch();
				$num_items = $result['num_items'];

				$comm = "SELECT count(*) num_bids from bid where userid = :userid";
				$result = $db->prepare($comm);
				$result->execute(array(":userid"=>$userid));
				$result = $result->fetch();
				$num_bids = $result['num_bids'];

				$comm = "SELECT max(amount) max_bid from bid where userid = :userid";
				$result = $db->prepare($comm);
				$result->execute(array(":userid"=>$userid));
				$result = $result->fetch();
				$max_bid = $result['max_bid'];
				$max_bid = empty($max_bid) ? 0 : $max_bid;

				$comm = "SELECT min(amount) max_bid from bid where userid = :userid";
				$result = $db->prepare($comm);
				$result->execute(array(":userid"=>$userid));
				$result = $result->fetch();
				$min_bid = $result['max_bid'];
				$min_bid = empty($min_bid) ? 0 : $min_bid;
			?>

			<div class="row stats-2" style="padding-top:15px;"><!--Dollaran-->
				<div class="col-md-4 auto-col" style="border-right:1px solid grey">
					<i class="icon-bookmark"> <?php echo $num_items ?></i><span> Items auctioned</span>	
				</div>	

				<div class="col-md-4 auto-col" style="border-right:1px solid gray;">
					<i class="icon-bullhorn"> <?php echo $num_bids; ?> </i><span> Biddings</span>	
				</div>	

				<div class="col-md-4 auto-col">
					<i class="icon-arrow-up"><?php echo $max_bid ?> </i><span> Highest Bid</span>
				</div>

			</div>
			</div><!--stats-->
		</div><!--row, big table, stats end -->
	
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="row heading-hr heading-hr-mild">
							<div class="col-md-1">
								<hr />
							</div>

							<div class="col-md-2 auto-col">
								<h1>Items Auctioned</h1>	
							</div>
						
							<div class="col-md-12">
								<hr />
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div id="items-auctioned">
						<?php 
							$comm = "SELECT * from item where userid = :userid";
							$result = $db->prepare($comm);
							$result->execute(array(":userid"=>$userid));
							$items = $result->fetchAll();
							echo build_pins($items)
						?>
						</div>
					</div>	
				</div>
			</div>
		</div><!--end row-->

		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="row heading-hr heading-hr-mild">
							<div class="col-md-1">
								<hr />
							</div>

							<div class="col-md-2 auto-col">
								<h1>Biddings</h1>	
							</div>
						
							<div class="col-md-12">
								<hr />
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div id="items-bid">
							<?php 
								$comm = "SELECT * from bid where userid = :userid";
								$result = $db->prepare($comm);
								$result->execute(array(":userid"=>$userid));
								$bids = $result->fetchAll();
								echo build_item_bid_pins($bids);
							?>
						</div>
					</div>	
				</div>
			</div>
		</div>


	</div>
	<?php include("include/footer.php"); ?>
	</body>
</html>


