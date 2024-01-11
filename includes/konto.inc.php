<?php
// Import der Datenbank-Daten
require_once('datenbank.inc.php');
require_once('bank.inc.php');

// Definition der Klasse Konto
class Konto {
    public $kontonummer;
    public $guthaben;

    public function einzahlen($kontonummer, $summe) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Suche nach dem aktuellen Guthaben
        $kontonummer = $conn->escape_string($kontonummer); // Escape-Mechanismus
        $sql = "SELECT Guthaben FROM kunden WHERE Kontonummer = '{$kontonummer}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $guthaben = $row['Guthaben'];
        } else {
            echo "Konto nicht gefunden";
            return;
        }

        // neues Guthaben berechnen
        $neuesGuthaben = $guthaben + $summe;

        $neuesGuthaben = $conn->escape_string($neuesGuthaben); // Escape-Mechanismus
        $sql = "UPDATE kunden SET Guthaben = '{$neuesGuthaben}' WHERE Kontonummer = '{$kontonummer}'";

        if ($conn->query($sql) === TRUE) {
            echo "Es wurden " . $summe . " eingezahlt und der neue Kontostand beträgt nun " . $neuesGuthaben . ".";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function auszahlen($kontonummer, $summe) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Suche nach dem aktuellen Guthaben
        $kontonummer = $conn->escape_string($kontonummer); // Escape-Mechanismus
        $sql = "SELECT Guthaben FROM kunden WHERE Kontonummer = '{$kontonummer}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $guthaben = $row['Guthaben'];
        } else {
            echo "Konto nicht gefunden";
            return;
        }

        // neues Guthaben berechnen
        $neuesGuthaben = $guthaben - $summe;

        $neuesGuthaben = $conn->escape_string($neuesGuthaben); // Escape-Mechanismus
        $sql = "UPDATE kunden SET Guthaben = '{$neuesGuthaben}' WHERE Kontonummer = '{$kontonummer}'";

        if ($conn->query($sql) === TRUE) {
            echo "Es wurden " . $summe . " ausgezahlt und der neue Kontostand beträgt nun " . $neuesGuthaben . ".";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}

$konto = new Konto();