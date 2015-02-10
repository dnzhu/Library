<?php 

//Text to links
//Converts plain-links into HTML-Links

function text2links($str='') {
 
    if($str=='' or !preg_match('/(http|www\.|@)/i', $str)) { return $str; }
 
    $lines = explode("\n", $str); $new_text = '';
    while (list($k,$l) = each($lines)) { 
        // replace links:
        $l = preg_replace("/([ \t]|^)www\./i", "\\1http://www.", $l);
        $l = preg_replace("/([ \t]|^)ftp\./i", "\\1ftp://ftp.", $l);
 
        $l = preg_replace("/(http:\/\/[^ )\r\n!]+)/i", 
            "<a href=\"\\1\">\\1</a>", $l);
 
        $l = preg_replace("/(https:\/\/[^ )\r\n!]+)/i", 
            "<a href=\"\\1\">\\1</a>", $l);
 
        $l = preg_replace("/(ftp:\/\/[^ )\r\n!]+)/i", 
            "<a href=\"\\1\">\\1</a>", $l);
 
        $l = preg_replace(
            "/([-a-z0-9_]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)+))/i", 
            "<a href=\"mailto:\\1\">\\1</a>", $l);
 
        $new_text .= $l."\n";
    }
 
    return $new_text;
}

$text = "Visit www.jingwentian.com :-)";
 
print text2links($text);
