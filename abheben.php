<?php
    // Kundenübersicht abrufen
    require_once('includes/bank.inc.php');
    require_once('includes/kunde.inc.php');
    require_once('includes/konto.inc.php');
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
                <h3>Auszahlung tätigen</h3>
                <form id="auszahlen" action="abheben.php" method="post">
                    <label for="text">Kontonummer: </label><input type="text" id="kontonummer" name="kontonummer" placeholder="0000000000" required><br>
                    <label for="text">Summe: </label><input type="number" id="summe" name="summe" placeholder="0" required><br>
                    <input type="submit" name="auszahlen" value="Auszahlen">
                </form><br>
                <p class="col-9-kundenbereich">
                    <?php
                    // Aufruf der Suchen-Funktion, falls diese ausgelöst wurde
                    if(isset($_POST['auszahlen']) && strlen($_POST['summe']) > 0){
                        // Einzahlung tätigen
                        $konto->auszahlen($_POST['kontonummer'], $_POST['summe']);
                    }
                    ?>   
                </p>
            </div>
	    </div>
    </body>
</html>