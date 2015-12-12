<?php
include('util/header.php');

echo "
<center>
<b>Neuen Clan eintragen</b><br><br>
<table border ='0'>
<form method ='POST' action='neuerclan1.php'>
<tr><td>Name des Clans:</td><td><input type='text' size='20' name='Clanname' value=''</td></tr>
<tr><td>Kontakt:</td><td><input type='text' size='20' name='Kontakt' value=''</td></tr>
<tr><td>Adresse des Kontakts:</td><td><textarea rows='4' cols='20' name='Adresse'></textarea></td></tr>
<tr><td>Postleitzahl:</td><td><input type='text' size='20' name='PLZ' value=''</td></tr>
<tr><td>Wohnort:</td><td><input type='text' size='20' name='Ort' value=''</td></tr>
<tr><td>Telefon:</td><td><input type='text' size='20' name='Telefon' value=''</td></tr>
<tr><td>E-Mail:</td><td><input type='text' size='20' name='Mail' value=''</td></tr>
<tr><td>Kundennummer:<br>(Muss angegeben werden)</td><td><input type='text' size='20' name='Nummer' value=''</td></tr>
</table>
<br>
<input type ='submit' value='OK'>
</form>
</center>
";

include('util/footer.php');
?>
