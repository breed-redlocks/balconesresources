<?php

$dbconnect  = NULL;
$query      = NULL;

function db_connect($str=false)
{
  $environment = 'production'; // Switch as necessary
  switch($_SERVER['HTTP_HOST'])
  {
    case 'localhost:2201':
    case 'localhost:8080':
      $host = 'localhost';
      $user = 'root';
      $pass = 'root';
      $db = 'brdevdb';
    break;
    case 'dev.balconesresources.com':
      $host     = "localhost";
      $user = "dev_balconesreso";
      $pass = "";
      $db = "dev_balconesresources";
    break;
    default:
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
