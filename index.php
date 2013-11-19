<?php include(dirname(__FILE__)."/include/sqlitedb.php"); ?>
<?php include(dirname(__FILE__)."/include/utils.php"); ?>

<html>
	<head>
		<title>Welcome to AuctionBase!</title>
		
		 <!-- Bootstrap core CSS -->
		 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 	 <link href="assets/css/main.css" rel="stylesheet">
		 <link href="assets/css/bootstrap-custom.css" rel="stylesheet">
		 <link href="assets/css/carousel.css" rel="stylesheet">
		 <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/masonry/masonry.pkgd.min.js"></script>

		<script>
			$(document).ready(function(){
				$('.carousel').carousel();	

				$('#recent-auctions').masonry({ 
					columnWidth:180,
					itemSelector:".pin"
				});
			})
		</script>

		<style>
		</style>
	</head>

	<body>
	<!--Header-->
	<?php include(dirname(__FILE__)."/include/header.php"); ?>
	<!-- Carousel
	    ================================================== -->
    <div id="home-carousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#home-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#home-carousel" data-slide-to="1"></li>
        <li data-target="#home-carousel" data-slide-to="2"></li>
        <li data-target="#home-carousel" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img src="assets/img/chanel.jpg" alt="Fashion">
          <div class="container">
            <div class="carousel-caption">
              <h1>Women's apparel</h1>
              <p>Premium fashion products up for sale at AuctionBase</p>
              <p><a class="btn btn-danger" href="#" role="button">Browse Women's apparel</a></p>
            </div>
          </div>
        </div>

	<div class="item">
          <img src="assets/img/sean.jpg" alt="Led Zeppelin">
          <div class="container">
            <div class="carousel-caption">
              <h1>Going down now!</h1>
              <p>It's a celebration day. We've got <strong>93</strong> music items on sale.</p>
              <p><a class="btn btn-danger" href="#" role="button">Browse Men's apparel</a></p>
            </div>
          </div>
	</div>



        <div class="item">
          <img src="assets/img/batman.jpg" alt="Wines">
          <div class="container">
            <div class="carousel-caption">
              <h1>All your superheroes!</h1>
              <p>The occassion calls for a champagne. You bet we have it!</p>
              <p><a class="btn btn-danger" href="#" role="button">Browse superhero collection</a></p>
            </div>
          </div>
        </div>

	<div class="item">
          <img src="assets/img/gucci.jpg" alt="Led Zeppelin">
          <div class="container">
            <div class="carousel-caption">
              <h1>It is the best of times!</h1>
              <p>Keep the time with the latest timepieces on sale at AuctionBase.</p>
              <p><a class="btn btn-danger" href="#" role="button">Browse Others</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#home-carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#home-carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->
	
	<!--Most recent auctions-->
	<div class="container">

		<div class="row">
			<!--First column-->
			<div class="col-md-9" style="width:70%">
				<div class="panel panel-danger panel-custom recent-auctions-panel">
					<div class="panel-heading">
						<strong>Recent auctions</strong>
					</div>

				<!--recent auctions-->
					<div id="recent-auctions" class="panel-body">
					<?php 
						$db = get_db_handle();
						$db->beginTransaction();
						$com1 = "SELECT *, (select now from time) now from item order by julianday(now) - julianday(started) limit 8;";
						$result = $db->prepare($com1);
						$result->execute();
						$items = $result->fetchAll();
						$db->commit();
						echo build_pins($items);
					?>
		
					</div><!--recent-->
				</div><!--panel-->
			</div><!--col-->
			
			<!--Second column-->
			<div class="col-md-3">
				<div class="panel panel-success recent-auctions-panel">
					<div class="panel-heading">
						<strong>Start Selling</strong>
					</div>

					<div class="panel-body">

					</div>

				</div>
			</div>
		</div><!--row-->
	</div> <!--container-->

	<?php include("include/footer.php"); ?>

	</body>
</html>


