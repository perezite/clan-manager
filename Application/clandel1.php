<?php
include('util/header.php');
include('util/dblogin.php');

// Clan l�schen
echo "<center>Clan l&ouml;schen</center><br><br>";
$sql = "DELETE FROM clans WHERE Nummer='" .  $_GET["id"] . "'";
$result = mysql_query($sql);
// Alle dazugeh�rigen Server l�schen
$sql = "DELETE FROM servers WHERE ClanID='" .  $_GET["id"] . "'";
$result = mysql_query($sql);
// Men� anzeigen
echo "<center><br><br><br><b>***Clan gel&ouml;scht!***<br><br>";
echo "<br><a href = 'index.php'>Hauptmen&uuml;</a><br>";
echo "<font face='arial' size='1'><br><br><br><br><br><br>Datenbank-Befehl: " . $sql . "<br></font></center>";


include('util/footer.php');
?>
