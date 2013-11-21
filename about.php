<?php include(dirname(__FILE__)."/include/sqlitedb.php"); ?>
<?php include(dirname(__FILE__)."/include/utils.php"); ?>

<html>
	<head>
		<title>About</title>
		
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
			
		</script>

		<style>
		</style>
	</head>

	<body>

	<!--Header-->
	<?php include(dirname(__FILE__)."/include/header.php"); ?>
	
	<div class="container skip-header">	
		<!--If itemid is wrong-->
		<!--Desc and seller-->
		<div class="row" style="margin-top:60px;">
			<div class="col-md-12"><!--desc col-->
				<div class="megatron">
					<h1 class="extra-bold">About</h1>		
					<div class="content">
						<p>Stanford CS145 AuctionBase project, built by Vikesh over several sleepless nights.</p>
					</div>
				</div>
			</div><!--desc column end-->
		</div>
	</div>	
	<?php include("include/footer.php"); ?>
	</body>
</html>


