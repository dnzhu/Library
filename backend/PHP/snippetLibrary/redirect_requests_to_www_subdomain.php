<?php

//Sometimes it is useful to redirect all requests to the www subdomain, because some search engines may spider find duplicate content because it indexes your domain with and without the www subdomain. So this script helps you forcing the use of the www subdomain.

// Install info.:
// Copy and paste these lines into your default index.php or
// the file that get's called if a visitor comes on your 
// website...
 
// read the host from the server environment
$host = $_SERVER["HTTP_HOST"];
 
// fix host name - we never now... ;-)
$host = strtolower($host);
$host = trim($host);
 
// This is important: 
// Webbrowsers like Firefox are doing their request without
// the port number like "www.jonasjohn.de" but some other 
// applications send host names like "www.jonasjohn.de:80" 
$host = str_replace(':80', '', $host);
$host = trim($host);
 
// if the host is not starting with www. redirect the 
// user to the same URL but with www :-)
if ($host != 'www.jonasjohn.de'){
    // You an also change the "!=" to "==", if you want to force 
    // the user to use the domain name without the www. 
 
    // send status header, so that search engines or other services
    // detect that this is a permanent redirect and not a temporary
    header('HTTP/1.1 301 Moved Permanently');
 
    // read the URL the user requested:
    $url = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '';
 
    // redirect the user to the new destination:
    header('Location: http://www.jonasjohn.de' . $url);
 
    // Convert "special" chars -- cause we never now... ;-)
    $url = htmlspecialchars($url);
 
    // "fallback" link, if the browser is not supporting header redirects
    print '<a href="http://www.jonasjohn.de' . $url.'">Please click here</a>';
 
    // stop the script execution here
    exit;
}
 
// If the domain is www.jonasjohn.de then go on with your PHP code 
// of with your website...
 
// BTW: You need to replace jonasjohn.de trough your own domain :-D
