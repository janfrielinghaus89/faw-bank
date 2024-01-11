<?php
// Import der Datenbank-Daten
require_once('datenbank.inc.php');
require_once('bank.inc.php');
require_once('escape.inc.php');

// Definition der Klasse Kreditkarte
class Kreditkarte {
    public $kartennummer;
    public $limit;

    public function aufladen($kartennummer, $summe) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Escape der Eingabewerte
        $safeKartennummer = escapeString($kartennummer);
        $safeSumme = escapeString($summe);

        // Suche nach dem aktuellen Limit
        $sql = "SELECT Kartenlimit FROM kunden WHERE Kartennummer = '{$safeKartennummer}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $limit = $row['Kartenlimit'];
        } else {
            echo "Konto nicht gefunden";
            return;
        }

        // neues Limit berechnen
        $neuesLimit = $limit + $safeSumme;

        $sql = "UPDATE kunden SET Kartenlimit = '{$neuesLimit}' WHERE Kartennummer = '{$safeKartennummer}'";

        if ($conn->query($sql) === TRUE) {
            echo "Es wurden " . $safeSumme . " eingezahlt und das neue Limit beträgt nun " . $neuesLimit . ".";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function bezahlen($kartennummer, $summe) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Escape der Eingabewerte
        $safeKartennummer = escapeString($kartennummer);
        $safeSumme = escapeString($summe);

        // Suche nach dem aktuellen Limit
        $sql = "SELECT Kartenlimit FROM kunden WHERE Kartennummer = '{$safeKartennummer}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $limit = $row['Kartenlimit'];
        } else {
            echo "Konto nicht gefunden";
            return;
        }

        // neues Limit berechnen
        $neuesLimit = $limit - $safeSumme;

        $sql = "UPDATE kunden SET Kartenlimit = '{$neuesLimit}' WHERE Kartennummer = '{$safeKartennummer}'";

        if ($conn->query($sql) === TRUE) {
            echo "Es wurden " . $safeSumme . " bezahlt und das neue Limit beträgt nun " . $neuesLimit . ".";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}

$kreditkarte = new Kreditkarte();