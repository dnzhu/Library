<?php
// Start output buffering, this will
// catch all content so that we can 
// do some calculations

ob_start();
 
 
// Some example HTML
print '<html>';
 
// put your content in here:
print '<h1>Example content</h1>';
 
print '<ul>';
for ($x=0; $x < 10; $x++)
    print "<li>List item $x</li>";
 
print '</ul>';
print '</html>';
 
// or include() something here
 
 
// Now save all the content from above into
// a variable
$PageContent = ob_get_contents();
 
// And clear the buffer, so the
// contents will not be submitted to 
// the client (we do that later manually)
ob_end_clean();
 
 
// Generate unique Hash-ID by using MD5
$HashID = md5($PageContent);
 
// Specify the time when the page has
// been changed. For example this date
// can come from the database or any
// file. Here we define a fixed date value:
$LastChangeTime = 1144055759;
 
// Define the proxy or cache expire time 
$ExpireTime = 3600; // seconds (= one hour)
 
// Get request headers:
$headers = apache_request_headers();
// you could also use getallheaders() or $_SERVER
// or HTTP_SERVER_VARS 
 
// Add the content type of your page
header('Content-Type: text/html');
 
// Content language
header('Content-language: en');
 
// Set cache/proxy informations:
header('Cache-Control: max-age=' . $ExpireTime); // must-revalidate
header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ExpireTime).' GMT');
 
// Set last modified (this helps search engines 
// and other web tools to determine if a page has
// been updated)
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $LastChangeTime).' GMT');
 
// Send a "ETag" which represents the content
// (this helps browsers to determine if the page
// has been changed or if it can be loaded from
// the cache - this will speed up the page loading)
header('ETag: ' . $HashID);
 
 
// The browser "asks" us if the requested page has
// been changed and sends the last modified date he
// has in it's internal cache. So now we can check
// if the submitted time equals our internal time value.
// If yes then the page did not get updated
 
$PageWasUpdated = !(isset($headers['If-Modified-Since']) and 
    strtotime($headers['If-Modified-Since']) == $LastChangeTime);
 
 
// The second possibility is that the browser sends us
// the last Hash-ID he has. If he does we can determine
// if he has the latest version by comparing both IDs. 
 
$DoIDsMatch = (isset($headers['If-None-Match']) and 
    ereg($HashID, $headers['If-None-Match']));
 
// Does one of the two ways apply?
if (!$PageWasUpdated or $DoIDsMatch){
 
    // Okay, the browser already has the
    // latest version of our page in his
    // cache. So just tell him that
    // the page was not modified and DON'T
    // send the content -> this saves bandwith and
    // speeds up the loading for the visitor
 
    header('HTTP/1.1 304 Not Modified');
 
    // That's all, now close the connection:
    header('Connection: close');
 
    // The magical part: 
    // No content here ;-) 
    // Just the headers
 
}
else {
 
    // Okay, the browser does not have the
    // latest version or does not have any
    // version cached. So we have to send him
    // the full page.
 
    header('HTTP/1.1 200 OK');
 
    // Tell the browser which size the content
    header('Content-Length: ' . strlen($PageContent));
 
    // Send the full content
    print $PageContent;
}
