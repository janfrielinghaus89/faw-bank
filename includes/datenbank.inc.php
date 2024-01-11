<?php

function DatenbankVerbindung() {
    $config = [
        'servername' => '###',
        'username' => '###',
        'password' => '###',
        'dbname' => '###',
    ];

    return (new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']));
}
