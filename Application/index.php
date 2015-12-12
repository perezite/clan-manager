<?php
include('util/header.php');
include('util/dblogin.php');
include('util/function.php');

// G E T / P O S T - D A T E N  P A R S E N
// PHP_SELF: Klar...
$PHP_SELF = $_SERVER["PHP_SELF"];
// WelcheZahlung: Gibt an, zu welcher Zahlung $Abstand berechnet werden soll
if (!$_GET["welchezahlung"])
  $WelcheZahlung = 1;
else
  $WelcheZahlung = $_GET["welchezahlung"];
// Abstand: Variable, die angibt, wie gross der Abstand von heute bis zur nächsten Serverzahlung max. sein darf 
if (!$_GET["abstand"])
  $Abstand = 0;
else
  $Abstand = $_GET["abstand"];
// Negativ: Falls aktiviert, wird $Abstand negiert
if ($_GET["negativ"])
  $Abstand = -$Abstand;
// NurAbstand: Entweder 0 (Alle im Abstand von $Abstand und kleiner anzeigen) oder 1 (Nur alle mit $Abstand anzeigen)
if (!$_GET["nurabstand"])
  $NurAbstand = 0;
else
  $NurAbstand = $_GET["nurabstand"];
// ShowDel: 1 = Nur gelöschte Server anzeigen, 0 = Nur nicht gelöschte Server anzeigen
if (!$_GET["showdel"])
  $ShowDel = 0;
else
  $ShowDel = $_GET["showdel"];
// searchKontakt: Suchen nach Clan mit diesem Kontakt
$searchKontakt = $_GET["kontakt"];
// searchNummer: Suchen nach Clan mit dieser Kundennummer
$searchNummer = $_GET["nummer"];

// O P T I O N E N
// Datum von heute holen
$heute = HoleBankDatum(true);
// Auswahl des maximalen Abstandes
echo "<form method ='POST' action='index.php'>";
echo "";
echo "</form>";


// H A U P T T E I L

// SUCHFUNKTIONEN
// Nur Server in bestimmtem Abstand
echo "<table border='0'>";
echo "<td><form method ='GET' action='index.php'>";
echo "Alle Server mit der ";
echo "<select name='welchezahlung'>";
  echo "<option value='1' selected='selected'>1. Rechnung</option>";
  echo "<option value='2'>1. Mahnung</option>";
  echo "<option value='3'>2. Mahnung</option>";
  echo "<option value='4'>beliebigen</option>";
echo "</select> ";
echo "<select name='nurabstand'>";
  echo "<option value='0' selected='selected'>bis</option>";
  echo "<option value='1'>genau</option>";
echo "</select>";
echo " <select name='negativ'>";
  echo "<option value='0' selected='selected'>in</option>";
  echo "<option value='1'>vor</option>";
echo "</select>";
echo " <input type ='text' name='abstand' value='0' size ='2'>";
echo " Tagen ";
echo " <input type ='submit' value='Anzeigen'>";
echo "</form></td>";
echo "<td><form method = 'GET' action='index.php'>";
echo "...<input type ='hidden' name='abstand' value='0'>";
echo "<input type ='submit' value ='Alle anzeigen'>";
echo "</form></td>";
// Suchfunktion nach Kontaktname
echo "<tr><td><form method ='GET' action='index.php'>";
echo "<input type = 'text' name='kontakt' value=''>";
echo "  <input type = 'submit' value='Nach Clan-Kontakt suchen'>";
echo "</form>";
echo "</td></tr>";
// Suchfunktion nach Kundennummer
echo "<tr><td><form method ='GET' action='index.php'>";
echo "<input type = 'text' name='nummer' value=''>";
echo "  <input type = 'submit' value='Nach Clan-Nummer suchen'>";
echo "</form>";
echo "</td></tr>";

echo "</table>";

// SQL-BEFEHL generieren
$sqlc = "SELECT * FROM clans";
if($searchNummer)
  $sqlc = "SELECT * FROM clans WHERE Nummer='" . $searchNummer . "'";
