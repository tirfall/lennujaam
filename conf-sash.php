<?php
$kasutaja='sash';
$serverinimi='localhost';
$parool='sash';
$andmebaas='sash';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');