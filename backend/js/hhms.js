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

function safeLinker(e) { 
    var title = $.trim($(e).val()); 
    title = title.replace(/[^a-zA-Z0-9-]+/g, '-');

    var safelink = 'input[name="safelink"]';
    $(safelink).val(title.toLowerCase());
}


$('.select-country').on('change', function () {
    try {
        let target = $('#' + $(this).attr('data-target'));
        fetch_state(this, target);
    } catch (e) {
        console.log(e.message);
    }
});

function fetch_state(e, receiver) {
    var country_id = e.options[e.selectedIndex].id;

    $.ajax({
        type: 'POST',
       	url: siteUrl+'homepage/fetch_locale/states/'+country_id,
        data: {country_id: country_id},
        dataType: 'JSON',
        success: function (data) {
            $(receiver).html(data.response);
            $(receiver).on('change', function () {
                let target = $('#' + $(this).data('target'));
                fetch_city(receiver, target);
            });
        }
    });
}

function fetch_city(e, receiver) {
    var state_id = e[0].options[e[0].selectedIndex].id;

    $.ajax({
        type: 'POST',
        url: siteUrl+'homepage/fetch_locale/cities/'+state_id,
        data: {state_id: state_id},
        dataType: 'JSON',
        success: function (data) {
            $(receiver).html(data.response);
        }
    })
}
