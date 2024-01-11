<?php
// Import der Datenbank-Daten
require_once('datenbank.inc.php');
require_once('bank.inc.php');

// Definition der Klasse Kunde
class Kunde {
    public $name;
    public $adresse;

    // Erstellen des Konstruktors
    public function __construct($name = "", $adresse = []) {
        $this->name = $name;
        $this->adresse = $adresse;
    }

    // Freie Kontonummer finden
    public function freie_kontonummer($kundenart) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Verbindung fehlgeschlagen: " . $conn->connect_error);
        }

        // Kontobereich je nach Kundenart: Ab 1xxxxxxxxx für Privatkunden, ab 6xxxxxxxxx für Firmenkunden
        if($kundenart === "Privatkunde") {
            $unteresLimit = 1000000000;
            $oberesLimit = 5999999999;
        } else {
            $unteresLimit = 6000000000;
            $oberesLimit = 9999999999;
        }
      
        // SQL-Abfrage zur Suche nach der kleinsten unvergebenen Kontonummer
        $sql = "SELECT MIN(Kontonummer) AS kleinste_unvergebene_nummer
        FROM kunden
        WHERE Kontonummer >= $unteresLimit AND Kontonummer <= $oberesLimit
        AND NOT EXISTS (
            SELECT 1
            FROM kunden t1
            WHERE t1.Kontonummer = kunden.Kontonummer + 1
        )";

        // Resultat des Query abfragen
        $result = $conn->query($sql);

        // Falls Ergebnisse vorhanden sind, diese ausgeben
        if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kleinsteNummer = $row['kleinste_unvergebene_nummer'];
        return $kleinsteNummer;
        } else {
        echo "Es gibt keine freie Kontonummer.";
        }

        // SQL Verbindung trennen
        $conn->close();
        }

        public function freie_kartennummer() {
            // Datenbankverbindung herstellen
            $conn = DatenbankVerbindung();
    
            // Verbindung überprüfen
            if ($conn->connect_error) {
                die("Verbindung fehlgeschlagen: " . $conn->connect_error);
            }
          
            // SQL-Abfrage zur Suche nach der kleinsten unvergebenen Kontonummer
            $sql = "SELECT MIN(Kartennummer) AS kleinste_unvergebene_nummer
            FROM kunden
            WHERE Kartennummer >= 100000000000 AND Kartennummer <= 999999999999
            AND NOT EXISTS (
                SELECT 1
                FROM kunden t1
                WHERE t1.Kartennummer = kunden.Kartennummer + 1
            )";
    
            // Resultat des Query abfragen
            $result = $conn->query($sql);
    
            // Falls Ergebnisse vorhanden sind, diese ausgeben
            if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $kleinsteNummer = $row['kleinste_unvergebene_nummer'];
            return $kleinsteNummer;
            } else {
            echo "Es gibt keine freie Kartennummer.";
            }
    
            // SQL Verbindung trennen
            $conn->close();
            }

    // Konto anlegen Funktion
    public function konto_anlegen($kundenid, $kartenlimit = 0, $guthaben = 0) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Suche nach der Kundenart per SQL und Ausgabe als $kundenart
        $sql = "SELECT Kundenart FROM kunden WHERE KundenID = '{$kundenid}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $kundenart = $row['Kundenart'];
        } else {
            echo "Kunde nicht gefunden";
            return;
        }

        // Abruf der freien Konto- und Kartennummer
        $kontonummer = $this->freie_kontonummer($kundenart);
        $kartennummer = $this->freie_kartennummer();

        $sql = "UPDATE kunden SET Kontonummer = '{$kontonummer}', Guthaben = '{$guthaben}', Kartennummer = '{$kartennummer}', Kartenlimit = '{$kartenlimit}' WHERE KundenID = '{$kundenid}'";

        if ($conn->query($sql) === TRUE) {
            echo "Der Kunde wurde mit Kontonummer " . $kontonummer . " und Kartennummer " . $kartennummer . " aktualisiert.";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    // Kreditkarte hinterlegen Funktion
    public function kreditkarte_hinterlegen() {
        // TODO
    }
}

// Vererbungen von Klasse Kunde
class Privatkunde extends Kunde {

}

class Firmenkunde extends Kunde {
    
}

$kunde = new Kunde();
$privatkunde = new Privatkunde();
$firmenkunde = new Firmenkunde();
