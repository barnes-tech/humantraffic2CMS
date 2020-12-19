
<?php
//define debug, set to false on live server to prevent sharing error information
define('DEBUG', true);
//connection credentials
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ht_db');
define('DB_CHARSET', 'utf-8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
//define defualt controller if URL array is empty
define('DEFAULT_CONTROLLER','Home');
//if no layout is set controller uses default layout
define('DEFAULT_LAYOUT','default');
//site root,set to '/' on live server and '/lightspeed/' if using local host.
define('SROOT','/ht2/');
//default title
define('SITE_TITLE', 'Human Traffic 2');
//define session name for log
define('CURRENT_USER_SESSION_NAME', '1z+trDkSYcF3CvDrdsxLqvnuvwP/+8crut7+w+8TM4L5w=');
//cookie name for
define('REMEMBER_ME_COOKIE_NAME', 'lpWqkQZWHhXN890Ch9AjzWitFl54kiiygM3q8lrLNUD4');
//expiry time in seconds - 3days
define('REMEMBER_ME_COOKIE_EXPIRY', time()+60*60*24*7*4);
//define controller for restricted ACCESS_RESTRICTED
define('ACCESS_RESTRICTED', 'Restricted');
