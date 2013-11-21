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
}
}

function ucfirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function build_pin(item)
{		
	var img = item['img']; 
	var item_status = (item['open']==1 ? 'open' : 'closed');
	var itemid = item['ItemID'];
	var item_name = item['Name'];
	var number_of_bids = item['Number_of_Bids'];
	var seller = item['seller'];
	var amount = item['Currently'];
	var seller_id = seller['userid'];
	var seller_img = seller['img'];

	var pin = $('<div class="thumbnail pin">');
	pin.append('<img src="{0}">'.format(img));
	pin.append('<div class="pin-status {0}">{1}</div>'.format(item_status, ucfirst(item_status)));

	var pin_container = $("<div class='pin-container'>");
	pin.append(pin_container);	 

	var pin_stats = $('<div class="pin-stats">');
	pin_container.append(pin_stats);	

	pin_stats.append('<a href="item.php?itemid={0}">{1}</a>'.format(itemid, item_name));
	pin_stats.append('<ul><li><i class="icon-bullhorn"></i> {0}</li></ul>'.format(number_of_bids));		

	var bid_stats = $("<div class='bid-stats'><i class='icon-usd'></i>{0}</div>".format(amount));
	pin_container.append(bid_stats);

	var pin_user = $('<a class="pin-user" href="user.php?userid={0}"><img src="{1}" /><span>{0}</span></a>'.format(seller_id, seller_img));
	pin_container.append(pin_user);

	return pin;
}


