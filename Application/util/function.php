<?php


// Holt ein Datum aus dem SQL-Datensatz $Datensatz im Feld $Feld ($Feld als String übergeben!!!)
function HoleSQLDatum($Datensatz, $Feld)
{
  $temp = $Datensatz[$Feld];
  $Datum = explode("-", $temp);
  // Array-Felder in verständlicheren Feldnamen speichern
  $Datum[jahr] = $Datum[0];
  $Datum[monat] = $Datum[1];
  $Datum[tag] = $Datum[2];

  return $Datum;
}

// Holt das Datum mit 30-tägigen Monaten
function HoleBankDatum($ZeigeDatum)
{
$datum[tag] = date("d");
$datum[monat] = date("m");
$datum[jahr]= date("Y");
// Bank-Datum
if ($datum[tag]>30)
  $datum[tag] = 30;
// Datum anzeigen, falls gewünscht
if ($ZeigeDatum)
  echo "<b>Heutiges Datum (Bankdatum): " . $datum[tag] . "." . $datum[monat] . "." . $datum[jahr] . "</b>";

return $datum;
}

// Wandelt ein Datum mit zu hohen Werten für Tag und/oder Monat in die richtigen Werte um
// Datumsformat: [0]=jjjj, [1]=mm, [2]=tt (Monate sind 30-tägig)
function KonvertiereDatum($Datum)
{
  if($Datum[tag]!=30)
  {
    $Datum[monat] += floor($Datum[tag]/30);
    $Datum[tag] = $Datum[tag]%30;
    if ($Datum[tag]==0)
    {
      $Datum[tag]=30;
      $Datum[monat]--;
    }
  }
  if($Datum[monat]!=12)
  {
    $Datum[jahr] += floor($Datum[monat]/12);
    $Datum[monat] = $Datum[monat]%12;
  }
  return $Datum;
}

// Prüft, ob das erste Datum grösser/gleich als/wie das zweite ist und gibt ggf. 1 zurück, sonst 0
function VergleicheDaten($datum1, $datum2)
{
  if ($datum2[jahr]>$datum1[jahr])
    return 0;
  if ($datum2[jahr]<$datum1[jahr])
    return 1;
  if ($datum2[jahr]==$datum1[jahr])
  {
    if ($datum2[monat]>$datum1[monat])
      return 0;
    if ($datum2[monat]<$datum1[monat])
      return 1;
    if ($datum2[monat]==$datum1[monat])
    {
      if ($datum2[tag]>$datum1[tag])
        return 0;
      if ($datum2[tag]<$datum1[tag])
        return 1;
      if ($datum2[tag]==$datum1[tag])
        return 1;    
    }
  }
}

// Rechnet, wie viele Tage von $datum1 bis $datum2 vergehen (Bankdatum)
function DifferenzDaten($datum1, $datum2)
{
  $diff=(($datum2[jahr])-($datum1[jahr]))*360;
  $diff += ($datum2[monat]-$datum1[monat])*30;
  $diff += ($datum2[tag]-$datum1[tag]);
  return $diff;
}

// Wird von PruefeAbstand() aufgerufen: Prüft, ob $Datum bezüglich der Parameter
// $Abstand und $NurAbstand aktuell ist
// Rückgabe: true, falls $Datum bezüglich $Abstand und $NurAbstand aktuell; sonst false
function PruefeObAktuell($Datum, $Abstand, $NurAbstand)
{
  // Datum von heute holen
  $heute = HoleBankDatum(false);
  // ...1. Möglichkeit, wenn kein Abstands-Parameter --> alles zeigen
  if ($Abstand == 0)
    return true;
  // ...2. Möglichkeit, wenn nur Daten in diesem Abstand erlaubt ($NurAbstand ist gesetzt)
  if ($NurAbstand)
  {
    if (DifferenzDaten($heute, $Datum)==$Abstand)
      return true;
    else
      return false;
  }
  // ...3. Möglichkeit, wenn auch Daten in kleinerem Abstand erlaubt ($NurAbstand nicht gesetzt)
  if (!$NurAbstand)
  {
    // 1. Falls $Abstand positiv aber DifferenzDaten negativ (oder umgek.)--> Abstand ist sicher zu gross
    if (($Abstand>0) && (DifferenzDaten($heute, $Datum)<0))
      return false;
    if (($Abstand<0) && (DifferenzDaten($heute, $Datum)>0))
      return false;
    // 2. Sonst prüfen ...
    // ...für positiven $Abstand
    if ($Abstand>0)
    {
      if ($diff = DifferenzDaten($heute, $Datum)<=$Abstand)
      {
        return true; 
      }
      else
        return false;
    }
    // ... für negativen Abstand
    if ($Abstand<0)
    {
      if ($diff = DifferenzDaten($heute, $Datum)>=$Abstand)
        return true; 
      else
        return false;
    }
  } 
}

