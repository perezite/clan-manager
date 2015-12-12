<?php
include('util/header.php');
include('util/dblogin.php');
include('util/function.php');

// F E H L E R B E H A N D L U N G
// Prüfen, ob Zahlungsperiode > 0
if ($_POST["Periode"]<= 0 || !$_POST["Periode"])
{
  echo "<center>Es wurde eine ung&uuml;ltige Zahlungsperiode angegeben.";
  echo "<br>Bitte klicken Sie auf den Zur&uuml;ck-Button des Browsers und &auml;ndern Sie die Zahlungsperiode</center>";
  die();
}

// T A G   B E R E C H N E N / H O L E N
echo "<br><br>";
if ($_POST["tag"] && $_POST["monat"] && $_POST["jahr"])
{
  $datum = $_POST["jahr"] . "-" . $_POST["monat"] . "-" . $_POST["tag"];
}
else
{
  // Heutigs Datum holen und in SQL-Format umwandeln
  $heute = HoleBankDatum(false);
  $heute_sql = $heute[jahr] . "-" . $heute[monat] . "-" . $heute[tag];  
  echo $heute_sql;
  $datum = $heute_sql;
}

// H A U P T T E I L
$sql = "INSERT INTO `servers` (`Serverart`, `BeschrServer`, `IP`, `Slots`, `bPublic`, `Voice`, `Werbung`, `RabattOne`, `RabattTwo`, `RabattThree`, `BeschrRabatte`, `Preis`, `Frist`, `Periode`, `bDeleted`, `ClanID`, `bActive`, `AktRechnung`, `AktRechnungMarkiert`, `AktSpiel`, `LetztePeriode`, `ErstePeriode`)"; 
$sql .= " VALUES (" . "'" . $_POST["Serverart"] . "'";
$sql .= ", '" . $_POST["BeschrServer"] . "'";
$sql .= ", '" . $_POST["IP"] . "'";
$sql .= ", '" . $_POST["Slots"] . "'";
$sql .= ", '" . $_POST["bPublic"] . "'";
$sql .= ", '" . $_POST["Voice"] . "'";
$sql .= ", '" . $_POST["Werbung"] . "'";
$sql .= ", '" . $_POST["RabattOne"] . "'";
$sql .= ", '" . $_POST["RabattTwo"] . "'";
$sql .= ", '" . $_POST["RabattThree"] . "'";
$sql .= ", '" . $_POST["BeschrRabatte"] . "'";
$sql .= ", '" . $_POST["Preis"] ."'";
$sql .= ", '" . $_POST["Frist"] . "'";
$sql .= ", '" . $_POST["Periode"] . "'";
$sql .= ", '0'"; // bDeleted
$sql .= ", '" . $_POST["ClanID"] . "'";
$sql .= ", '1'"; // bActive
$sql .= ", '0'"; // AktRechnung
$sql .= ", '0'"; // AktRechnungMarkiert
$sql .= ", '" . $_POST["AktSpiel"] . "'";
$sql .= ", '" . $datum . "'"; // LetztePeriode
$sql .= ", '" . $datum . "'"; // Erste Periode
$sql .= ")";
$result = mysql_query($sql);
echo "<center><b>Neuer Server wurde eingetragen</b>";

echo "<form method = 'POST' action='index.php'>";
echo "<input type = 'submit' value='Hauptmen&uuml;'></form><br><br>";

echo "<form method = 'POST' action='neuerserver.php?ClanID=" . $_POST["ClanID"] . "'>";
echo "<input type = 'submit' value='Weiteren Server eintragen'></form>";

echo "<font face='arial' size= '1'><br><br><br>Befehl: <b>" . $sql . "</b> in Datenbank ausgef&uuml;hrt<br><br></font>";

echo "</center>";

include('util/footer.php');
?>
