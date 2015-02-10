<?php 

//Number suffix
//Adds a suffix to a given number (1st, 2nd, 3rd, ...)

// Also, increasing the range above the condition statements
// increases efficiency. That's almost 20% of the numbers 
// between 0 and 100 that get to end early.
 
function number_suffix($number){
 
    // Validate and translate our input
    if ( is_numeric($number)){
 
        // Get the last two digits (only once)
        $n = $number % 100;
 
    } 
    else {
        // If the last two characters are numbers
        if ( preg_match( '/[0-9]?[0-9]$/', $number, $matches )){
 
            // Return the last one or two digits
            $n = array_pop($matches);
        } 
        else {
 
            // Return the string, we can add a suffix to it
            return $number;
        }
    }
 
    // Skip the switch for as many numbers as possible.
    if ( $n > 3 && $n < 21 )
        return $number . 'th';
 
    // Determine the suffix for numbers ending in 1, 2 or 3, otherwise add a 'th'
    switch ( $n % 10 ){
        case '1': return $number . 'st';
        case '2': return $number . 'nd';
        case '3': return $number . 'rd';
        default:  return $number . 'th';
    }
}

print number_suffix(3);
//returns: 3rd
 
print number_suffix(51);
//returns: 51st
 
print number_suffix(94859);
//returns: 94859th
