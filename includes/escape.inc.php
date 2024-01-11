<?php

// Funktion zum Escapen von Strings
function escapeString($string) {
    // Datenbankverbindung herstellen
    $conn = DatenbankVerbindung();

    // Escape-Funktion anwenden
    $escapedString = $conn->real_escape_string($string);

    // SQL Verbindung trennen
    $conn->close();

    // Escapten String zurückgeben
    return $escapedString;
}