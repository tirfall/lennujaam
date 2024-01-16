<?php
$parool="admin";
$cool="lennuk";
$krypt=crypt($parool, $cool);
echo $krypt;
?>