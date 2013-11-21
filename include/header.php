	<script>
		function sanitize(num)
		{
			if(num < 10)
			{
				return '0' + num;
			}
			
			return num;
		}

		$(document).ready(function(){
			$("#search-button").click(function(){
					search_nav();
				});

			$("#search-text").keypress(function(e){
					if(e.which==13) 		
					{
						search_nav();
					}	
				});

			$("#time-machine").click(function(){
				$("#time-modal").modal('show');
			});
		
			$("#time-machine-update").click(function(){

				var val = $("#date-picker").val();
				var new_time = new Date(val);

				var options = {'yyyy': sanitize(new_time.getUTCFullYear()), 'MM': sanitize(new_time.getUTCMonth() + 1), 'dd': sanitize(new_time.getUTCDate()), 'HH': sanitize(new_time.getUTCHours()), 'mm' : sanitize(new_time.getUTCMinutes()), 'ss': sanitize(new_time.getUTCSeconds())};

				$("#time-preloader").show();
				$("#time-machine-update").addClass('disabled');

				$.ajax({
					url:"api/set_time.php",
					data: options,
					type: 'GET',
					dataType: 'json',
		
					success: function(response){
						console.log(response);
						if(response['status']==200)
						{
							$("#time-machine-success-box").show();
						 	$("#time-preloader").hide();
						}	
						else
						{
							alert("Could not update the time. " + response['message']);
							$("#time-preloader").hide();
						}
						
						$("#time-machine-update").removeClass('disabled');
					}
				});		
			});

			$("#date-picker").change(function(){
				if($(this).val())
				{
					$("#time-machine-update").removeClass('disabled');
				}
				else
				{
					$("#time-machine-update").addClass('disabled');
				}
			});
		});
	
		function search_nav()
		{
			var search_query = $("#search-text").val();
			var url = "search.php?q="+encodeURIComponent(search_query);

			if(search_query)
			{
				window.location = url;
			}
		}

	</script>

	
	<!-- Fixed navbar -->
	    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color:rgba(0,0,0,0.85);">
	      <div class="container" style="padding:5px 0px 0px 0px;">
		<div class="header navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		    <span class="sr-only">Toggle navigation</span>
		    <span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="index.php">Auction Base</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav" style="margin:10px">
			  <div class="input-group header-search-box">
			      <input type="text" class="form-control" placeholder="Search items" id="search-text">
			      <span class="input-group-btn">
				<button class="btn btn-default" type="button" id="search-button"><span class="glyphicon glyphicon-search"></span> Search</button>
			      </span>
			    </div><!-- /input-group -->	
			</ul>  
		  <ul class="nav navbar-nav navbar-right">
		    <li><a class="header" id="time-machine">Time Machine</a></li>
		    <li><a class="header" href="about.php">About</a></li>
		  </ul>
		</div><!--/.nav-collapse -->
	      </div>
		<div class="navbar-collapse collapse nav-lower">
		  <div class="container">
			  <ul class="nav navbar-nav">
				<li><a href="search.php?q=electronics">Electronics</a></li>
				<li><a href="search.php?q=men">Men</a></li>
				<li><a href="search.php?q=women">Women</a></li>
				<li><a href="search.php?q=toys">Toys</a></li>
				<li><a href="search.php?q=music">Music</a></li>
			  </ul>
		  </div>
		</div>
	    </div>


	<!--Time Machine modal-->
	<div class="modal fade" id="time-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Update Current Time</h4>
	      </div>
		      <div class="modal-body">
			<form class="form" role="form">
				<div class="form-group">
					<input class="form-control" type="datetime-local" id="date-picker" />
					<p class="help-block">Current time: <?php echo format_date(get_time()); ?></p>
				</div>
			</form>

			<div class="alert alert-success" style="display:none;" id="time-machine-success-box"> Thank you! The time has been updated. Please refresh the page to see changes. </div>
		      </div>

		<div class="modal-footer">
		<img src="assets/img/preloader.gif" id="time-preloader" style="display:none;" />	
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-success disabled" id="time-machine-update">Update!</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

