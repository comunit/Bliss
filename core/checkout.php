<?php 
      require_once 'core/init.php';
      include 'includes/headertag.php';
      include 'includes/head.php';

if ($cart_id != '') {
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$result = mysqli_fetch_assoc($cartQ);
	$items = json_decode($result['items'],true);
	$i = 1;
	$sub_total = 0;
	$item_count = 0;
}
?>
<div class="container">
	<div class="check-out">
		<h1>My Shopping Cart</h1>
    	 <?php if ($cart_id == ''): ?>
    	  <div class="bg-danger">
    	  	<p class="text-centre text-danger" style="text-align: center;">
    	  		Your Shopping Cart Is Empty!
    	  	</p>
    	  </div>
    	 <?php else: ?>
    	 <table >
		  <tr>
		    <th>#</th>
			<th>Item</th>
			<th>Qty</th>		
			<th>Prices</th>
			<th>Size</th>
			<th>Subtotal</th>
		  </tr>
		  <?php 
           foreach($items as $item){
           	$product_id = $item['id'];
           	$productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
           	$product = mysqli_fetch_assoc($productQ);
           	$sArray = explode(',',$product['sizes']);
           	foreach($sArray as $sizeString){
           		$s = explode(':',$sizeString);
           		if($s[0] == $item['size']){
           			$available = $s[1];
           		}
           	}
		  ?>
		  <tr>
		    <td><?=$i;?></td>
            <?php $photos1 = explode(',',$product['image']); ?>
			<td class="ring-in"><a href="#" class="at-in"><img src=<?=$photos1[0];?> class="img-responsive" alt=""></a>
			<div class="sed">
				<h5><?=$product['title']?></h5>
				<p><?=$product['description']?></p>
			
			</div>
			<td>

            <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size']?>');">-</button>
			<?=$item['quantity'];?>
			<?php if($item['quantity'] < $available): ?>
		    <button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size']?>');">+</button>
            <?php else: ?>
            <span class="text-danger">Max Available</span>
            <?php endif; ?>
			</td>		
			<td><?=$product['price']?></td>
			<td><?=$item['size'];?></td>
			<td><?=money($item['quantity'] * $product['price']);?></td>
		  </tr>
	<?php 
     $i++;
     $item_count += $item['quantity'];
     $sub_total += ($product['price'] * $item['quantity']);
	} 
     if ($sub_total < 50) {
     $tax = TAXRATE;
     } else {
      $tax = TAXRATE2;
     }
     $grand_total = $tax + $sub_total;

	?>
	</table>

	<table >
		  <tr>
		    <th>Total items</th>
		    <th>Sub Total</th>
		    <th>Delivery</th>
		    <th>Grand Total</th>
		  </tr>
		    <td><?=$item_count;?></td>		
			<td><?=money($sub_total);?></td>
			<td><?=money($tax);?></td>
			<td class="bg-success"><?=money($grand_total);?></td>
	</table>
	    <!-- Checkout modal -->
    <?php if(!is_logged_in1()) : ?>
        <a class="btn btn-primary pull-right btn-lg" href="login1" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Check Out >></a>
     <?php else : ?>
<button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#checkoutModal">
  <span class="glyphicon glyphicon-shopping-cart"></span> Continue >>
</button>
     <?php endif; ?>
