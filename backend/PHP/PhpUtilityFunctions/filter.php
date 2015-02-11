<?php 

/**
 * [PHP Filter 函数]
 * PHP 过滤器用于对来自非安全来源的数据（比如用户输入）进行验证和过滤。
 * 1. filter_has_var()	检查是否存在指定输入类型的变量。
 * 2. filter_id()	返回指定过滤器的 ID 号。
 * 3. filter_input()	从脚本外部获取输入，并进行过滤。
 * 4. filter_input_array()	从脚本外部获取多项输入，并进行过滤。
 * 5. filter_list()	返回包含所有得到支持的过滤器的一个数组。
 * 6. filter_var_array()	获取多项变量，并进行过滤。
 * 7. filter_var()	获取一个变量，并进行过滤。
 * --------------------------------------------------------------------
 * [Filter 过滤器]
 * FILTER_CALLBACK	调用用户自定义函数来过滤数据。
 * FILTER_SANITIZE_STRING	去除标签，去除或编码特殊字符。
 * FILTER_SANITIZE_STRIPPED	"string" 过滤器的别名。
 * FILTER_SANITIZE_ENCODED	URL-encode 字符串，去除或编码特殊字符。
 * FILTER_SANITIZE_SPECIAL_CHARS	HTML 转义字符 '"<>& 以及 ASCII 值小于 32 的字符。
 * FILTER_SANITIZE_EMAIL	删除所有字符，除了字母、数字以及 !#$%&'*+-/=?^_`{|}~@.[]
 * FILTER_SANITIZE_URL	删除所有字符，除了字母、数字以及 $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=
 * FILTER_SANITIZE_NUMBER_INT	删除所有字符，除了数字和 +-
 * FILTER_SANITIZE_NUMBER_FLOAT	删除所有字符，除了数字、+- 以及 .,eE。
 * FILTER_SANITIZE_MAGIC_QUOTES	应用 addslashes()。
 * FILTER_UNSAFE_RAW	不进行任何过滤，去除或编码特殊字符。
 * FILTER_VALIDATE_INT	在指定的范围以整数验证值。
 * FILTER_VALIDATE_BOOLEAN	如果是 "1", "true", "on" 以及 "yes"，则返回 true，如果是 "0", "false", "off", "no" 以及 ""，则返回 false。否则返回 NULL。
 * FILTER_VALIDATE_FLOAT	以浮点数验证值。
 * FILTER_VALIDATE_REGEXP	根据 regexp，兼容 Perl 的正则表达式来验证值。
 * FILTER_VALIDATE_URL	把值作为 URL 来验证。
 * FILTER_VALIDATE_EMAIL	把值作为 e-mail 来验证。
 * FILTER_VALIDATE_IP	把值作为 IP 地址来验证。
 *
 */
 
 #filter_has_var() 函数检查是否存在指定输入类型的变量。若成功，则返回 true，否则返回 false。
 //filter_has_var(type, variable)
 //type: INPUT_GET、INPUT_POST、INPUT_COOKIE、INPUT_SERVER、INPUT_ENV
 
 if(!filter_has_var(INPUT_GET, "name")) {
    echo("Input type does not exist");
 } else {
    echo("Input type exists");
 }
 
 #filter_id() 函数返回指定过滤器的 ID 号。若成功，则返回过滤器的 ID 号。如果该过滤器不存在，则返回 NULL。
 
 #filter_input() 函数从脚本外部获取输入，并进行过滤。
 //本函数用于对来自非安全来源的变量进行验证，比如用户的输入。
 //本函数可从各种来源获取输入：
 /* INPUT_GET
    INPUT_POST
    INPUT_COOKIE
    INPUT_ENV
    INPUT_SERVER
    INPUT_SESSION (Not yet implemented)
    INPUT_REQUEST (Not yet implemented)
    如果成功，则返回被过滤的数据，如果失败，则返回 false，如果 variable 参数未设置，则返回 NULL。
  */
  if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
     echo "E-Mail is not valid";
  } else {
     echo "E-Mail is valid";
  }
  
  #filter_input_array() 函数从脚本外部获取多项输入，并进行过滤。
  //本函数无需重复调用 filter_input()，对过滤多个输入变量很有用。
  //本函数可从各种来源获取输入：
  /*INPUT_GET
    INPUT_POST
    INPUT_COOKIE
    INPUT_ENV
    INPUT_SERVER
    INPUT_SESSION (Not yet implemented)
    INPUT_REQUEST (Not yet implemented)
    如果成功，则返回被过滤的数据，如果失败，则返回 false。
  */
  
  $filters = array(
   "name" => array(
      "filter"=>FILTER_CALLBACK,
      "flags"=>FILTER_FORCE_ARRAY,
      "options"=>"ucwords"
    ),
   "age" => array(
      "filter"=>FILTER_VALIDATE_INT,
      "options"=>array(
         "min_range"=>1,
         "max_range"=>120
       )
    ),
   "email"=> FILTER_VALIDATE_EMAIL,
   );
  print_r(filter_input_array(INPUT_POST, $filters));
  
  #filter_list() 函数返回包含所有得到支持的过滤器的一个数组。
  
  print_r(filter_list());
  
  #filter_var() 函数通过指定的过滤器过滤变量。
  //如果成功，则返回已过滤的数据，如果失败，则返回 false。
  //filter_var(variable, filter, options)
  
  if(!filter_var("someone@example.com", FILTER_VALIDATE_EMAIL)){
      echo("E-mail is not valid");
  } else {
      echo("E-mail is valid");
  }
  
  #filter_var_array() 函数获取多项变量，并进行过滤。
  //由于无需重复调用 filter_input()，因此本函数对过滤多个变量很有用。
  //如果成功，则返回包含被过滤的变量值的数组，如果失败，则返回 false。
  
  $arr = array(
     "name" => "peter griffin",
     "age" => "41",
     "email" => "peter@example.com",
   );

  $filters = array(
    "name" => array(
        "filter"=>FILTER_CALLBACK,
        "flags"=>FILTER_FORCE_ARRAY,
        "options"=>"ucwords"
    ),
   "age" => array(
      "filter"=>FILTER_VALIDATE_INT,
      "options"=>array(
           "min_range"=>1,
           "max_range"=>120
       )
    ),
   "email"=> FILTER_VALIDATE_EMAIL,
   );

   print_r(filter_var_array($arr, $filters));
 
 
 
 
