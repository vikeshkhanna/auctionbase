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

	<div class="container skip-header item">	
		<div class="row">
			<div class="col-md-3 auto-col">
				<img class="image" src="metadata/items/default.jpg" />
			</div><!--Image-->

			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12"><!--heading column-->
						<h1>Fur catball, hello kitty, little ball of fur (vintage)</h1>
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
						<i class="icon-heart">  4</i>	
					</div>	

					<div class="col-md-4 auto-col">
						<i class="icon-bullhorn">  4</i>	
					</div>
				</div>
			</div><!--stats-->
		</div><!--row, big table-->
	</div>
		
	<?php include("include/footer.php"); ?>
	</body>
</html>