<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkoutModalLabel">Shipping Address</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        	<form action="thankYou" method="post" id="payment-form">
        	<span class="bg-danger" id="payment-errors"></span>
        	 <input type="hidden" name="tax" value="<?=$tax;?>">
        	 <input type="hidden" name="sub_total" value="<?=$sub_total;?>">
        	 <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
        	 <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
        	 <input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count>1)?'s':'').' from apparel manufuctrers.';?>">
        		<div id="step1" style="display: block;">
        			<div class="from-group col-md-6">
        				<label for="full_name">Full Name </label>
        				<input type="text" name="full_name" id="full_name" class="form-control">
        			</div>
        			<div class="from-group col-md-6">
        				<label for="email">Email </label>
        				<input type="email" name="email" id="email" class="form-control">
        			</div>
        			<div class="from-group col-md-6">
        				<label for="street">Street Address </label>
                        <input type="text" name="street" id="street" class="form-control" data-stripe="address_line1">
        			</div>
        			<div class="from-group col-md-6">
        				<label for="street2">Street Address 2 </label>
        				<input type="text" name="street2" id="street2" class="form-control" data-stripe="address_line2">
        			</div>
        			<div class="from-group col-md-6">
        				<label for="city">City </label>
        				<input type="text" name="city" id="city" class="form-control" data-stripe="address_city">
        			</div>
        			<div class="from-group col-md-6">
        				<label for="county">County </label>
        				<input type="text" name="county" id="county" class="form-control" data-stripe="address_state">
        			</div>
        			<div class="from-group col-md-6">
        				<label for="postcode">Post Code </label>
        				<input type="text" name="postcode" id="postcode" class="form-control" data-stripe="address_zip">
        			</div>
        			<div class="from-group col-md-6">
        				<label for="country">Country </label>
        				<input type="text" name="country" id="country" class="form-control" data-stripe="address_country">
        			</div>
        		</div>
                <div id="step2" style="display: none;">
                <p id="shiptobilling" class="form-row" style="padding-left: 15px; padding-bottom: 10px;">
                <input type="checkbox" id="uncheck" onclick="SetBilling();" /> 
                Same as delivery address</p>
                    <div class="from-group col-md-6">
                        <label for="full_name">Full Name </label>
                        <input type="text" name="full_name1" id="full_name1" class="form-control" >
                    </div>
                    <div class="from-group col-md-6">
                        <label for="street">Street Address </label>
                        <input type="text" name="street1" id="street1" class="form-control" data-stripe="address_line1">
                     </div>
                     <div class="from-group col-md-6">
                        <label for="street">Street Address 2 </label>
                        <input type="text" name="street21" id="street21" class="form-control" data-stripe="address_line1">
                     </div>
                    <div class="from-group col-md-6">
                        <label for="city">City </label>
                        <input type="text" name="city1" id="city1" class="form-control" data-stripe="address_city">
                    </div>
                    <div class="from-group col-md-6">
                        <label for="county">County </label>
                        <input type="text" name="county1" id="county1" class="form-control" data-stripe="address_state">
                    </div>
                    <div class="from-group col-md-6">
                        <label for="postcode">Post Code </label>
                        <input type="text" name="postcode1" id="postcode1" class="form-control" data-stripe="address_zip">
                    </div>
                    <div class="from-group col-md-6">
                        <label for="country">Country </label>
                        <input type="text" name="country1" id="country1" class="form-control" data-stripe="address_country">
                    </div>

                </div>
        		<div id="step3" style="display: none;">
        			<div class="form-group col-md-3">
        				<label for="name">Name on Card:</label>
        				<input type="text" class="form-control" data-stripe="name">
        			</div>
        			<div class="form-group col-md-3">
        				<label for="number">Card Number</label>
        				<input type="text" id="number" class="form-control" data-stripe="number">
        			</div>
        			<div class="form-group col-md-2">
        				<label for="cvc">CVC:</label>
        				<input type="text" id="cvc" class="form-control" data-stripe="cvc">
        			</div>
        			<div class="form-group col-md-2">
        				<label for="exp-month">Expire Month:</label>
        				<select id="exp-month" class="form-control" data-stripe="exp_month">
        					<option value=""></option>
        					<?php for($i=1;$i < 13; $i++): ?>
                             <option value="<?=$i;?>"><?=$i;?></option>
        					<?php endfor; ?>
        				</select>
        			</div>
        			<div class="form-group col-md-2">
        				<label for="exp-year">Expire Year:</label>
        				<select id="exp-year" class="form-control" data-stripe="exp_year">
        					<option value=""></option>
        					<?php $yr = date("Y"); ?>
        					<?php for($i=0;$i<11; $i++): ?>
                            <option value="<?=$yr+$i;?>"><?=$yr+$i;?></option>
        					<?php endfor; ?>
        				</select>
        			</div>
        		</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="step1();" id="take1" style="display: none;">Back</button>
        <button type="button" class="btn btn-primary" onclick="step2();" id="take2" style="display: none;">Back</button>
        <button type="submit" class="btn btn-primary" id="checkout_button" style="display: none;">Check Out>></button>
        <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button" ">Next >></button>
        <button type="button" class="btn btn-primary" onclick="check_address1();" id="next_button1" style="display: none;" ">Next >></button>
        </form>
      </div>
    </div>
  </div>
</div>

    	 <?php endif; ?>
	<div class="clearfix"> </div>
    </div>
