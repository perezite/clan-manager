<?php
include('util/header.php');
include('util/dblogin.php');
include('util/function.php');

echo "<center>Serverinfos</center><br>";
$sql = "SELECT * FROM servers WHERE counter='" .  $_GET["id"] . "'";
$result = mysql_query($sql);
$zeile = mysql_fetch_array($result);

// $zeile auslesen und ausgeben
echo "<center><table border='0'>";

echo "<form method = 'POST' action='serveraendern.php'>";

echo "<input type='hidden' name = 'id' value='" . $_GET["id"] . "'>";

echo "<tr><td>Art des Servers: </td>"; 
echo "<td><input type = 'text' size = '20' name = 'Serverart' value='" . $zeile["Serverart"] . "'></td></tr>";

echo "<tr><td>Beschreibung des Servers: </td>";
echo "<td>" . "<textarea rows='5' name='BeschrServer' cols = '27'>" . $zeile["BeschrServer"] .  "</textarea>" . "</td></tr>";

echo "<tr><td>IP des Servers: </td>"; 
echo "<td><input type = 'text' size = '20' name = 'IP' value='" . $zeile["IP"] . "'></td></tr>";

echo "<tr><td>Anzahl Slots: </td>"; 
echo "<td><input type = 'text' size = '20' name = 'Slots' value='" . $zeile["Slots"] . "'></td></tr>";

echo "<tr><td>Public/Clan</td>";
if ($zeile["bPublic"] == 0)
{
  echo "<td><select name='bPublic'>
    <option value='0' selected='selected'>Clan</option>
    <option value='1'>Public</option>
  </select></td></tr>";
}
else
{
  echo "<td><select name='bPublic'>
    <option value='1' selected='selected'>Public</option>
    <option value='0'>Clan</option>
  </select></td></tr>";
}

echo "<tr><td>Voice-Server:<br>(Leer lassen, falls keiner)</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Voice' value='" . $zeile["Voice"] . "'></td></tr>";

echo "<tr><td>Werbung:</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Werbung' value='" . $zeile["Werbung"] . "'></td></tr>";

echo "<tr><td>Erster Rabatt</td>"; 
echo "<td><input type = 'text' size = '5' name = 'RabattOne' value='" . $zeile["RabattOne"] . "'>%</td></tr>";

echo "<tr><td>Zweiter Rabatt</td>"; 
echo "<td><input type = 'text' size = '5' name = 'RabattTwo' value='" . $zeile["RabattTwo"] . "'>%</td></tr>";

echo "<tr><td>Dritter Rabatt</td>"; 
echo "<td><input type = 'text' size = '5' name = 'RabattThree' value='" . $zeile["RabattThree"] . "'>%</td></tr>";

echo "<tr><td>Beschreibung der Rabatte</td>";
echo "<td>" . "<textarea rows='5' name='BeschrRabatte' cols = '27'>" . $zeile["BeschrRabatte"] .  "</textarea>" . "</td></tr>";

echo "<tr><td>Preis(Pro Monat):</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Preis' value='" . $zeile["Preis"] . "'></td></tr>";

// Hier wird der tatsächliche Preis angezeigt
echo "<tr><td>Rabattierter Preis</td>";
$Preis = $zeile["Preis"];
$Rabatt1 = $zeile["RabattOne"];
$Rabatt2 = $zeile["RabattTwo"];
$Rabatt3 = $zeile["RabattThree"];
$PreisMitRabatt = $Preis - (($Preis/100)*$Rabatt1);
$PreisMitRabatt = $PreisMitRabatt - (($PreisMitRabatt/100)*$Rabatt2);
$PreisMitRabatt = $PreisMitRabatt - (($PreisMitRabatt/100)*$Rabatt3);
echo "<td>" . $PreisMitRabatt . "</td></tr>";

echo "<tr><td>Zahlungsfrist (in Tagen):</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Frist' value='" . $zeile["Frist"] . "'></td></tr>";

echo "<tr><td>Zahlungsperiode<br>(In Monaten):</td>"; 
echo "<td><input type = 'text' size = '20' name = 'Periode' value='" . $zeile["Periode"] . "'></td></tr>";


echo "<tr><td>Aktivierungsdatum des Servers: </td>"; 
$ErstePeriode = HoleSQLDatum($zeile, "ErstePeriode");
echo "<td>";
echo $ErstePeriode[tag] . "." . $ErstePeriode[monat] . "." . $ErstePeriode[jahr];
echo "</td></tr>";

echo "<tr><td>Laufende(s) Spiel(e): </td>"; 
echo "<td><input type = 'text' size = '20' name = 'aktSpiel' value='" . $zeile["AktSpiel"] . "'></td></tr>";

// Alle Einträge der Clan-Tabelle durchlaufen und in einem Pulldown-Menü anzeigen
echo "<tr><td>Server geh&ouml;rt zu<br>folgendem Clan:</td>"; 
$sqlc = "SELECT * FROM clans";
$resultc = mysql_query($sqlc);
echo "<td><select name='ClanID'>";
while($zeilec = mysql_fetch_array($resultc))
{
  if ($zeilec["Nummer"] == $zeile["ClanID"])
    echo "<option value='" . $zeilec["Nummer"] . "' selected='selected'>" . $zeilec["Clanname"] . "</option>";
  else
    echo "<option value='" . $zeilec["Nummer"] . "'>" . $zeilec["Clanname"] . "</option>";
}
echo "</select></td></tr>";

echo "</table></center>";


echo "<center><table border='0'>";
echo "<tr><td><input type ='submit' value='&Auml;nderungen speichern'></form></td></tr>";
echo "</table></center>";

include('util/footer.php');
?>
