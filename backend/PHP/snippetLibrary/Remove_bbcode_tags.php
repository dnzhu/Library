<?php
/**
 * Remove BBCode tags and their content in PHP
 */
function stripBBCode($text_to_search) {
 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
 $replace = '';
 return preg_replace($pattern, $replace, $text_to_search);
}

echo stripBBCode($text_to_search);
?>
