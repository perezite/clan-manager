<?php
include('util/header.php');
include('util/dblogin.php');
include('util/function.php');

// 1. Link für Rechnungs-Bestätigung
if ($_GET["action"]==1)
{
  if (!$_GET["counter"])
    die("<center>Fehler, falscher Parameter</center>");
  $counter = $_GET["counter"];
  $sql = "SELECT * FROM servers WHERE Counter='" . $counter . "'";
  $result = mysql_query($sql);
  $zeile = mysql_fetch_array($result);
  // Das Feld LetztePeriode um eine Periode raufsetzen
  $DatumLetztePeriode = explode("-", $zeile["LetztePeriode"]);
  $DatumLetztePeriode[jahr] = $DatumLetztePeriode[0];
  $DatumLetztePeriode[monat] = $DatumLetztePeriode[1];
  $DatumLetztePeriode[tag] = $DatumLetztePeriode[2];
  $DatumNeuePeriode = $DatumLetztePeriode;
  $DatumNeuePeriode[tag] += ($zeile["Periode"])*30;
  $DatumNeuePeriode = KonvertiereDatum($DatumNeuePeriode);
  // Jetzt die neue Periode in LetzePeriode eintragen
  $DatumNeuePeriode_sql = $DatumNeuePeriode[jahr] . "-" . $DatumNeuePeriode[monat] . "-" .$DatumNeuePeriode[tag];
  $sql = "UPDATE servers SET LetztePeriode='" . $DatumNeuePeriode_sql ."' WHERE Counter='" . $counter . "'";
  $result = mysql_query($sql);
}

// 2. Deaktivieren des Servers
if ($_GET["action"]==2)
{
  if (!$_GET["counter"])
    die("<center>Fehler, falscher Parameter</center>");
  $counter = $_GET["counter"];
  // Server deaktivieren 
  $sql = "UPDATE servers SET bActive='0' WHERE Counter='" . $counter . "'";
  $result = mysql_query($sql);
}

// 3. Aktivieren des Servers
if ($_GET["action"]==3)
{
  if (!$_GET["counter"])
    die("<center>Fehler, falscher Parameter</center>");
  $counter = $_GET["counter"];
  // ---Server aktivieren---
  $sql = "UPDATE servers SET bActive='1' WHERE Counter='" . $counter . "'";
  $result = mysql_query($sql);
  // ---Erste Periode und LetztePeriode auf heute setzen---
  // Datum holen
  /*$heute = HoleBankDatum(false);
  $heute_sql = $heute[jahr] . "-" . $heute[monat] . "-" . $heute[tag];
  $sql = "UPDATE servers SET ErstePeriode='" . $heute_sql . "' WHERE Counter = '" . $counter . "'";
  $result = mysql_query($sql);
  $sql = "UPDATE servers SET LetztePeriode='" . $heute_sql . "' WHERE Counter = '" . $counter . "'"; 
  $result = mysql_query($sql);*/
}

// 4. Button für Ändern der Notiz
if ($_GET["action"]==4)
{
  $z1 = $_POST["Zahlung1"];
  $z2 = $_POST["Zahlung2"];
  $z3 = $_POST["Zahlung3"];
  // Wenn ein Kästchen aktiviert(Eine Rechnung verschickt) --> Alle vorherigen Rechnungen wurden auch schon verschickt
  if ($z1)
    $AktRechnungMarkiert = 1;
  if ($z2)
    $AktRechnungMarkiert = 2;
  if ($z3)
    $AktRechnungMarkiert = 3;
  if ((!$z1) && (!$z2) && (!$z3))
    $AktRechnungMarkiert = 0;
  // Prüfen, ob ein Kästchen aktiviert wurde, und eines/mehrere vorher nicht aktiviert wurden
  if (($z3 && !$z2) || ($z3 && !$z2) || ($z2 && !$z1))
    die("<center>Fehler, die Daten wurden in einer falschen Reihenfolge angegeben</center>");
    
  $counter = $_POST["counter"];
  $sql = "UPDATE servers SET AktRechnungMarkiert='" . $AktRechnungMarkiert . "' WHERE Counter='" . $counter . "'";
  mysql_query($sql);
}

// Zurückleiten auf Hauptseite
$referer = "Location: ";
$referer .= $_SERVER["HTTP_REFERER"];
Header($referer);


include('util/footer.php');
?>
