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

// こちらは東京のみの参照処理
//$sql = <<<SQL
//select p12_002 AS 'name',ST_X(SHAPE) AS 'lat',
//ST_Y(SHAPE) AS 'lng','kanko' as 'type' FROM p12a_14_13_utf8
//SQL;

// こちらは全国(メモ：SRIDがインポート時に適切に設定されるようにshp2mysqlを利用)
// 地図表示するデータが多いので、GEOHASH = xnに絞り込み。
$sql = <<<SQL
select p12_003 as 'name',
p12_004 as 'category',
ST_X(geom) AS "lat",ST_Y(geom) AS "lng", 
'kanko' as 'type'  FROM `p12-10-g_tourismresource_point`
where ST_Geohash(ST_Y(geom),ST_X(geom),2) = 'xn'
SQL;

// Iterate through the rows, adding XML nodes for each
$stmt = $connection->prepare($sql);
$stmt->execute();


while($row = $stmt->fetch()){
  // Add to XML document node
  // APPEND node AS CHILD OF ROOT
  $newnode = $xmlRoot->appendChild($dom->createElement('marker'));
  // APPEND CHILDREN TO node
  $newnode->setAttribute('name', $row['name']);
  $newnode->setAttribute('category', $row['category']);
  $newnode->setAttribute('lat', $row['lat']);
  $newnode->setAttribute('lng', $row['lng']);
  $newnode->setAttribute('type', $row['type']);
}
$stmt = null;
$db = null;

echo $dom->saveXML();

?>