// Prüft, ob der Abstand einer Rechnung bis zu heute zu gross ist (Gibt 0 zurück, falls zu gross, 1 falls OK)
// $i gibt an, dass der Abstand zur 1.Rechnung ($i=1), der 1.Mahnung ($i=2) oder der 2.Mahnung ($i=3) geprüft wird.
// Parameter: $Abstand: Der vom User gewünschte maximale Abstand zw. heute und den angezeigten Daten
// $NurAbstand(bool): true, falls gewünscht, dass nur Produkte in GENAU dem Abstand $Abstand angezeigt werden
// $i: Der Abstand zu welcher Zahlung ist gesucht ? 
// Rückgabe: Array (0=1te Zahlung...); Einzelne Felder: false = Zahlung nicht aktuell, true = Zahlung aktuell
function PruefeAbstand($zeiles, $Abstand, $NurAbstand)
{
  $heute = HoleBankDatum(false);
  // Erstmal Periode vom Server holen
  $periode[monat] = $zeiles["Periode"];
  $periode = KonvertiereDatum($periode);  
  // Letzte Zahlungsperiode des Servers holen
  $Datum[1]=HoleSQLDatum($zeiles, "LetztePeriode");
  // 1te Rechnung
  $Datum[1][jahr] += $periode[jahr];     // Jahre
  $Datum[1][monat] += $periode[monat];    // Monate
  $Datum[1][tag] += $periode[tag];      // Tage
  $Datum[1] = KonvertiereDatum($Datum[1]);
  // 1te Mahnung
  $Datum[2] = $Datum[1];
  $Datum[2][tag] += $zeiles["Frist"];
  $Datum[2] = KonvertiereDatum($Datum[2]);
  // 2te Mahnung
  $Datum[3] = $Datum[2];
  $Datum[3][tag] += 10;
  $Datum[3] = KonvertiereDatum($Datum[3]);
  
  // Array erstellen
  for ($i = 1; $i < 4; $i++)
  {
    if ($back = PruefeObAktuell($Datum[$i], $Abstand, $NurAbstand))
      $ret[$i]= true;
    else
      $ret[$i] = false;
  }
  // Falls eine beliebige Rechnung aktuell sein und dies auch der Fall ist, 
  // wird der index 4 auf true gesetzt
  if ($ret[1] || $ret[2] || $ret[3])
    $ret[4] = true;
    
  return $ret;

}

// Zeigt die $ite Zahlung an und färbt sie passend ein
// Parameter: $zeiles = Datensatz des Servers, $DatumLetztePeriode = Anzuzeigendes Datum
// $i = $ite Zahlung, $heute = Datum von heute
function ZeigeDaten($zeiles, $Datum, $i)
{
  // Datum von heute holen
  $heute = HoleBankDatum(false);
  // Rückgabe-Wert: Gibt an, ob eine der Zahlungen aktuell ist
  $ret = false;
  // Falls bereits aktuelle Zahlung --> Zahlung mit passender Farbe anzeigen ...
  if (VergleicheDaten($heute, $Datum))
  {
    // Wenn eine Zahlung aktuell ist, dann ist ganze Zeile aktuell
    $ret = true;
    // 1.Rechnung
    if ($i==1)    
      $farbe = "green";
    // 1.Mahnung
    if ($i==2)
      $farbe = "orange";
    // 2.Mahnung
    if ($i==3)
      $farbe = "red";
    // Wenn Server inaktiv --> alles grau hinterlegen
    if (!$zeiles["bActive"])
      $farbe = "#CCCCCC";
    // Zelle mit der gesetzen Farbe anzeigen
    echo "<td bgcolor='" . $farbe . "'>";
  }
  // ... sonst keine Farbe, da noch nicht aktuell (Ausser wenn inaktiv --> dann grau) 
  else if ($zeiles["bActive"])
    echo "<td>";
  else
    echo "<td bgcolor='#CCCCCC'>";
  // Datum anzeigen
  echo " " . $Datum[tag] . "." . $Datum[monat] . "." . $Datum[jahr];
  // Checkboxes setzen
  if ($zeiles["AktRechnungMarkiert"]>=$i)
    echo "<input type ='checkbox' name='Zahlung" . $i . "' checked='checked' value='ON'>";
  else
    echo "<input type ='checkbox' name='Zahlung" . $i . "' value='OFF'>";
  echo "</td>"; 
  // Falls Server inaktiv --> Nie aktuell
  if (!$zeiles["bActive"])
    $ret = false;
  return $ret;
}


?>
