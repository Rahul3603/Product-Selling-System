<?php
session_start();

$con=mysqli_connect("localhost:3307","root","","rkindustries");
define('SITE_PATH','http://localhost/rkindustries/'); //imp


// $con=mysqli_connect("localhost","u183509287_prashantmrindu","S*L7t[/8puiW56","u183509287_dbmrprashindu");
// define('SITE_PATH','http://mrgrouptins.com/'); //imp


if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

?>