if($searchKontakt)
  $sqlc = "SELECT * FROM clans WHERE Kontakt LIKE '%" . $searchKontakt . "%'";

$resultc = mysql_query($sqlc);

echo "<br><br>";
// K O P F Z E I L E

echo "
<table border='1' align='center'>
  <tr>
	  <th bgcolor='#FFFFCC' width='30%'>Clanname</th>
	  <th bgcolor='#CCCCCC' width='30%'>Server</th>
	  <th bgcolor='#CCCFFF' width='60%'>Zahlung</th>
  <tr>
    <td>
	    <form method = 'POST' action = 'neuerclan.php'>
		  <input type = 'submit' value = 'Neuer Clan'>
	    </form>
    </td>
	  <td>
	    <form method = 'POST' action = 'neuerserver.php'>
		    <input type = 'submit' value = 'Neuer Server'>
	    </form>
    </td>
		<td><font size='1'><i>
			<ul>
				<li>Erstes Datum: Erste Rechnung<br>Zweites Datum: Erste Mahnung<br>Drittes Datum: Zweite Mahnung</li>
				<li>Grün: Erste Rechnung in Verzug<br>Orange: Erste Mahnung in Verzug<br>Rot: Zweite Mahnung in Verzug</li>
				<li>Markiertes Kästchen: Rechnung wurde verschickt</li>
			</ul>
		</i></font>
	</td>
  </tr>	
  <tr>
";

