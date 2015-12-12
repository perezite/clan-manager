<?php
include('util/header.php');
include('util/dblogin.php');

// Server löschen
echo "<center>Server l&ouml;schen</center><br><br>";
$sql = "DELETE FROM servers WHERE Counter='" .  $_GET["id"] . "'";
$result = mysql_query($sql);
// Menü anzeigen
echo "<center><br><br><br><b>***Server gel&ouml;scht!***<br><br>";
echo "<br><a href = 'index.php'>Hauptmen&uuml;</a><br>";
echo "<font face='arial' size='1'><br><br><br><br><br><br>Datenbank-Befehl: " . $sql . "<br></font></center>";


include('util/footer.php');
?>
