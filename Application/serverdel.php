<?php
include('util/header.php');

echo "<br><br><center>Server wirklich l&ouml;schen?<br><br>";
echo "<form method = 'GET' action='serverdel1.php'>";
echo "<input type = 'hidden' name='id' value='" . $_GET["id"] . "'>";
echo "<input type = 'submit' value='Ja, definitiv l&ouml;schen!'>";
echo "<br><br> (Klicken Sie auf den Zur&uuml;ck-Button des Browsers, um abzubrechen)";
echo "</form>";

include('util/footer.php');
?>
