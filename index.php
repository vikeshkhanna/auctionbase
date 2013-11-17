<html>
	<head>
		<title>Welcome to AuctionBase!</title>
		
		 <!-- Bootstrap core CSS -->
		 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 	 <link href="assets/css/main.css" rel="stylesheet">
		 <link href="assets/css/bootstrap-custom.cs" rel="stylesheet">
		 <link href="assets/css/carousel.css" rel="stylesheet">

		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>

		<script>
			$(document).ready(function(){
				$('.carousel').carousel();	
			})
		</script>
	</head>

	<body>
	 <!-- Fixed navbar -->
	    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color:rgba(0,0,0,0.8);">
	      <div class="container" style="padding:5px 0px 0px 0px;">
		<div class="header navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		    <span class="sr-only">Toggle navigation</span>
		    <span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="#">Auction Base</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav" style="margin:10px">
			  <form class="input-group header-search-box">
			      <input type="text" class="form-control" placeholder="Search items">
			      <span class="input-group-btn">
				<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span> Search</button>
			      </span>
			    </form><!-- /input-group -->	
			</ul>  
		  <ul class="nav navbar-nav navbar-right">
		    <li><a class="header" href="../navbar/">Sell item</a></li>
		    <li><a class="header" href="../navbar/">Contact us</a></li>
		    <li><a class="header" href="/">About</a></li>
		  </ul>
		</div><!--/.nav-collapse -->
	      </div>
		<div class="navbar-collapse collapse nav-lower">
		  <div class="container">
			  <ul class="nav navbar-nav">
				<li><a href="categories.php/">Electronics</a></li>
				<li><a href="categories.php/">Men</a></li>
				<li><a href="categories.php/">Women</a></li>
				<li><a href="categories.php/">Toys</a></li>
				<li><a href="categories.php/">Music</a></li>
				<li><a href="categories.php/">Something</a></li>
			  </ul>
		  </div>
		</div>
	    </div>
	
	<!-- Carousel
	    ================================================== -->
    <div id="home-carousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#home-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#home-carousel" data-slide-to="1"></li>
        <li data-target="#home-carousel" data-slide-to="2"></li>
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
          <img src="assets/img/zepp.jpg" alt="Led Zeppelin">
          <div class="container">
            <div class="carousel-caption">
              <h1>Going down now!</h1>
              <p>It's a celebration day. We've got <strong>93</strong> music items on sale.</p>
              <p><a class="btn btn-danger" href="#" role="button">Browse Music</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#home-carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#home-carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->
	
	<div class="container">
		<!--Bids-->
		<div class="row">
			<div class="col-md-1">
				<div class="thumbnail item-box">
				      <img src="assets/img/zepp.jpg" alt="..." />
				      <hr />
				      <img class="profile-pic" src="assets/img/zepp.jpg" />
				</div>
			</div>
		</div>
	</div>

	

	<!--bids-->


	</body>
</html>


