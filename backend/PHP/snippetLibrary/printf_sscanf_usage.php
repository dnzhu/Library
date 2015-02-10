<?php 

//Printf and sscanf examples

<?php

$file = "test.txt"; $lines = 7;
printf("The file %s consists of %d lines\n", $file, $lines);
// returns --> The file test.txt consists of 7 lines
 
 
// padding something, prefix a string with "_"
$word = 'foobar';
printf("%'_10s\n", $word);
// returns --> ____foobar
 
 
// format a number:
$number = 100.85995;
printf("%03d\n", $number); // returns --> 100
printf("%01.2f\n", $number); // returns --> 100.86
printf("%01.3f\n", $number); // returns --> 100.860
 
 
// parse a string with sscanf #1
list($number) = sscanf("ID/1234567","ID/%d");
print "$number\n";
// returns --> 1234567
 
 
// parse a string with sscanf #2
$test = "string 1234 string 5678";
$result = sscanf($test, "%s %d %s %d");
 
print_r($result);
