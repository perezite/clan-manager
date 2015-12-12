<?php
include('util/header.php');
include('util/dblogin.php');

echo "
<center>
<b>Neuen Server eintragen</b><br><br>
<table border ='0'>
<form method ='POST' action='neuerserver1.php'>";

// Alle Einträge der Clan-Tabelle durchlaufen und in einem Pulldown-Menü anzeigen
echo "<tr><td>Server geh&ouml;rt zu<br>folgendem Clan:</td>"; 
$sql = "SELECT * FROM clans";
$result = mysql_query($sql);
echo "<td><select name='ClanID'>";
while($zeile = mysql_fetch_array($result))
{
  echo $zeile["Clanname"];
  echo "<option value='" . $zeile["Nummer"] . "'>" . $zeile["Clanname"] . "</option>";
  }
echo "</select></td></tr>";

echo "<tr><td>Art des Servers:</td><td><input type='text' size='20' name='Serverart' value=''</td></tr>
<tr><td>Beschreibung des Servers:</td><td><textarea rows='4' cols='20' name='BeschrServer'></textarea></td></tr>
<tr><td>IP des Servers:</td><td><input type='text' size='20' name='IP' value=''</td></tr>
<tr><td>Anzahl Slots:</td><td><input type='text' size='20' name='Slots' value=''</td></tr>
<tr><td>Public/Clan</td><td><select name='bPublic'>
  <option value='1' selected='selected'>Public</option>
  <option value='0'>Clan</option>
</select></tr></td>
<tr><td>Voice-Server:<br>(Leer lassen, falls keiner)</td><td><input type='text' size='20' name='Voice' value=''</td></tr>
<tr><td>Werbung:</td><td><input type='text' size='20' name='Werbung' value=''</td></tr>
<tr><td>Erster Rabatt:</td><td><input type='text' size='4' name='RabattOne' value=''>%</td></tr>
<tr><td>Zweiter Rabatt:</td><td><input type='text' size='4' name='RabattTwo' value=''>%</td></tr>
<tr><td>Dritter Rabatt:</td><td><input type='text' size='4' name='RabattThree' value=''>%</td></tr>
<tr><td>Beschreibung der Rabatte:</td><td><textarea rows='4' cols='20' name='BeschrRabatte'></textarea></td></tr>
<tr><td>Server-Preis (Pro Monat):</td><td><input type='text' size='20' name='Preis' value=''</td></tr>
<tr><td>Zahlungsfrist (in Tagen):</td><td><input type='text' size='20' name='Frist' value=''</td></tr>
<tr><td>Zahlungsperiode (In Monaten):</td><td><input type='text' size='20' name='Periode' value=''</td></tr>
<tr><td>Laufende(s) Spiel(e):</td><td><input type='text' size='20' name='AktSpiel' value=''</td></tr>
<tr><td>Aktivierungsdatum(tt.mm.jjjj) <br> (Leer lassen f&uuml;r heute):</td><td>
  <input type='text' size='2' name='tag' value=''</td>
  <input type='text' size='2' name='monat' value=''</td>
  <input type='text' size='4' name='jahr' value=''</td>
</table>
<br>
<input type ='submit' value='OK'>
</form>
</center>
";

include('util/footer.php');
?>
