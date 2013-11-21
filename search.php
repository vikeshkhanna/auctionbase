<?php include(dirname(__FILE__)."/include/sqlitedb.php"); ?>
<?php include(dirname(__FILE__)."/include/utils.php"); ?>

<?php
	$q = $_GET['q'];
	$category = $_GET['category'];
?>

<html>
	<head>
		<title>Search results!</title>
		
		 <!-- Bootstrap core CSS -->
		 <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 	 <link href="assets/css/main.css" rel="stylesheet">
		 <link href="assets/css/bootstrap-custom.css" rel="stylesheet">
		 <link href="assets/css/search.css" rel="stylesheet">
		 <link href="assets/slider/css/slider.css" rel="stylesheet">

		 <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.js"></script>
		<script src="assets/js/search.js"></script>
		<script src="assets/js/main.js"></script>
		<script src="assets/masonry/masonry.pkgd.min.js"></script>
		<script src="assets/masonry/jquery.masonry.ordered.js"></script>
		<script src="assets/slider/js/bootstrap-slider.js"></script>

		<script>
			var q = "<?php echo $q; ?>";
			var category = "<?php echo $category; ?>";

			var page=1;
			var first = true;
	
			$(document).ready(function(){
				$("#block-modal").modal();
				$(".collapse").collapse();

				$("#loader").click(function(){
					page = page + 1;
					get_lim();
				});

				$("#refine").click(function(){
					//reset 
					restart();
					get_lim();
					get_cat();
				});
	
				$("#sort-by").change( function() {
					restart();
					get_lim();
					get_cat();
				});
		
				init();
			});
		
			function restart()
			{
				page = 1;
				first = true;	
				$("#results").empty();
				$("#results").masonry("destroy");
			}

			function init()
			{
				init_sliders();
				get_lim();
				get_cat();
			}

		</script>

		<style>
		</style>
	</head>

	<body>
	<!--Header-->
	<?php include(dirname(__FILE__)."/include/header.php"); ?>

	<div class="container skip-header">	
		<div class="row"><!--Main row begins-->
			<div class="col-md-3"><!--Filter column begins-->
				<div class="row"> <!--Filter heading begins -->
					<div class="row heading-hr heading-hr-mild">
						<div class="col-md-2 tight-col">
							<hr />
						</div>

						<div class="col-md-1 auto-col tight-col">
							<h1>Filter</h1>	
						</div>
					
						<div class="col-md-12">
							<hr />
						</div>
					</div>
				</div><!--Filter heading ends-->
		
				<div class="row">
					<div class="col-md-12 filter-col">
						<div class="filter">
	
							<!--Categories-->
							<div id="categories" class="filter-type">
								<a class="filter-name collapse-trigger" data-toggle="collapse" data-target="#category-container">
									<i class="icon-chevron-right"></i> Categories <img src="assets/img/preloader.gif" id="categories-preloader" />
								</a>
								 
								<div id="category-container" class="collapse in collapse-container"> 
									<ul>
									</ul>
								</div>
							</div><!--Categories end-->
						
							<hr />

							<!--Price-->
							<div id="price" class="filter-type">
								<a class="filter-name"> Price </a>
								 
								<div id="price-container" class="filter-container">
									<b>1</b><div class="slider slider-horizontal" id="price-slider"></div><b>100</b>
									<div class="input-holder">
										<input type="text" id="min-price" /> to <input type="text" id="max-price" /> <a id="price-trash"><i class="icon-trash"></i></a>
									</div>
								</div>
							</div><!--Price end-->
		
							<hr />

							<!--Status-->
							<div id="status" class="filter-type">
								<a class="filter-name">Status</a>
								<div class="input-holder">
									<input type="checkbox" name="status" id="status-open" value="1" /> Open 
									<input type="checkbox" name="status" id="status-closed" value="0" /> Closed
								</div>
							</div><!--status end-->

							<hr />

							<!--Buy Price-->
							<div id="buy-price" class="filter-type">
								<a class="filter-name">Buy Price</a>
								<div id="buy-price-container" class="filter-container">
									<b>1</b><div class="slider slider-horizontal" id="buy-price-slider"></div><b>100</b>
									<div class="input-holder">
											<input type="text" id="min-buy-price" /> to <input type="text" id="max-buy-price" /> <a id="buy-price-trash"><i class="icon-trash"></i></a>								   </div>
								</div>
							</div><!--Buy Price-->

							<div class="filter-footer">
								<button class="btn btn-lg btn-primary" id="refine">Refine</button>
							</div>
						</div>
					</div>
				</div>
			</div><!--filter column ends-->


			<div class="col-md-9"><!--Search results begins-->
				<div class="row heading-hr heading-hr-mild"><!--Search heading begins-->
					<div class="col-md-1">
						<hr />
					</div>

					<div class="col-md-2 auto-col tight-col">
						<h1>Search Results</h1>	
					</div>
				
					<div class="col-md-12">
						<hr />
					</div>
				</div><!--Search heading ends-->

				<div class="row">
					<div class="col-md-12">
						<div>
							Sort by:  
							<select id="sort-by">
								<option value="plh">Price - Low to High </option>
								<option value="phl">Price - High to Low </option>
								<option value="pop">Popularity </option>
							</select>
						</div>	
					</div>
				</div>

				<div class="result-container">
					<div class="row"><!--Actual results begin-->
						<div class="col-md-12">
							<div id="results">
							</div>
						</div>
					</div><!--Actual results end-->

					<a class="filter-name collapse-trigger loader" id="loader">Load More </a>
				</div>
			</div>

		</div><!--Main row ends-->
	</div><!--container ends-->

	<div class="modal fade" id="block-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title" id="myModalLabel">Loading Auctions!</h4>
	      </div>
	      <div class="modal-body" style='text-align:center'>
			<img src="assets/img/preloader.gif" />
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<?php include("include/footer.php"); ?>

	</body>
</html>


