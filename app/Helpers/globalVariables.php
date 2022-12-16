<?php

define('min_rate', 1);
define('max_rate', 5);
define('max_featured_products', 10);
define('default_reset_password_link_expiration_time', 600);
define('default_cache_expiration_time', 1296000);

//promos
define('default_promo_length', 6);

//messages
define('wrong_credentials_message', "These Credentials Don't Match Our Records");
define("promo_regex_message", "Code Must be ".constant("default_promo_length")." characters (only numbers and letters allowed)");
