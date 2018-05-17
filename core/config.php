<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'');
define('CART_COOKIE','bLueLineIlford363');
define('CART_COOKIE_EXPIRE',time() + (86400 *30));
define('TAXRATE',60.00);
define('TAXRATE2',0.00);

define('CURRENCY', 'gbp');
define('CHECKOUTMODE', 'TEST'); //Change TEST to LIVE when you are ready to go LIVE

if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE','sk_test_k6Dzsxr8FGKtQyFQetVmIJBQ');
	define('STRIPE_PUBLIC','pk_test_caqhHEsIzkkAU1dzURQJqqll');
}
if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE','sk_live_l54lPRuUBYciWP5QyWtbwDqR');
	define('STRIPE_PUBLIC','pk_live_3sbwTVfTT2MrAeylwBueojP8');
}