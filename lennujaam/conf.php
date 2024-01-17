<?php
$kasutaja = 'd123172_timur';
$serverinimi = 'd123172.mysql.zonevs.eu';
$parool='56360881Tt.';
$andmebaas='d123172_andmebaas';
$yhendus=new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset('UTF8');