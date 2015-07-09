<?php 

if(!isset($_SESSION)) {
     session_start();
}

//OR

if (session_status() === PHP_SESSION_NONE){
  session_start();
  
}
