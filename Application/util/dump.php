<?php
include('dblogin.php');
$sql = "SELECT * FROM " . $_GET["tabelle"];
$result = mysql_query($sql);

$zeile = mysql_fetch_array($result);
$dump = "INSERT INTO " . $_GET["intabelle"];
while (list($bezeichner, $dummy)=each($)

while($zeile=mysql_fetch_array($result))
{
  
}
echo $sql;
?>

