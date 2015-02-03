<?php 

function get_current_page_url() {
    $ssl        = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
    $sp         = strtolower($_SERVER['SERVER_PROTOCOL']);
    $protocol   = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port       = $_SERVER['SERVER_PORT'];
    $port       = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host       = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    return $protocol . '://' . $host . $port . $_SERVER['REQUEST_URI'];
}
