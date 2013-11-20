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

// First, checks if it isn't implemented yet.
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}


