<?php
// Alustab uut või taastab olemasoleva sessiooni
session_start();

// Alustab väljundi puhverdamist. See võimaldab väljundit puhverdada enne selle tegelikku saatmist.
ob_start();

// Hävitab kõik sessiooni andmed
session_destroy();

// Suunab kasutaja lennukasutaja.php lehele
header("location: lennukasutaja.php");

// Tagastab skripti täitmise
exit();
?>
