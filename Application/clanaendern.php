<?php
include('util/header.php');
include('util/dblogin.php');

// Prüfen, ob Kundennummer eingegeben
if (!$_POST["Nummer"])
  die("<center><br><br>Sie m&uuml;ssen eine Kundennummer angeben<br>Bitte klicken Sie auf zur&uuml;ck und tragen Sie eine Kundennummer ein<br><a href = 'claninfo.php?id=" . $_POST["id"] . "'>Zurück</a></center>");

// Prüfen, ob Kundennummer nicht schon existiert (Falls ja, nur Fehler wenn nicht die eigene Kundennummer)
$sqlnummer = "SELECT * FROM clans WHERE Nummer='" . $_POST["Nummer"] ."'";
$resultnummer = mysql_query($sqlnummer);
if ($zeilenummer = mysql_fetch_array($resultnummer))
{
  if ($zeilenummer["Nummer"] != $_POST["NummerAlt"])
  {
    die("<center><br><br>Tut uns leid, die angegebene Kundennummer existiert schon,<br>Bitte geben Sie eine andere Kundennummer an<br><a href = 'claninfo.php?id=" . $_POST["id"] . "'>Zurück</a></center>");
  }
}

// Bei allen Servers dieses Clans die neue ClanID eintragen
$sqls = "UPDATE servers SET ClanID='" . $_POST["Nummer"] . "' WHERE ClanID='" . $_POST["NummerAlt"] . "'";
mysql_query($sqls);

// Clan-Daten updaten
$sql = "UPDATE clans SET ";
$sql .= "Clanname='" . $_POST["Clanname"] . "', ";
$sql .= "Kontakt='" . $_POST["Kontakt"] . "', ";
$sql .= "Adresse='" . $_POST["Adresse"] . "', ";
$sql .= "PLZ='" . $_POST["PLZ"] . "', ";
$sql .= "Ort='" . $_POST["Ort"] . "', ";
$sql .= "Telefon='" . $_POST["Telefon"] . "', ";
$sql .= "Mail='" . $_POST["Mail"] . "', ";
$sql .= "Nummer='" . $_POST["Nummer"] . "'"; 
$sql .= " WHERE Counter='" . $_POST["id"] . "'";
$result = mysql_query($sql);

// Menü anzeigen
echo "<center><br><br><br><b>***&Auml;nderungen gespeichert***<br><br>";
echo "<br><a href = 'index.php'>Hauptmen&uuml;</a><br>";
echo "<br><a href = 'claninfo.php?id=" . $_POST["id"] . "'>Noch etwas &auml;ndern</a><br>";
echo "<br>(Nicht den 'Zur&uuml;ck'-Button des Browsers verwenden!!)";
echo "<font face='arial' size='1'><br><br><br><br><br><br>Datenbank-Befehl: " . $sql . "<br></font>";
echo "<font face='arial' size='1'>Datenbank-Befehl: " . $sqls . "</font></center>";

include('util/footer.php');
?>
