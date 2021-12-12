<?php

header("Content-type: text/xml; charset=utf-8");

// Import DB connections
require("phpsqlajax_dbinfo.php");

// PHP の DOM 関数を使用して XML を出力
$dom = new DOMDocument("1.0", "UTF-8");
$dom->formatOutput = true;
$dom->preserveWhiteSpace = false;

// CREATE ROOT AND APPEND TO DOCUMENT
$xmlRoot = $dom->createElement("markers");
$xmlRoot = $dom->appendChild($xmlRoot);

// Opens a connection to a MySQL server

try {
$connection = new PDO("mysql:host={$host};dbname={$database};charset=utf8", $username, $password);
} catch(PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}

// Select all the rows in the markers table

$sql = <<<SQL
select p12_002 AS 'name',ST_X(SHAPE) AS 'lat',
ST_Y(SHAPE) AS 'lng','restaurant' as 'type' FROM p12a_14_13_utf8
SQL;

// Iterate through the rows, adding XML nodes for each
$stmt = $connection->prepare($sql);
$stmt->execute();


while($row = $stmt->fetch()){
  // Add to XML document node
  // APPEND node AS CHILD OF ROOT
  $newnode = $xmlRoot->appendChild($dom->createElement('marker'));
  // APPEND CHILDREN TO node
  $newnode->appendChild($dom->createElement('name', $row['name']));
  $newnode->appendChild($dom->createElement('lat', $row['lat']));
  $newnode->appendChild($dom->createElement('lng', $row['lng']));
  $newnode->appendChild($dom->createElement('type', $row['type']));
}
$stmt = null;
$db = null;

echo $dom->saveXML();

?>