</div>
<script>
function SetBilling() {
    jQuery('#payment-errors').html("");
                    jQuery('#street1').attr('data-stripe', '0');
                    jQuery('#street21').attr('data-stripe', '0');
                    jQuery('#city1').attr('data-stripe', '0');
                    jQuery('#county1').attr('data-stripe', '0');
                    jQuery('#postcode1').attr('data-stripe', '0');
                    jQuery('#country1').attr('data-stripe', '0');
                    jQuery('#payment-errors').html("");
                    jQuery('#step1').css("display",'none');
                    jQuery('#step2').css("display",'none');
                    jQuery('#step3').css("display",'block');
                    jQuery('#next_button').css("display",'none');
                    jQuery('#take1').css("display",'none');
                    jQuery('#take2').css("display",'inline-block');
                    jQuery('#next_button').css("display",'none');
                    jQuery('#next_button1').css("display",'none');
                    jQuery('#checkout_button').css("display",'inline-block');
                    jQuery('#checkoutModalLabel').html("Enter your card details")
    }
function check_address(){
        var data = {
            'full_name' : jQuery('#full_name').val(),
            'email' : jQuery('#email').val(),
            'street' : jQuery('#street').val(),
            'street2' : jQuery('#street2').val(),
            'city' : jQuery('#city').val(),
            'county' : jQuery('#county').val(),
            'postcode' : jQuery('#postcode').val(),
            'country' : jQuery('#country').val(),
        };
    jQuery.ajax({
             url : '/admin/parsers/check_address',
             method : 'post',
             data : data,
             success : function(data){
                if(data != 'passed'){
                    jQuery('#payment-errors').html(data);
                }
                if (data == 'passed') {
                    jQuery('#payment-errors').html("");
                    jQuery('#step1').css("display",'none');
                    jQuery('#step2').css("display",'block');
                    jQuery('#take1').css("display",'inline-block');
                    jQuery('#next_button').css("display",'none');
                    jQuery('#next_button1').css("display",'inline-block');
                    jQuery('#checkout_button').css("display",'none');
                    jQuery('#checkoutModalLabel').html("Enter Billing Address")

                }
             },
             error : function(){alert("Something Went Wrong");},
    });
    }
    function step1(){
        jQuery('#payment-errors').html("");
                    jQuery('#step1').css("display",'block');
                    jQuery('#step2').css("display",'none');
                    jQuery('#step3').css("display",'none');
                    jQuery('#take1').css("display",'none');
                    jQuery('#take2').css("display",'none');
                    jQuery('#next_button').css("display",'inline-block');
                    jQuery('#next_button1').css("display",'none');
                    jQuery('#checkoutModalLabel').html("Shipping Address");
    }
    function step2(){
        jQuery('#payment-errors').html("");
                    jQuery('#step1').css("display",'none');
                    jQuery('#step2').css("display",'block');
                    jQuery('#step3').css("display",'none');
                    jQuery('#next_button1').css("display",'inline-block');
                    jQuery('#take1').css("display",'inline-block');
                    jQuery('#take2').css("display",'none');
                    jQuery('#uncheck').attr('checked', false); 
                    jQuery('#checkout_button').css("display",'none');
                    jQuery('#checkoutModalLabel').html("Billing Address");
    }
    function check_address1(){
        var data = {
            'full_name1' : jQuery('#full_name1').val(),
            'street1' : jQuery('#street1').val(),
            'street21' : jQuery('#street21').val(),
            'city1' : jQuery('#city1').val(),
            'county1' : jQuery('#county1').val(),
            'postcode1' : jQuery('#postcode1').val(),
            'country1' : jQuery('#country1').val(),
        };
    jQuery.ajax({
             url : '/admin/parsers/check_address1',
             method : 'post',
             data : data,
             success : function(data){
                if(data != 'good'){
                    jQuery('#payment-errors').html(data);
                }
                if (data == 'good') {
                    jQuery('#payment-errors').html("");
                    jQuery('#step1').css("display",'none');
                    jQuery('#step2').css("display",'none');
                    jQuery('#step3').css("display",'block');
                    jQuery('#next_button').css("display",'none');
                    jQuery('#take1').css("display",'none');
                    jQuery('#take2').css("display",'inline-block');
                    jQuery('#next_button').css("display",'none');
                    jQuery('#next_button1').css("display",'none');
                    jQuery('#checkout_button').css("display",'inline-block');
                    jQuery('#checkoutModalLabel').html("Enter your card details")

                }
             },
             error : function(){alert("Something Went Wrong");},
    });
    }


Stripe.setPublishableKey('<?=STRIPE_PUBLIC;?>');

function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form:
    $form.find('#payment-errors').text(response.error.message);
    $form.find('button').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token ID into the form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken">').val(token));

    // Submit the form:
    $form.get(0).submit();
  }
};

$(function() {
  var $form = $('#payment-form');
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find('.submit').prop('disabled', true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});
</script>
<?php 
      include 'includes/footer.php';
?>