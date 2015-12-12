<?php
include('util/header.php');
include('util/dblogin.php');

// F E H L E R B E H A N D L U N G
// Prüfen, ob Kundennummer eingegeben
if (!$_POST["Nummer"])
  die("<center><br><br>Die Kundennummer muss angegeben werden<br>Bitte klicken Sie auf zur&uuml;ck im Browser, um die Kundennummer anzugeben");
// Prüfen, ob Kundennummer nicht schon existiert
$sqlnummer = "SELECT * FROM clans WHERE Nummer='" . $_POST["Nummer"] ."'";
$resultnummer = mysql_query($sqlnummer);
if ($zeilenummer = mysql_fetch_array($resultnummer))
  die("<center><br><br>Tut uns leid, die Kundennummer existiert bereits<br>Bitte geben Sie eine andere Kundennummer an</center>");
// H A U P T T E I L
// Einfügen
$sql = "INSERT INTO clans(Clanname, Kontakt, Adresse, PLZ, Ort, Telefon, Mail, Nummer)";
$sql .= " VALUES (" . "'" . $_POST["Clanname"] . "'";
$sql .= ", '" . $_POST["Kontakt"] ."'";
$sql .= ", '" . $_POST["Adresse"] ."'";
$sql .= ", '" . $_POST["PLZ"] ."'";
$sql .= ", '" . $_POST["Ort"] ."'";
$sql .= ", '" . $_POST["Telefon"] ."'";
$sql .= ", '" . $_POST["Mail"] ."'";
$sql .= ", '" . $_POST["Nummer"] ."')";
$result = mysql_query($sql);
echo "<center><b>Neuer Clan wurde eingetragen</b>";

// Menü-Zeugs anzeigen
echo "<form method = 'POST' action='index.php'>";
echo "<input type = 'submit' value='Hauptmen&uuml;'></form><br><br>";

echo "<form method = 'POST' action='neuerclan.php'>";
echo "<input type = 'submit' value='Weiteren Clan eintragen'></form>";

echo "<font face='arial' size= '1'><br><br><br>Befehl: <b>" . $sql . "</b> in Datenbank a&uuml;sgeführt<br><br></font>";

echo "</center>";

include('util/footer.php');
?>
