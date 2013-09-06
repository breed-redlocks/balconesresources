<?php

$dbconnect  = NULL;
$query      = NULL;

function db_connect($str=false)
{
  $environment = 'production'; // Switch as necessary
  switch($environment)
  {
    case 'development':
      $host     = "localhost";
      $user = "dev_balconesreso";
      $pass = "";
      $db = "dev_balconesresources";
    break;
    case 'production':
      $host     = "localhost";
      $user = "balconesresource";
      $pass = "sgJNDDPY33yS";
      $db = "balconesresources";
    break;
  }
   
   if (!$dbconnect) $dbconnect = mysql_connect($host,$user,$pass);
   if (!$dbconnect) {
      return 0;
   } elseif (!mysql_select_db($db)) {
      return 0;
   } else {
      return $dbconnect;
   } // if
   
} // db_connect
?>
