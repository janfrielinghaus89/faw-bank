<?php
    // Kundenübersicht abrufen
    require_once('includes/bank.inc.php');
    require_once('includes/kunde.inc.php');
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
                <h3>Konto für Kunden je Kundennummer eingeben</h3>
                <form id="privatanlegen" action="konto.php" method="post">
                    <label for="text">KundenID: </label><input type="text" id="kundenid" name="kundenid" placeholder="" required><br>
                    <label for="text">Kontonummer: </label>Wird automatisch ausgefüllt<br>
                    <label for="text">Kartennummer: </label>Wird automatisch ausgefüllt<br>
                    <label for="text">Kartenlimit: </label><input type="text" id="kartenlimit" name="kartenlimit" placeholder=""><br>
                    <input type="submit" name="kontoanlegen" value="Konto anlegen">
                </form><br>
                <p class="col-9-kundenbereich">
                    <?php
                    // Aufruf der Suchen-Funktion, falls diese ausgelöst wurde
                    if(isset($_POST['kontoanlegen']) && strlen($_POST['kundenid']) > 0){
                        // Konto wird zum Kunden hinzugefügt
                        $kunde->konto_anlegen($_POST['kundenid'], $_POST['kartenlimit']);
                    }
                    ?>   
                </p>
            </div>
	    </div>
    </body>
</html>