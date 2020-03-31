function fetch_stock(type) { 
	var service_div = document.getElementById("service");
	if (type) {
		console.log(service_div);
		var service = service_div.value
	} else {
		var service = service_div.options[service_div.selectedIndex].value; 
	}
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

function price_calculator(e, item_price) {

	var total = 0;
	var input = $(e);

	var check_name = input.attr('data-name');
	var val_check = $('input[id="'+check_name+'"]').prop("checked");

	if (val_check === true) {

		$.each($("input[type=checkbox]:checked"), function() {

			var checked = $(this).prop("checked");
			var item_id = $(this).data('id');

			if (checked) {
				var price = parseFloat($(this).data('price'));
				var quantity = parseInt($('#qty_'+item_id).val());
				var cur_price = price*quantity;
			}

			total += cur_price;
		});

		if (total == 0) {
			$('#price').val('0');  
		} else {
			$('#price').val(total);  
		}
 
		var new_price = $('#price').val(); 
		$('#appendiv').html('<div class="text-info font-weight-bold">Total Cost: <span class="text-danger">'+site_currency+new_price+'</span></div>');  
	}
}

function update_price(e, item_price) {

	var total = 0;
	var input = $(e);

	var item_id = input.data('id');
	$('#qty_'+item_id).val('1'); 
 
	$.each($("input[type=checkbox]:checked"), function() {  

		var var_item_id = $(this).data('id');
		var price = parseFloat($(this).data('price')); 

		if ($('#qty_'+var_item_id).val()) {
			var quantity = parseInt($('#qty_'+var_item_id).val());
			var price = price*quantity;
		}

		total += price; 
	});

	$.each($("input[type=checkbox]:not(:checked)"), function() {
		var this_id = $(this).data('id');
		$('#qty_'+this_id).val('1'); 
	});

	if (total == 0) {
		$('#price').val('0');  
	} else {
		$('#price').val(total);  
	}
 
	var new_price = $('#price').val(); 
	$('#appendiv').html('<div class="text-info font-weight-bold">Total Cost: <span class="text-danger">'+site_currency+new_price+'</span></div>');  
}

