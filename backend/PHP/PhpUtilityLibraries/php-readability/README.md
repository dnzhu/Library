#PHP Readability Library

##Live demo

- [Readability](http://tools.jingwentian.com/readability/)

##Copyright

- [php-readability](https://github.com/feelinglucky/php-readability)

##Usage

    require 'lib/Readability.inc.php';
    
    $Readability     = new Readability($html, $html_input_charset); // default charset is utf-8
    $ReadabilityData = $Readability->getContent(); // throws an exception when no suitable content is found
    
    // You can see more params by var_dump($ReadabilityData);
    echo "<h1>".$ReadabilityData['title']."</h1>";
    echo $ReadabilityData['content'];
