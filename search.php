<?php include(dirname(__FILE__)."/include/sqlitedb.php"); ?>
<?php include(dirname(__FILE__)."/include/utils.php"); ?>

<?php
	$q = $_GET['q'];
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
		<script src="assets/masonry/masonry.pkgd.min.js"></script>
		<script src="assets/slider/js/bootstrap-slider.js"></script>

		<script>
			var q = "<?php echo $q; ?>";
			
			$(document).ready(function(){
				$('#search-results').masonry({ 
					columnWidth:185,
					itemSelector:".pin"
				});
				
				$(".collapse").collapse();

				var price_slider = $("#price-slider").slider({
					min:0,
					max:100,
					step:1,
					value:[1,100],
					tooltip:'show'
				});


				var buy_price_slider = $("#buy-price-slider").slider({
					min:0,
					max:100,
					step:1,
					value:[1,100],
					tooltip:'show'
				});

				init();
			});

			function init()
			{
				// Show modal and block page
				search({"q":q}, function(response){
				 	console.log(response);
					var categories = response['categories'];
					var ul = $("#category-container ul");
			
					for(var category in categories)
					{
						var count = categories[category];
						var html = '<li><a href="{0}">{1} ({2})</a></li>'.format("#", category, count);
						ul.append(html);
					}	
					// Update categories collapse
				});
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
									<i class="icon-chevron-right"></i> Categories
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
										<input type="text" id="min-price" /> to <input type="text" id="max-price" />
									</div>
								</div>
							</div><!--Price end-->
		
							<hr />

							<!--Status-->
							<div id="status" class="filter-type">
								<a class="filter-name">Status</a>
								<div class="input-holder">
									<input type="checkbox" name="status" value="1" /> Open 
									<input type="checkbox" name="status" value="0" /> Closed
								</div>
							</div><!--status end-->

							<hr />

							<!--Buy Price-->
							<div id="buy-price" class="filter-type">
								<a class="filter-name">Buy Price</a>
								<div id="buy-price-container" class="filter-container">
									<b>1</b><div class="slider slider-horizontal" id="buy-price-slider"></div><b>100</b>
									<div class="input-holder">
											<input type="text" id="min-buy-price" /> to <input type="text" id="max-buy-price" />								   </div>
								</div>
							</div><!--Buy Price-->

							<div class="filter-footer">
								<button class="btn btn-lg btn-primary">Refine</button>
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
						<div id="sort-by">
							Sort by:  
							<select>
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
							hello kitty
						</div>
					</div><!--Actual results end-->
				</div>
			</div>

		</div><!--Main row ends-->
	</div><!--container ends-->

	<?php include("include/footer.php"); ?>

	</body>
</html>


