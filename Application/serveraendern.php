<?php
include('util/header.php');
include('util/dblogin.php');

// F E H L E R B E H A N D L U N G 
// Prüfen, ob ClanID eingegeben
if (!$_POST["ClanID"])
{
  $error = "<center><br><br>Fehler, es wurde keine Kundennummer f&uuml;r den Server angegeben!";
  $error .= "<br><form method = 'POST' action='serverinfo.php?id=" . $_POST["id"] . "'>";
  $error .= "<input type = 'submit' value='Zurück'></form>";
  die ($error);
}

// Prüfen, ob Kundennummer überhaupt existiert
$sqlnummer = "SELECT * FROM clans WHERE Nummer='" . $_POST["ClanID"] ."'";
$resultnummer = mysql_query($sqlnummer);
if (!$zeilenummer = mysql_fetch_array($resultnummer))
{
  $error = "<center><br><br>Problem:<br>Der angegebene Clan existiert nicht (mehr)!<br>Aktualisieren Sie alle Browser-Fenster und klicken Sie dann auf Zur&uuml;ck";
  $error .= "<br><form method = 'POST' action='serverinfo.php?id=" . $_POST["id"] . "'>";
  $error .= "<input type = 'submit' value='Zur&uuml;ck'></form>";
  die ($error);
}

// Prüfen, ob Zahlungsperiode > 0
if ($_POST["Periode"]<= 0 || !$_POST["Periode"])
{
  echo "<center>Es wurde eine ung&uuml;ltige Zahlungsperiode angegeben.";
  echo "<br>Bitte klicken Sie auf den Zur&uuml;ck-Button des Browsers und &auml;ndern Sie die Zahlungsperiode</center>";
  die();
}


// H A U P T T E I L
// Server-Daten updaten
$sql = "UPDATE servers SET ";
$sql .= "Serverart ='" . $_POST["Serverart"] . "', ";
$sql .= "BeschrServer ='" . $_POST["BeschrServer"] . "', ";
$sql .= "IP='" . $_POST["IP"] . "', ";
$sql .= "Slots='" . $_POST["Slots"] . "', ";
$sql .= "bPublic='" . $_POST["bPublic"] . "', ";
$sql .= "Voice='" . $_POST["Voice"] . "', ";
$sql .= "Werbung='" . $_POST["Werbung"] . "', ";
$sql .= "RabattOne='" . $_POST["RabattOne"] . "', ";
$sql .= "RabattTwo='" . $_POST["RabattTwo"] . "', "; 
$sql .= "RabattThree='" . $_POST["RabattThree"] . "', ";
$sql .= "BeschrRabatte='" . $_POST["BeschrRabatte"] . "', "; 
$sql .= "Preis='" . $_POST["Preis"] . "', "; 
$sql .= "Frist='" . $_POST["Frist"] . "', "; 
$sql .= "Periode='" . $_POST["Periode"] . "',";
$sql .= "ClanID='" . $_POST["ClanID"] . "', ";
$sql .= "aktSpiel='" . $_POST["aktSpiel"] . "'";
$sql .= " WHERE Counter='" . $_POST["id"] . "'";
$result = mysql_query($sql);

// Menü anzeigen
echo "<center><br><br><br><b>***&Auml;nderungen gespeichert***<br><br>";
echo "<br><a href = 'index.php'>Hauptmen&uuml;</a><br>";
echo "<br><a href = 'serverinfo.php?id=" . $_POST["id"] . "'>Noch etwas &auml;ndern</a><br>";
echo "<br>(Nicht den 'Zur&uumlck'-Button des Browsers verwenden!!)";
echo "<font face='arial' size='1'><br><br><br><br><br><br>Datenbank-Befehl: " . $sql . "<br></font></center>";

include('util/footer.php');
?>
