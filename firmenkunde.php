<?php
    // Kundenübersicht abrufen
    require_once('includes/bank.inc.php');
    require_once('includes/kunde.inc.php');
    require_once('includes/adresse.inc.php');
?>

<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
    <div class="row-2">
        <div class="col-3 col-s-3 col-3-text">
            <h2>Menu</h2>
            <p>
                <ul>
                    <li><a href="uebersicht.php" class="menu-link">Kundenübersicht</a></li>
                    <li><a href="privatkunde.php" class="menu-link">Privatkunde anlegen</a></li>
                    <li><a href="firmenkunde.php" class="menu-link">Firmenkunde anlegen</a></li>
                    <li><a href="konto.php" class="menu-link">Konto hinzufügen</a></li>
                    <li><a href="einzahlen.php" class="menu-link">Konto einzahlen</a></li>
                    <li><a href="abheben.php" class="menu-link">Konto abheben</a></li>
                    <li><a href="aufladen.php" class="menu-link">Kreditkarte aufladen</a></li>
                    <li><a href="bezahlen.php" class="menu-link">Kreditkarte bezahlen</a></li>
                </ul>
            </p>
        </div>
		    <div class="col-9 col-9-text">
                <h2>Kundenübersicht FAW Bank</h2>
                <h3>Firmenkunden anlegen</h3>
                <form id="privatanlegen" action="firmenkunde.php" method="post">
                    <label for="text">Name: </label><input type="text" id="name" name="name" placeholder="" required><br>
                    <label for="text">Vorname: </label><input type="text" id="vorname" name="vorname" placeholder="" required><br>
                    <label for="text">Straße: </label><input type="text" id="strasse" name="strasse" placeholder="" required><br>
                    <label for="text">Haus-Nr.: </label><input type="text" id="hausnummer" name="hausnummer" placeholder="" required><br>
                    <label for="text">PLZ: </label><input type="text" id="plz" name="plz" placeholder="00000" required><br>
                    <label for="text">Stadt: </label><input type="text" id="stadt" name="stadt" placeholder="" required><br>
                    <input type="submit" name="kundeanlegen" value="Kunde anlegen">
                </form><br>
                <p class="col-9-kundenbereich">                
                    <?php
                    // Anlegen des Kunden
                    if(isset($_POST['kundeanlegen']) && strlen($_POST['name']) > 0){
                        // Erstellen einer Adresse, damit die Klasse auch mal genutzt wird
                        $adresse = new Adresse($_POST['strasse'], $_POST['hausnummer'], $_POST['plz'], $_POST['stadt']);
                        // Kunde wird mit den Daten hinzugefügt
                        $fawBank->kunden_hinzufügen($_POST['name'], $_POST['vorname'], $adresse->strasse, $adresse->hausnummer, $adresse->plz, $adresse->stadt, "Firmenkunde");
                    }
                    // Abfangen von zu kurzen oder zu langen Kontonummern bzw. Fehlerausgabe
                    elseif (isset($_POST['kundeanlegen']) && strlen($_POST['name']) <= 0){
                        echo "<font color=\"red\">Kein Name eingegeben.</font>";
                    }
                    ?>
            </div>
	    </div>
    </body>
</html>