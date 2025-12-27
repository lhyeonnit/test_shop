<?php



ob_start('ob_gzhandler');

header("Content-Type: text/html; charset=utf-8");

header("Access-Control-Allow-Origin: *");



ini_set('session.cache_expire', 86400);

ini_set('session.gc_maxlifetime', 86400);

ini_set('session.use_trans_sid', 0);

ini_set('url_rewriter.tags', '');

ini_set("session.gc_probability", 1);

ini_set("session.gc_divisor", 100);



session_save_path($_SERVER['DOCUMENT_ROOT'].'/sessions');

session_cache_limiter('nocache, must_revalidate');

session_set_cookie_params(0, "/");

session_start();



header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');



include $_SERVER['DOCUMENT_ROOT']."/db_inc.php";

// include $_SERVER['DOCUMENT_ROOT']."/config_inc.php";

// include $_SERVER['DOCUMENT_ROOT']."/config_arr_inc.php";

// include $_SERVER['DOCUMENT_ROOT']."/common.lib.php";

