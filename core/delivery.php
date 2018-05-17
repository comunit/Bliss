<?php 
      require_once 'core/init.php';
      include 'includes/headertag.php';
      include 'includes/head.php';
?>  
    <style>
    	.delivery {
    		background-color: 	#dedbdb;
    		text-align: center;
    		box-shadow: 3px 3px 3px #888888;
    		

    	}
    	.delivery2 {
    		background-color: 	#dedbdb;
    		text-align: center;
    		margin-left: 10px;
    		box-shadow: 3px 3px 3px #888888;
    		
    		

    	}
    	h3 {
    		font-family: 'Open Sans', arial;
    		font-weight: 300
    		letter-spacing: 1px;
    		text-transform: uppercase;
    	}
    	p {
    		color: #666666;
            font-size: 1.2em;
            text-align: center;
		    font-family: 'Open Sans', arial;
		    font-weight: normal;
		    margin: 25px 0 15px 0;
		    letter-spacing: 1px;
    	}
    	.price {
    		color: #2b4230;
		    font-size: 1.1em;
		    font-weight: bold;
		    line-height: 30px;
    	}

    </style>
    <h3 class="text-center bg-info text-whit">Delivery and Returns</h3><br>
    <p class="text-center bg-primary text-white"">HOME DELIVERIES</p>
    <div class="row">
  <div class="delivery col-md-4 col-md-offset-2">
   <h1 style="margin-top: 15px;"><span class="price">£4.99</span></h1>
     <p>STANDARD DELIVERY</p>
     <p>Order Online before 8pm for next day delivery</p>
     <p>Mon-Sat, 8am - 8pm</p>
     <p>Excluding bank holiday</p>
  </div>
   <div class="delivery2 col-md-4 col-md-offset-0">
   <h1 style="margin-top: 15px"><span class="price">FREE</span></h1>
     <p>STANDARD DELIVERY ORDERS OVER £50</p>
     <p>Order Online before 8pm for next day delivery</p>
     <p>Mon-Sat, 8am - 8pm</p>
     <p>Excluding bank holiday</p>
  </div>
</div><br>
<h3 class="text-center bg-info text-whit">RETURN DELIVERIES</h3><br>
    <div class="row text-center col-md-offset-4">
  <div class="delivery2 col-md-6">
   <h1 style="margin-top: 15px"><span class="price">FREE</span></h1>
     <p>VIA THE POST OFFICE</p>
     <p>Return your order to us via the post office.</p>
     <p>Ensure you attach the prepaid label included with your parcel.</p>
  </div>
</div><br>

<?php include 'includes/footer.php';  ?>