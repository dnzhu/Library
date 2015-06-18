<?php 

/**
 * PHP 如何验证一个邮箱是否真实有效
 * http://www.v2ex.com/t/199247
 * http://php.net/manual/zh/function.checkdnsrr.php
 */

function validate_email($email){

   $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";

   if(eregi($exp,$email)){

      if(checkdnsrr(array_pop(explode("@",$email)),"MX")){
        return true;
      }else{
        return false;
      }

   }else{

      return false;

   }    
}
