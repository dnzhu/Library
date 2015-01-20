<?php 

//Reduce a string by the middle
//Reduce a string by the middle, keeps whole words together

/**
 * Reduce a string by the middle, keeps whole words together
 *
 * @param string $string
 * @param int $max (default 50)
 * @param string $replacement (default [...])
 * @return string
 * @author david at ethinkn dot com
 * @author loic at xhtml dot ne
 * @author arne dot hartherz at gmx dot net
 */
 
function strMiddleReduceWordSensitive($string, $max = 50, $rep = '[...]') {
   $strlen = strlen($string);
 
   if ($strlen <= $max)
       return $string;
 
   $lengthtokeep = $max - strlen($rep);
   $start = 0;
   $end = 0;
 
   if (($lengthtokeep % 2) == 0) {
       $start = $lengthtokeep / 2;
       $end = $start;
   } else {
       $start = intval($lengthtokeep / 2);
       $end = $start + 1;
   }
 
   $i = $start;
   $tmp_string = $string;
   while ($i < $strlen) {
       if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
           $tmp_string = substr($tmp_string, 0, $i) . $rep;
           $return = $tmp_string;
       }
       $i++;
   }
 
   $i = $end;
   $tmp_string = strrev ($string);
   while ($i < $strlen) {
       if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
           $tmp_string = substr($tmp_string, 0, $i);
           $return .= strrev ($tmp_string);
       }
       $i++;
   }
   return $return;
   return substr($string, 0, $start) . $rep . substr($string, - $end);
}

// example:
 
$text = 'This is a very long test sentence, bla foo bar nothing';
 
print strMiddleReduceWordSensitive ($text, 30) . "\n";
// Returns: This is a very[...]foo bar nothing (~ 30 chrs)
 
print strMiddleReduceWordSensitive ($text, 30, '...') . "\n";
// Returns: This is a very...foo bar nothing (~ 30 chrs)
