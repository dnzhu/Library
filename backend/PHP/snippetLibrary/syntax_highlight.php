<?php

//Simple Syntax highlighting 

function syntax_highlight($code){
 
    // this matches --> "foobar" <--
    $code = preg_replace(
        '/"(.*?)"/U', 
        '&quot;<span style="color: #007F00">$1</span>&quot;', $code
    );
 
    // hightlight functions and other structures like --> function foobar() <--- 
    $code = preg_replace(
        '/(\s)\b(.*?)((\b|\s)\()/U', 
        '$1<span style="color: #0000ff">$2</span>$3', 
        $code
    );
 
    // Match comments (like /* */): 
    $code = preg_replace(
        '/(\/\/)(.+)\s/', 
        '<span style="color: #660066; background-color: #FFFCB1;"><i>$0</i></span>', 
        $code
    );
 
    $code = preg_replace(
        '/(\/\*.*?\*\/)/s', 
        '<span style="color: #660066; background-color: #FFFCB1;"><i>$0</i></span>', 
        $code
    );
 
    // hightlight braces:
    $code = preg_replace('/(\(|\[|\{|\}|\]|\)|\->)/', '<strong>$1</strong>', $code);
 
    // hightlight variables $foobar
    $code = preg_replace(
        '/(\$[a-zA-Z0-9_]+)/', '<span style="color: #0000B3">$1</span>', $code
    );
 
    /* The \b in the pattern indicates a word boundary, so only the distinct
    ** word "web" is matched, and not a word partial like "webbing" or "cobweb" 
    */
 
    // special words and functions
    $code = preg_replace(
        '/\b(print|echo|new|function)\b/', 
        '<span style="color: #7F007F">$1</span>', $code
    );
 
    return $code;
}
 
 
/*example-start*/
 
/*
** Create some example PHP code:
*/
 
$example_php_code = '
// some code comment:
$example = "foobar";
 
print $_SERVER["REMOTE_ADDR"];
 
$array = array(1, 2, 3, 4, 5);
 
function example_function($str) {
    // reverse string
    echo strrev($obj);
}
 
print example_function("foo");
 
/*
** A multiple line comment
*/
 
print "Something: " . $example;';
 
 
// output the formatted code:
print '<pre>';
print syntax_highlight($example_php_code);
print '</pre>';
 
/*example-end*/
