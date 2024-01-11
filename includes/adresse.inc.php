<?php

// Definition der Klasse Adresse
class Adresse {
    public $strasse;
    public $hausnummer;
    public $plz;
    public $stadt;

    public function __construct($strasse, $hausnummer, $plz, $stadt) {
        $this->strasse = $strasse;
        $this->hausnummer = $hausnummer;
        $this->plz = $plz;
        $this->stadt = $stadt;
    }
}