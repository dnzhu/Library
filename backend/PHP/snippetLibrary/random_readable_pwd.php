<?php 


function random_readable_pwd($length=10){
 
    // the wordlist from which the password gets generated 
    // (change them as you like)
    $words = 'dog,cat,sheep,sun,sky,red,ball,happy,ice,';
    $words .= 'green,blue,music,movies,radio,green,turbo,';
    $words .= 'mouse,computer,paper,water,fire,storm,chicken,';
    $words .= 'boot,freedom,white,nice,player,small,eyes,';
    $words .= 'path,kid,box,black,flower,ping,pong,smile,';
    $words .= 'coffee,colors,rainbow,plus,king,tv,ring';
 
    // Split by ",":
    $words = explode(',', $words);
    if (count($words) == 0){ die('Wordlist is empty!'); }
 
    // Add words while password is smaller than the given length
    $pwd = '';
    while (strlen($pwd) < $length){
        $r = mt_rand(0, count($words)-1);
        $pwd .= $words[$r];
    }
 
    // append a number at the end if length > 2 and
    // reduce the password size to $length
    $num = mt_rand(1, 99);
    if ($length > 2){
        $pwd = substr($pwd,0,$length-strlen($num)).$num;
    } else { 
        $pwd = substr($pwd, 0, $length);
    }
 
    return $pwd;
 
}

random_readable_pwd(10);