// Die Tabelle mit den Clans, Servern und Zahlungsdaten
while($zeilec = mysql_fetch_array($resultc))
{
    //----CLANNAME----
    // Prüfen, ob kein Clanname angegeben und Standard setzen
    if (!$zeilec["Clanname"])
      $zeilec["Clanname"]="[unnamed]";
    // Link für die Beschreibung des Clans
    echo "<td><a href = 'claninfo.php?id=" . $zeilec["Counter"] . "'>" . $zeilec["Clanname"];
    echo " (" . $zeilec["Nummer"] . ")"; 
    echo "</a>";
    // Link zum Löschen des Servers
    echo "<a href ='clandel.php?id=" . $zeilec["Nummer"] . "'>";
    echo "<img src ='pics/x.gif' border='0'>";
    echo "</a></td>";
    // Spacer
	  echo "<img src='pics/spacer.gif'>";
    //----SERVER----
    // Datenbankanfrage und Spacer+Tabelle
    $sqls = "SELECT * FROM servers WHERE ClanID = '" . $zeilec["Nummer"] . "'";
    $results = mysql_query($sqls);
    echo "<td align = 'right'><table border='0'>";
    // Alle Server anzeigen
    while ($zeiles = mysql_fetch_array($results))
    {
      // Nur anzeigen, falls (nicht) im Papierkorb
      if ($zeiles["bDeleted"]!=$ShowDel)
        continue;
      // Nur Zahlung anzeigen, falls Anzeige-Abstand nicht zu gross
      $abstand = PruefeAbstand($zeiles, $Abstand, $NurAbstand, $WelcheZahlung);
      if (!$abstand[$WelcheZahlung])
        continue;      
      // HTML (Falls inaktiv --> grau anzeigen)
      if ($zeiles["bActive"])
        echo "<tr><td height ='45' align = 'right'>";
      else
        echo "<tr><td bgcolor='#CCCCCC' height ='45' align = 'right'>";
      // Button zum aktivieren/deaktivieren des Servers
      if ($zeiles["bActive"])
        echo "<a href='savemark.php?action=2&counter=" . $zeiles["Counter"] . "' title='Server deaktivieren'><img src='pics/deakt.gif' border='0'></a>";
      else
        echo "<a href='savemark.php?action=3&counter=" . $zeiles["Counter"] . "' title='Server aktivieren'><img src='pics/akt.gif' border='1'></a>";      
      // Prüfen, ob keine Serverart angegeben und ggf. Standard-Name setzen
      if (!$zeiles["Serverart"])
        $zeiles["Serverart"]="[unnamed]";
      // ...Sonst normalen Link zeigen
      echo "<a href ='serverinfo.php?id=" . $zeiles["Counter"] . "'>";
      echo $zeiles["Serverart"];
      echo " (" . $zeiles["IP"] . ")";
      echo "</a>";
      // Link zum Löschen des Servers
      echo "<a href ='serverdel.php?id=" . $zeiles["Counter"] . "'>";
      echo "<img src ='pics/x.gif' border='0'>";
      echo "</a>";
      echo "</td></tr>";
    
    }
    echo "<img src='pics/spacer.gif'>";
    echo "</table></td>";
    
    //----ZAHLUNG----
    // Von allen Servern die Zahlungen anzeigen
    echo "<td align = 'right'><table border='0'>";
    $results = mysql_query($sqls);
    while ($zeiles = mysql_fetch_array($results))
    {
      // Nur anzeigen, falls nicht im Papierkorb
      if ($zeiles["bDeleted"]!=$ShowDel)
        continue;
      // Nur Zahlung anzeigen, falls Anzeige-Abstand nicht zu gross
      $abstand = PruefeAbstand($zeiles, $Abstand, $NurAbstand, $WelcheZahlung);
      if (!$abstand[$WelcheZahlung])
        continue;
      // HTML
      echo "<td height ='45'>";
      echo "<form method='POST' action='savemark.php?action=4'>";
      
      // Periode vom Server holen
      $periode[monat] = $zeiles["Periode"];  
      // 1) Datum für die 1te Rechnung anzeigen
      // Datum für die erste Rechnung = Startdatum der letzen Periode + $periode
      // Erst mal das Datum der letzen Periode holen
      $DatumLetztePeriode = HoleSQLDatum($zeiles, "LetztePeriode");
      // Periode zum letzten Rechnungsdatum dazurechnen --> Datum für erste Rechnung
      $DatumLetztePeriode[jahr] += $periode[jahr];            // Jahre
      $DatumLetztePeriode[monat] += $periode[monat];          // Monate
      $DatumLetztePeriode[tag] += $periode[tag];              // Tage
      $DatumLetztePeriode = KonvertiereDatum($DatumLetztePeriode);
      // Daten anzeigen und Rückgabewert speichern, ob die 1te Rechnung aktuell (Wenn 1te Rechnung aktuell, ist die ganze Zeile aktuell!) 
      $bAktuell = ZeigeDaten($zeiles, $DatumLetztePeriode, 1);
      // 2) Datum für die 1te Mahnung anzeigen
      $DatumLetztePeriode[tag] += $zeiles["Frist"];   // Zahlungsdatum für 1te Mahnung 
      $DatumLetztePeriode = KonvertiereDatum($DatumLetztePeriode);
      ZeigeDaten($zeiles, $DatumLetztePeriode, 2);
      // 3) Datum für die 2te Mahnung anzeigen
      $DatumLetztePeriode[tag] += 10;                 // Zahlungsfrist für 2te Mahnung ist immer 10 Tage nach erster Mahnung
      $DatumLetztePeriode = KonvertiereDatum($DatumLetztePeriode);
      ZeigeDaten($zeiles, $DatumLetztePeriode, 3);
      
      // HTML
      // Button für Notiz
      echo "<input type ='hidden' name='counter' value='" . $zeiles["Counter"] . "'>";
      echo "<td><input type ='submit' value='OK'></td>";
      echo "</form>";
      // Button für Rechnungsbstätigung (Nur anzeigen, wenn die Zeile aktuell ist)
      if ($bAktuell)
      {
          echo "<td><a href='savemark.php?counter=" . $zeiles["Counter"] . "&action=1'><img src='pics/bezahlt.gif' border='0' title='Als bezahlt markieren'></a></td>";
          echo "</form>";
      }
      else // Sonst Spacer anzeigen (Wegen Design)
      {
        echo "<td><img src='pics/bigspacer.gif'></td>";
      }
            
      echo "</td><tr>";
    }
    echo "<img src='pics/spacer.gif'>";
    echo "</table></td><tr>";
} // Ende while(zeilec = fetch_array())



echo "</table></tr>";
include('util/footer.php');
?>
