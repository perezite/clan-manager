<?php
include('util/header.php');
include('util/dblogin.php');

echo "<center>Claninfos</center><br><br>";
$sql = "SELECT * FROM clans WHERE counter='" .  $_GET["id"] . "'";
$result = mysql_query($sql);
$zeile = mysql_fetch_array($result);

// $zeile auslesen und ausgeben
echo "<center><table border='0'>";

echo "<form method = 'POST' action='clanaendern.php'>";

echo "<input type='hidden' name = 'id' value='" . $_GET["id"] . "'>";
echo "<input type='hidden' name = 'NummerAlt' value ='" . $zeile["Nummer"] . "'>";

echo "<tr><td>Name des Clans</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Clanname' value='" . $zeile["Clanname"] . "'></td></tr>";


echo "<tr><td> Name des Kontaktes </td>"; 
echo "<td><input type = 'text' size = '20' name = 'Kontakt' value='" . $zeile["Kontakt"] . "'></td></tr>";

echo "<tr><td>Adresse des Kontaktes</td>";
echo "<td>" . "<textarea rows='5' name='Adresse' cols = '27'>" . $zeile["Adresse"] .  "</textarea>" . "</td></tr>";

echo "<tr><td>PLZ/Wohnort</td>"; 
echo "<td><input type = 'text' size = '6' name = 'PLZ' value='" . $zeile["PLZ"] . "'>";
echo "<input type = 'text' size = '20' name = 'Ort' value='" . $zeile["Ort"] .  "'</td></tr>";

echo "<tr><td>Telefon</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Telefon' value='" . $zeile["Telefon"] . "'></td></tr>";

echo "<tr><td>E-Mail</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Mail' value='" . $zeile["Mail"] . "'></td></tr>";

echo "<tr><td>Kundennummer</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Nummer' value='" . $zeile["Nummer"] . "'></td></tr>";

echo "</table></center>";

echo "<center><table border='0'>";
echo "<tr><td><br><br><input type ='submit' value='&Auml;nderungen speichern'></form></td></tr>";
echo "</table></center>";

include('util/footer.php');
?>
