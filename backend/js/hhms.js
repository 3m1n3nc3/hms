function error_message(xhr, status, error, mid) {
    var errorMessage = 'An Error Occurred - ' + xhr.status + ': ' + xhr.statusText + '<br> ' + error;  
    
    $(mid).html( 
        '<div class="card m-2 text-center">'+
            '<div class="card-header p-2">Server Response: </div>'+
            '<div class="card-body p-2 text-info">'+
                '<div class="card-text font-weight-bold text-danger">'+errorMessage+'</div>'
                +xhr.responseText+
            '</div>'+
        '</div>'
    );
}

function confirmDelete(data, inline) { 
    var button_ajax   = '<a href="javascript:void(0)" class="p-0 mx-1 text-white btn btn-md btn-block btn-danger" data-delete="true" onclick="'+data+'" id="delete_confirm"> Yes Delete </a>';
    var button_inline = '<a href="'+data+'" class="p-0 mx-1 text-white btn btn-md btn-block btn-danger" data-delete="true" id="delete_confirm"> Yes Delete </a>';
    var button_list   = 
        '<div class="font-weight-bold">'+ (inline ? button_inline : button_ajax) +
            '<button type="button" class="p-0 mx-1 text-white btn btn-md btn-block btn-info" data-dismiss="modal">No</button>'+
        '</div>';

    $('#actionModal .modal-body').html('<p>Are you sure you want to delete this item?</p>');
    $('#actionModal .modal-body').append(button_list);
    $('#actionModal .modal-title').html('Confirmation');
    $("#actionModal").modal('show'); 
}

$('#actionModal').on('hide.bs.modal', function(e) { 
    $('#actionModal .modal-body, #actionModal .modal-title').html('');
    $('#actionModal .modal-body').html('<div class="loader"><div class="spinner-grow text-warning"></div></div>');
})

/**
 * Delete A contest
 * @param  {[string]} data [json string representing the data to be sent along with the request]
 * @return {[string]}      [null]
 */
function deleteItem(data) {
    console.log(data);

    if (data.init === 'dt') {
        var tr_id = '#tr_'+data.id;
    } else if (data.init === 'table') {
        var tr_id = '#table_row_'+data.id;
    } else {
        var tr_id = '#item-'+data.id;
    } 

    var m_id = '#msg_box';

    $(m_id).html('');

    var confirm = $('#delete_confirm').data('delete'); 

    if (confirm === true) {
        
        $("#actionModal").modal('hide'); 
        $(tr_id+' .btn').removeAttr('onclick');

        $.ajax({
            type: 'POST',
            url: siteUrl+'ajax/connect/deleteItem',
            data: data,  
            dataType: 'JSON',
            success: function(resps) {  console.log(resps);
                if (resps.response === true) { 
                    if (data.action === 1) {
                        $(tr_id).fadeOut('slow'); 
                    }
                }
            },
            error: function(xhr, status, error) {
                error_message(xhr, status, error, m_id);
            } 
        })
    } else {
        var onclick = $(tr_id+' .deleter').attr('onclick');
        confirmDelete(onclick);
    }
}


// $("*", document.body).click( function(event) {
//     event.stopPropagation();
//     var domElement = $(this);$(this).toggleClass('border border-info');
//     console.log($(this));
//     console.log(domElement.get(0));
//     console.log('Clicked on ' + domElement.get(0).nodeName);
// })


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
		},
        error: function(xhr, status, error) {
            error_message(xhr, status, error, '#stock_item');
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
       	url: siteUrl+'ajax/connect/fetch_locale/states/'+country_id,
        data: {country_id: country_id},
        dataType: 'JSON',
        success: function (data) {
            $(receiver).html(data.response);
            $(receiver).on('change', function () {
                let target = $('#' + $(this).data('target'));
                fetch_city(receiver, target);
            });
        },
        error: function(xhr, status, error) {
            error_message(xhr, status, error, receiver);
        }  
    });
}

function fetch_city(e, receiver) {
    var state_id = e[0].options[e[0].selectedIndex].id;

    $.ajax({
        type: 'POST',
        url: siteUrl+'ajax/connect/fetch_locale/cities/'+state_id,
        data: {state_id: state_id},
        dataType: 'JSON',
        success: function (data) {
            $(receiver).html(data.response);
        },
        error: function(xhr, status, error) {
            error_message(xhr, status, error, receiver);
        }  
    })
}

/**
 * fetch the image upload modal content and attach to the modal body
 * @param  {String} ){                                 var m_id [id or class of a container to append content]
 * @param  {[type]} error: function(xhr, status, error) {
 *                             error_message(xhr, status, error, m_id);        
 * }      })} [if there is an error on the page run the error function]
 * @return {[type]}        [null]
 */
$('.upload_resize_image').click(function(){

    var m_id = '.modal-content';
    var endpoint_id = $(this).data('endpoint_id');
    var endpoint = $(this).data('endpoint');
    var type = $(this).data('type'); 

    $.ajax({
        async: true,
        type: 'POST',
        url: siteUrl+'ajax/load_modal/upload_image',
        data: {endpoint_id:endpoint_id, endpoint:endpoint, type:type},  
        dataType: 'JSON',
        success: function(resps) { 
            $.getScript(siteUrl+"backend/js/plugins/upload-handler.js?time=1211");
            $(m_id).html(resps.content);
        },
        error: function(xhr, status, error) {
            error_message(xhr, status, error, m_id);
        }  
    })
})
    
// jQuery UI sortable for the todo list 
$('.todo-list').sortable({
    placeholder          : 'sort-highlight',
    handle               : '.handle',
    forcePlaceholderSize : true,
    zIndex               : 999999,
    update: function (event, ui) {
        var sort_order = $(this).sortable('serialize');
        $.ajax({
            async: true,
            type: 'POST',
            url: siteUrl+'ajax/connect/sortable',
            data: sort_order,  
            dataType: 'JSON',
            success: function(resps) { 
                console.log(resps);
            },
            error: function(xhr, status, error) { 
                error_message(xhr, status, error, '#sort_message');
            }  
        })
    }
}) 
