<?php
// Import der Datenbank-Daten
require_once('datenbank.inc.php');
require_once('escape.inc.php');

// Definition der Klasse Bank
class Bank {
    public $kundenliste;

    // Kunden hinzufügen Funktion
    public function kunden_hinzufügen($name, $vorname, $strasse, $hausnummer, $plz, $stadt, $kundenart) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Daten escapen
        $safeName = escapeString($name);
        $safeVorname = escapeString($vorname);
        $safeStrasse = escapeString($strasse);
        $safeHausnummer = escapeString($hausnummer);
        $safePlz = escapeString($plz);
        $safeStadt = escapeString($stadt);
        $safeKundenart = escapeString($kundenart);

        // Daten einfügen
        $sql = "INSERT INTO kunden (Name, Vorname, Strasse, Hausnummer, PLZ, Stadt, Kundenart)
        VALUES ('".$safeName."', '".$safeVorname."', '".$safeStrasse."', '".$safeHausnummer."', '".$safePlz."', '".$safeStadt."', '".$safeKundenart."')";

        if ($conn->query($sql) === TRUE) {
            echo "<font color=\"green\">Der Kunde wurde erfolgreich angelegt.</font>";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        
    }

    // Kunde suchen Funktion
    public function kunde_suchen($kontonummer, $konto_anlegen = false) {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Verbindung fehlgeschlagen: " . $conn->connect_error);
        }

        // Kontonummer escapen
        $safeKontonummer = escapeString($kontonummer);

        // Daten des Kunden mit der angegebenen Kontonummer suchen
        $sql = "SELECT * FROM kunden WHERE Kontonummer = '{$safeKontonummer}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Daten reihenweise ausgeben
            while($row = $result->fetch_assoc()) {
                echo "<tr>" . "<td>" . $row["KundenID"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Vorname"] . "</td><td>" . $row["Strasse"] . "</td><td>" . $row["Hausnummer"]
                . "</td><td>" . $row["PLZ"]  . "</td><td>" . $row["Stadt"]  . "</td><td>" . $row["Kundenart"] ."</td><td>" . $row["Kontonummer"]  . "</td><td>" . $row["Guthaben"]
                . "</td><td>" . $row["Kartennummer"]  . "</td><td>" . $row["Kartenlimit"]  . "</tr>";
            }
        } else {
            echo "Keine Ergebnisse";
        }

        // SQL Verbindung trennen
        $conn->close();
    }

    // Kunden anzeigen Funktion
    public function kunden_anzeigen() {
        // Datenbankverbindung herstellen
        $conn = DatenbankVerbindung();

        // Verbindung überprüfen
        if ($conn->connect_error) {
            die("Verbindung fehlgeschlagen: " . $conn->connect_error);
        }
      
        // Alle Daten von der Datenbank abrufen
        $sql = "SELECT * FROM kunden";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Daten reihenweise ausgeben
            while($row = $result->fetch_assoc()) {
                echo "<tr>" . "<td>" . $row["KundenID"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Vorname"] . "</td><td>" . $row["Strasse"] . "</td><td>" . $row["Hausnummer"]
                . "</td><td>" . $row["PLZ"]  . "</td><td>" . $row["Stadt"]  . "</td><td>" . $row["Kundenart"] ."</td><td>" . $row["Kontonummer"]  . "</td><td>" . $row["Guthaben"]
                . "</td><td>" . $row["Kartennummer"]  . "</td><td>" . $row["Kartenlimit"]  . "</tr>";
            }
        } else {
            echo "Keine Ergebnisse";
        }

        // SQL Verbindung trennen
        $conn->close();
    }
}

// Instanzieren der FAW Bank
$fawBank = new Bank();
