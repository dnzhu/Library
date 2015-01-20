<?php
//On this way you can find out how long a page needs to load.

$start = time();
 
// put a long operation in here
sleep(5);
 
 
$diff = time() - $start;
 
print "This page needed $diff seconds to load :-)";

// if you want a more exact value, you could use the 
// microtime function
