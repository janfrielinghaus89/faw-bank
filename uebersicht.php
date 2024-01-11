<?php
    require_once('includes/bank.inc.php');
    require_once('includes/escape.inc.php');
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
                <h3>Kunde per Kontonummer (10-stellig) suchen</h3>
                <form id="suche" action="uebersicht.php" method="get">
                    <input type="text" id="kontonummersuche" name="kontonummersuche" placeholder="012345678910" required><br>
                    <input type="submit" name="submitsuche" value="Suchen">
                </form><br>
                <h3>Alle Kunden anzeigen</h3>
                <form id="anzeigen" action="uebersicht.php" method="get">
                    <input type="submit" name="alleanzeigen" value="Alle anzeigen">
                </form>
                <p class="col-9-kundenbereich">
                <table class="table">
                    <tr>
                        <th>KundenID</th>
                        <th>Name</th>
                        <th>Vorname</th>
                        <th>Straße</th>
                        <th>Hausnummer</th>
                        <th>PLZ</th>
                        <th>Stadt</th>
                        <th>Kundenart</th>
                        <th>Kontonummer</th>
                        <th>Guthaben</th>
                        <th>Kartennummer</th>
                        <th>Kartenlimit</th>
                    </tr>
                    <?php
                    // Aufruf der Suchen-Funktion, falls diese ausgelöst wurde
                    if (isset($_GET['submitsuche']) && strlen($_GET['kontonummersuche']) === 10) {
                        $kontonummer = $_GET['kontonummersuche'];
                        // Escaping der Benutzereingabe
                        $safeKontonummer = escapeString($kontonummer);
                        $fawBank->kunde_suchen($safeKontonummer);
                    }
                    // Abfangen von zu kurzen oder zu langen Kontonummern bzw. Fehlerausgabe
                    elseif (isset($_GET['submitsuche']) && strlen($_GET['kontonummersuche']) != 10) {
                        echo "<font color=\"red\">Die eingegebene Nummer muss 10-stellig sein.</font>";
                    }
                    // Aufruf der Gesamtanzeige, falls diese ausgelöst wurde
                    if (isset($_GET['alleanzeigen'])) {
                        $fawBank->kunden_anzeigen();
                    }
                    ?>
                    
                </table>
                </p>
            </div>
	    </div>
    </body>
</html>