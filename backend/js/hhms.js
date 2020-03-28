function fetch_stock() { 
	var service_div = document.getElementById("service");
	var service = service_div.options[service_div.selectedIndex].value; 
	console.log(service);
	$.ajax({
		type: 'POST',
		url: siteUrl+'services/list_stock/'+service,
		data: {type:1},  
		dataType: "JSON",
		success: function(data) { 
			console.log(data);
			$('#stock_item').html(data.stock_item); 
			$('#modal_btn_block').html('<button class="btn btn-success">Add Item</button>'); 
		}		
	})
}

function update_price(e, price) {
	var price = parseFloat(price);
	var cur_price = $('#price').val(); 

	var input = $(e);

	$('#price').val(cur_price+price); 
	$('#appendiv').html('<div class="text-info font-weight-bold">Total Cost: <span class="text-danger">'+site_currency+(cur_price+price)+'</span></div>'); 

	if (cur_price) {
		if (input.prop("checked") == true) {
			$('#price').val(parseFloat(cur_price)+price);  
		} else { 
			$('#price').val(parseFloat(cur_price)-price);  
		}
		var new_price = $('#price').val(); 

		$('#appendiv').html('<div class="text-info font-weight-bold">Total Cost: <span class="text-danger">'+site_currency+new_price+'</span></div>'); 

		console.log(parseFloat(new_price));
	}
}

$(document).ready(function() {
	$('input[type="checkbox"]').click(function() {
		var checked_box = $(this);
		if (checked_box.prop("checked") == true) {
			alert(checked_box.attr("id"));
		}
	})
})

