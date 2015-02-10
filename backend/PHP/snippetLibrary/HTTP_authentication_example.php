<?php 

//参考：http://php.net/manual/zh/features.http-auth.php

// The full url to this file is required for 
// the Logout function
$CurrentUrl         = 'www.jingwentian.com/test_login.php';
 
// Status flags:
$LoginSuccessful    = false;
$Logout             = false;
 
// Check username and password:
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
 
    $usr = $_SERVER['PHP_AUTH_USER'];
    $pwd = $_SERVER['PHP_AUTH_PW'];
 
    // Does the user want to login or logout?
    if ($usr == 'jonas' && $pwd == 'foobar'){
        $LoginSuccessful = true;
    }
    else if ($usr == 'reset' && $pwd == 'reset' && isset($_GET['Logout'])){ 
        // reset is a special login for logout ;-)
        $Logout = true;
    }
}
 
 
if ($Logout){
 
    // The user clicked on "Logout"
    print 'You are now logged out.';
    print '<br/>';
    print '<a href="http://'.$CurrentUrl.'">Login again</a>';
}
else if ($LoginSuccessful){
 
    // The user entered the correct login data, put
    // your confidential data in here: 
    print 'You reached the secret page!<br/>';
    print '<br/>';
 
    // This will not clear the authentication cache, but
    // it will replace the "real" login data with bogus data
    print '<a href="http://reset:reset@'. $CurrentUrl .'?Logout=1">Logout</a>';
}
else {
 
    /* 
    ** The user gets here if:
    ** 
    ** 1. The user entered incorrect login data (three times)
    **     --> User will see the error message from below
    **
    ** 2. Or the user requested the page for the first time
    **     --> Then the 401 headers apply and the "login box" will
    **         be shown
    */
 
    // The text inside the realm section will be visible for the 
    // user in the login box
    header('WWW-Authenticate: Basic realm="Top-secret area"');
    header('HTTP/1.0 401 Unauthorized');
 
    // Error message
    print "Sorry, login failed!\n";
    print "<br/>";
    print '<a href="http://' . $CurrentUrl . '">Try again</a>';
 
}
