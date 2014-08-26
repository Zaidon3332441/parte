<?php 

// File sample1.php 
// A simple example of how to use the MiniTemplator class. 

require_once ("../../MiniTemplator.class.php"); 

$t = new MiniTemplator; 

$t->readTemplateFromFile ("search.html"); 

// session
$sessionStatus = $_GET["session"];
if (isset($_SESSION)) {
}
else {
  if ($sessionStatus == 'start') {
    session_start();
  }
}


// region
require_once('db.php');
if(!$dbconn = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME)) {
  echo 'Could not connect to mysql on ' . DB_HOST . '\n';
  exit;
}

$result = mysqli_query($dbconn,"Select region_name from region;");

while($row = mysqli_fetch_array($result)) {
  $regions = "<option value='" . $row['region_name'] . "'>" . $row['region_name'] . "</option>";
  $t->setVariable ("regions",$regions); 
  $t->addBlock ("block1"); 
}

$result = mysqli_query($dbconn,"SELECT variety FROM grape_variety;");
                          
while($row = mysqli_fetch_array($result)) {
  $grapevariety = "<option value='" . $row['variety'] . "'>" . $row['variety'] . "</option>";
  $t->setVariable ("grapevariety",$grapevariety); 
  $t->addBlock ("block2"); 
}

$result = mysqli_query($dbconn,"SELECT year FROM wine group by year;");
                          
while($row = mysqli_fetch_array($result)) {
  $year = "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
  $t->setVariable ("minyear",$year); 
  $t->addBlock ("block3");
  $t->setVariable ("maxyear",$year); 
  $t->addBlock ("block4");
}

$t->generateOutput(); 

?>