<?php
$kasutaja = 'tarpv22';
$serverinimi = 'localhost';
$parool = '';
$andmebaas = 'lennujaam';
$yhendus = new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
?>
