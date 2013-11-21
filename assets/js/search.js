function search(options, callback)
{
	$.ajax({
		url:"api/search.php",
		data: options,
		type: 'GET',
		dataType: 'json',
		
		success: function(reponse){
				callback(reponse);
		}
	});			
}

function init_sliders()
{
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

	price_slider.slider().on('slide', function(ev) {
		$("#min-price").val(ev.value[0]); 
		$("#max-price").val(ev.value[1]); 
	});

	buy_price_slider.slider().on('slide', function(ev) {
		$("#min-buy-price").val(ev.value[0]); 
		$("#max-buy-price").val(ev.value[1]); 
	});

	$("#price-trash").click(function(){
			$("#min-price").val("");
			$("#max-price").val("");
		});

	$("#buy-price-trash").click(function(){
		$("#min-buy-price").val("");
		$("#max-buy-price").val("");
	});

	$("#min-price, #max-price").keyup(function() {
		var val1 = $("#min-price").val();
		var val2 = $("#max-price").val();
	
		var vals = [Math.min(val1, val2), Math.max(val1, val2)];

		price_slider.slider('setValue', vals);
	});

	$("#min-buy-price, #max-buy-price").keyup(function() {
		var val1 = $("#min-buy-price").val();
		var val2 = $("#max-buy-price").val();
		var vals = [Math.min(val1, val2), Math.max(val1, val2)];

		buy_price_slider.slider('setValue', vals);
	});
}

function get_search_options()
{
	searchOptions = {'q':q, 'page':page};

	if(cur_cat!=null)
	{
		searchOptions['hardcat'] = 1;
		category = cur_cat.attr("id").replace("&", "&amp;");
	}

	searchOptions['category'] = category;

	var min_price = $("#min-price").val();
	var max_price = $("#max-price").val();
	
	var min_buy_price = $("#min_buy_price").val();
	var max_buy_price = $("#max_buy_price").val();
	
	if(min_price) searchOptions['min_price'] = min_price;
	if(max_price) searchOptions['max_price'] = max_price;
	if(min_buy_price) searchOptions['min_buy_price'] = min_buy_price;
	if(max_buy_price) searchOptions['max_buy_price'] = max_buy_price;

	var open = $("#status-open").is(":checked");
	var closed = $("#status-closed").is(":checked");
	var status = 2;

	if(open && closed)
	{
		status = 2;
	}
	else
	{
		if(open && !closed)
		{
			status = 1;
		}
		else if(!open && closed)
		{
			status = 0;
		}
	}

	searchOptions['sort'] = $("#sort-by").val();
	searchOptions['status'] = status;
	return searchOptions;
}


function get_lim()
{

	$("#block-modal").modal("show");

	searchOptions = get_search_options(); 
	searchOptions['mode'] = 'lim';
	
	console.log("Searching with options: ");
	console.log(searchOptions);

	search(searchOptions,
		function(response){
			if(response['status']==200)
			{
				console.log(response);
				var items = response['items'];
		
				for(var p in items)
				{
					if(items.hasOwnProperty(p)){
						var pin = build_pin(items[p]);
						$("#results").append(pin);
						if(!first) $("#results").masonry("appended", pin);
					}
				}
		
				if(first)
				{
					$("#results").masonry();
					first = false;
				}	
			}
			else
			{
				$("#results").empty();
				$("#results").append('<div class="bs bs-callout bs-callout-danger"><div class="alert alert-danger">'+ response['message'] +'</div>');
			}

			// Hide modal
			$("#block-modal").modal("hide");
		});
}

function get_cat()
{
	$("#categories-preloader").show();

	// Must only be called at init - SLOW
	searchOptions = get_search_options(); 
	searchOptions['mode'] = 'cat';

	search(searchOptions,
		function(response){
			if(response['status']==200)
			{
				$("#categories-container ul").empty();
				console.log(response);
				var categories = response['categories'];
				var ul = $("#category-container ul");
		
				for(var category in categories)
				{
					var count = categories[category];
					var html = '<li><a id="{0}">{0} ({1})</a></li>'.format(category, count);
					ul.append(html);
				}	

				// Hide categories preloader
			}

			$("#categories-preloader").hide();
	
			$("#category-container a").click(function() {
				var cat = $(this);

				if(cur_cat == null)
				{
					cur_cat = cat;
					cur_cat.addClass('active');
				}
				else if(cur_cat == cat)
				{
					cur_cat.removeClass('active');	
					cur_cat = null;
				}	
				else
				{
					cur_cat.removeClass('active')
					cur_cat = cat;
					cur_cat.addClass('active');
				}
	
				restart();
				get_lim();
			});
		});	
}
