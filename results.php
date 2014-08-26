<?php 

// File sample1.php 
// A simple example of how to use the MiniTemplator class. 

require_once ("../../MiniTemplator.class.php"); 

$t = new MiniTemplator; 

$t->readTemplateFromFile ("results.html");

session_start();

// region
require_once('db.php');

// sql logic
$wine_name = $_GET["winename"];
$winery_name = $_GET["wineryname"];
$region = $_GET["region"];
$grape_variety = $_GET["grapevariety"];
$minrange_year = $_GET["minrangeofyear"];
$maxrange_year = $_GET["maxrangeofyear"];
$min_wine_stock = $_GET["minwinestock"];
$min_wine_order = $_GET["minwineorder"];
$min_cost = $_GET["mincostrange"];
$max_cost = $_GET["maxcostrange"];

$queries = "";

// session
$sessionStatus = $_GET["session"];
if ($sessionStatus == 'stop') {
        $queries = $_SESSION['views'];
        $_SESSION['views'] = "";
        session_destroy();
}

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
$db = new PDO($dsn, DB_USER, DB_PW);  


$sql = "select w.wine_name, gv.variety, w.year,
      wr.winery_name, r.region_name from wine as w,
        grape_variety as gv, winery as wr,
        wine_variety as wv, region as r,
        inventory as v, items as i
        where w.winery_id=wr.winery_id AND
        w.wine_id=wv.wine_id AND wv.variety_id=gv.variety_id
        AND r.region_id=wr.region_id AND w.wine_id=v.wine_id
        AND i.wine_id=w.wine_id AND w.wine_name like '%" . $wine_name . "%' AND wr.winery_name like '%" . $winery_name . "%' AND r.region_name = '" . $region . "' AND w.year between " . $minrange_year . " AND " . $maxrange_year . ";";


if (isset($_SESSION)) {
        $_SESSION['views'] .= $sql;
}
        
$openTag = "<table class='table' border='1'>
                <tr>
                <th>Wine Name</th>
                <th>Grape Varieties</th>
                <th>Year</th>
                <th>Winery</th>
                <th>Region</th>
                </tr>";
               
$t->setVariable ("table",$openTag); 
$t->addBlock ("block1");

try {

if (!$queries) {

$results = $db->prepare($sql);

$results->execute();

$rows = $results->fetchAll(PDO::FETCH_ASSOC);


if (!$rows) {
        $t->setVariable ("table","</table>");
        $t->addBlock ("block1");
        $t->setVariable ("table", "<h4 style='text-align:center'>Your search did not return any data.</h4>");
        $t->addBlock ("block1");
    }

foreach ($rows as $row) {
        $t->setVariable ("table", "<tr>");
        $t->addBlock ("block1");
        $t->setVariable ("table", "<td>" . $row['wine_name'] . "</td>");
        $t->addBlock ("block1");
        $t->setVariable ("table", "<td>" . $row['variety'] . "</td>");
        $t->addBlock ("block1");
        $t->setVariable ("table", "<td>" . $row['year'] . "</td>");
        $t->addBlock ("block1");
        $t->setVariable ("table", "<td>" . $row['winery_name'] . "</td>");
        $t->addBlock ("block1");
        $t->setVariable ("table", "<td>" . $row['region_name'] . "</td>");
        $t->addBlock ("block1");
        $t->setVariable ("table", "</tr>");
        $t->addBlock ("block1"); 
      }
    
} // if statement
if ($queries) {
        $myArray = explode(';', $queries);
        array_pop($myArray);
        
        foreach ($myArray as $sqlst) {
           $results = $db->prepare($sqlst);

        $results->execute();
        
        $rows = $results->fetchAll(PDO::FETCH_ASSOC);
        
        
        if (!$rows) {
                $t->setVariable ("table","</table>");
                $t->addBlock ("block1");
                $t->setVariable ("table", "<h4 style='text-align:center'>Your search did not return any data.</h4>");
                $t->addBlock ("block1");
            }
        
        foreach ($rows as $row) {
                $t->setVariable ("table", "<tr>");
                $t->addBlock ("block1");
                $t->setVariable ("table", "<td>" . $row['wine_name'] . "</td>");
                $t->addBlock ("block1");
                $t->setVariable ("table", "<td>" . $row['variety'] . "</td>");
                $t->addBlock ("block1");
                $t->setVariable ("table", "<td>" . $row['year'] . "</td>");
                $t->addBlock ("block1");
                $t->setVariable ("table", "<td>" . $row['winery_name'] . "</td>");
                $t->addBlock ("block1");
                $t->setVariable ("table", "<td>" . $row['region_name'] . "</td>");
                $t->addBlock ("block1");
                $t->setVariable ("table", "</tr>");
                $t->addBlock ("block1"); 
              }
        }
}


$endtag = "</table>";

$t->setVariable ("table", $endtag);
$t->addBlock ("block1");

}
catch (PDOException $e)
{
    echo $e->getMessage();
    die();
}

$t->generateOutput(); 

?>