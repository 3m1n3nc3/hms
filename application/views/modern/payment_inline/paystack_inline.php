            <script src="https://js.paystack.co/v1/inline.js"></script>
            <script type="text/javascript">
                
                var $loader = '<div class="loader"><div class="spinner-grow text-warning"></div></div>'; 
                // var paymentForm = document.getElementById('paymentForm');
                var paymentBtn = document.getElementById('paybtn');
                // paymentForm.addEventListener("submit", payWithPaystack, false); 
                if (paymentBtn) {
                    paymentBtn.addEventListener("click", payWithPaystack);
                }

                function payWithPaystack() {

                    $('#paybtn').html($loader);
                    $('#paybtn').attr('disabled', 'disabled');

                    var handler = PaystackPop.setup({
                        key: '<?= my_config('paystack_public') ?>', // Replace with your public key
                        email: '<?= $customer['customer_email'] ?>',
                        currency: '<?= my_config('currency_code') ?>',
                        amount: '<?= (($post['amount'] ?? $room[0]->room_price)*$room[0]->vat/100)+($post['amount'] ?? $room[0]->room_price)*100 ?>',
                        firstname: '<?= $customer['customer_firstname'] ?>',
                        lastname: '<?= $customer['customer_lastname'] ?>',
                        ref: '<?= $post['payment_ref'] ?>',
                        // label: "Optional string that replaces customer email"
                        onClose: function(){
                            $('.loader').remove();
                            $('#paybtn').removeAttr('disabled');
                            $('#paybtn').html('<i class="far fa-credit-card"></i> Pay Now ');
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo site_url() ?>'
                            });
                        },
                        callback: function(response){
                            window.location.href = '<?php echo site_url('page/rooms/book/'.$room[0]->id) ?>?reference=' + response.reference; 
                        }
                    });
                      
                    handler.openIframe();
                }

            </script>
