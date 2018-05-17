<?php 
require_once 'core/init.php';

if(isset($_SESSION['indicator'])) 
{
  header("Location: user.php");
}   
else
{
$_SESSION['indicator'] = "processed"; 

// Get the rest of the post data
$full_name = sanitize($_POST['full_name']);
$number = sanitize($_POST['number']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$comments = sanitize($_POST['comments']);
$tax = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);
if(isset($_SESSION['SBUser1'])){
$user_id = $user_id1;
}
$shipped = "Pending";
$metadata = array(
    "cart_id"    => $cart_id,
    "tax"        => $tax,
    "sub_total"  => $sub_total,
	);

//adjust inventory
  $itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $iresults = mysqli_fetch_assoc($itemQ);
  $items = json_decode($iresults['items'],true);
  foreach($items as $item){
  	$newSizes = array();
  	$item_id = $item['id'];
  	$productQ = $db->query("SELECT sizes FROM products WHERE id= '{$item_id}'");
  	$product = mysqli_fetch_assoc($productQ);
  	$sizes = sizestoArray($product['sizes']);
  	foreach($sizes as $size){
  		if($size['size'] == $item['size']){
  			$q = $size['quantity'] - $item['quantity'];
  			$newSizes[] = array('size' => $size['size'], 'quantity' => $q,'threshold' => $size['threshold'],);
  		}else{
  			$newSizes[] = array('size' => $size['size'],'quantity' => $size['quantity'],'threshold' => $size['threshold']);
  		}
  	}
  	$sizeString = sizestoString($newSizes);
  	$db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
  }

$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$db->query("INSERT INTO transactions 
	(cart_id,full_name,email,street,street2,city,country,sub_total,tax,grand_total,description,user_id) VALUES
	('$cart_id','$full_name','$number','$street','$street2','$city','$comments','$sub_total','$tax','$grand_total','$description','$user_id')");

$domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
setcookie(CART_COOKIE,'',1,'/',$domain,false);
include 'includes/head.php';
include 'includes/headertag.php';
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" style="background-color: #ebebeb;">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <style type="text/css">
        @import url(http://fonts.googleapis.com/css?family=Raleway:400,500,700);
        /* Font Styles */

        /* Media Queries */

        /*Setting the Web Font inside a media query so that Outlook doesn't try to render the web font */

        @media screen {
            .email-heading h1,
            .store-info h4,
            th.cell-name,
            a.product-name,
            p.product-name,
            .address-details h6,
            .method-info h6,
            h5.closing-text,
            .action-button,
            .action-button a,
            .action-button span,
            .action-content h1 {
                font-family: 'Raleway', Verdana, Arial !important;
                font-weight: normal;
            }
        }

        @media screen and (max-width: 600px) {
            body {
                width: 100% !important;
                padding: 0 3% !important;
                display: block !important;
            }
            .container-table {
                width: 100% !important;
                max-width: 600px;
                min-width: 300px;
            }
            td.store-info h4 {
                margin-top: 8px !important;
                margin-bottom: 0px !important;
            }
            td.store-info p {
                margin: 5px 0 !important;
            }
            .wrapper {
                width: 100% !important;
                display: block;
                padding: 5px 0 !important;
            }
            .cell-name,
            .cell-content {
                padding: 8px !important;
            }
        }

        @media screen and (max-width: 450px) {
            .email-heading,
            .store-info {
                float: left;
                width: 98% !important;
                display: block;
                text-align: center;
                padding: 10px 1% !important;
                border-right: 0px !important;
            }
            .address-details,
            .method-info {
                width: 85%;
                display: block;
            }
            .store-info {
                border-top: 1px dashed #c3ced4;
            }
            .method-info {
                margin-bottom: 15px !important;
            }
        }

        /* Remove link color on iOS */

        .no-link a {
            color: #333333 !important;
            cursor: default !important;
            text-decoration: none !important;
        }

        .method-info h6,
        .address-details h6,
        .closing-text {
            color: #3696c2 !important;
        }

        td.order-details h3,
        td.store-info h4 {
            color: #333333 !important;
        }

        .method-info p,
        .method-info dl {
            margin: 5px 0 !important;
            font-size: 12px !important;
        }

        =td.align-center {
            text-align: center !important;
        }

        td.align-right {
            text-align: right !important;
        }

        /* Newsletter styles */

        td.expander {
            padding: 0 !important;
        }

        table.button td,
        table.social-button td {
            width: 92% !important;
        }

        table.facebook:hover td {
            background: #2d4473 !important;
        }

        table.twitter:hover td {
            background: #0087bb !important;
        }

        table.google-plus:hover td {
            background: #CC0000 !important;
        }

        /* =================================
    ============ * * Product Grid * ============================================ */

        =@media screen and (max-width: 600px) {
            .products-grid tr td {
                width: 50% !important;
                display: block !important;
                float: left !important;
            }
        }

        .product-name a:hover {
            color: #3399cc !important;
            text-decoration: none !important;
        }

        /*]]>*/
    </style>

    <title></title>
</head>

<body>
    <!-- Begin wrapper table -->

    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="backgroun=
d-table" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0 auto; background-color: #ebebeb; font-size: 12px;">

        <tr>
            <td valign="top" class="top-content" style="font-family: Verdana, Arial; font-weight: normal; border-collapse: collapse; vertical-align: top; padding: 5px; margin: 0; border: 1px solid #ebebeb; background: #FFF;">
                <!-- Begin Content -->

                <table cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0; width: 100%;">
                    <tr>
                        <td style="font-family: Verdana, Arial; f=
ont-weight: normal; border-collapse: collapse; vertical-align: top; padding: 0; margin: 0;">
                            <table cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; padding: 0; margin: 0;">
                                <tr>
                                    <td class="email-heading" style="font-family: Verdana, Arial; font-weight: normal; border-collapse: collapse; vertical-align: top; padding: 0 1%; margin: 0; background: #e1f0f8; border-right: 1px dashed #c3ced4; text-align: center; width: 58%;">
                                        <h1 style="font-family: Verdana, Arial; font-weight: 700; font-size: 16px; margin: 1em 0; line-height: 20px; text-transform: uppercase; margin-top: 25px; color: black;">Thank you for your order with Blisscart.co.uk</h1>

                                        <p style="font-fa=
mily: Verdana, Arial; font-weight: normal; line-height: 20px; margin: 1em 0; color: black;">Your order has been successfully received . We will call you back on
                                            <?=$number;?> to take payment as we only accept payments on phone.</p>
                                    </td>

                                    <td class="store-info" style="font-family: Verdana, Arial; font-weight: normal; border-collapse: collapse; vertical-align=
: top; padding: 2%; margin: 0; background: #e1f0f8; width: 40%;">
                                        <h4 style="font-family: Verdana, Arial; font-weight: bold; margin-bottom: 5px; font-size: 12px; margin-top=
: 13px;">Order Questions?</h4>

                                        <p style="font-family: Verdana, Arial; font-weight: normal; font-size: 11px; line-height: 17px; margin: 1em 0;">
                                            <b>Contact us:</b>
                                            <a href="contact.php" style="color: #3696c2; text-decoration: underline;">Click here to send us message</a>
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="order-details" style="font-family: Verdana, Arial; font-weight: normal; border-collapse: collap=
se; vertical-align: top; padding: 5px 15px; margin: 0; text-align: center;">
                            <h3 style="font-family: Verdana, Arial; font-weight: normal; font-size: 17px; margin-bottom: 10px; margin-t=
op: 15px;">Your reciept number is
                                <strong>
                                    <?=$cart_id;?>
                                </strong>
                            </h3>

                        </td>
                    </tr>
                </table>
                <!-- End Content -->
            </td>
        </tr>
    </table>

    <h5 class="closing-text" style="font-family: Verdana, Arial; font-weight: normal; text-align: center; font-size: 22px; line-height: 32px; margin-bottom: -5px; margin-top: 30px;">
        <a href="user.php">Click here to see full details and track your order!</a>
        <br>Thank You</h5>
    <br>

    </td>
    </tr>
    </table>
    <!-- End wrapper table -->
</body>

</html>
<?php
include 'includes/footer.php';
 ?>