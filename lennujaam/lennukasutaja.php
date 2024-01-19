<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    // Если сессия еще не стартовала, начинаем её
    session_start();
}
require_once("conf.php");
global $yhendus;




if (isset($_REQUEST["kustuta"])) {
    $paring = $yhendus->prepare("DELETE FROM lend WHERE id=?");
    $paring->bind_param("i",$_REQUEST["kustuta"]);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if (isset($_REQUEST["lennu"])){
    $paring = $yhendus->prepare("INSERT INTO lend (lennu_nr,kohtade_arv,ots,siht,valjumisaeg) VALUES(?,?,?,?,?)");
    $paring->bind_param("sisss",$_REQUEST["lennu"],$_REQUEST["kohtarv"],$_REQUEST["ots"],$_REQUEST["siht"],$_REQUEST["valju"]);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
$nool=0;
if(isset($_REQUEST["lisareisitaja"])){
    $paring_select = $yhendus->prepare("SELECT reisijate_arv FROM lend WHERE id=?");
    $paring_select->bind_param("i", $_REQUEST["lisareisitaja"]);
    $paring_select->execute();
    $paring_select->bind_result($kohtade_arv_current);
    $paring_select->fetch();
    $paring_select->close();
    if($kohtade_arv_current != $nool) {
        global $yhendus;
        $kask=$yhendus->prepare("UPDATE lend SET reisijate_arv=reisijate_arv-1 WHERE id=?");
        $kask->bind_param("i",$_REQUEST["lisareisitaja"]);
        $kask->execute();
    }
    
}

if(isset($_REQUEST["kustutareisitaja"])){
    $paring_select = $yhendus->prepare("SELECT reisijate_arv FROM lend WHERE id=?");
    $paring_select->bind_param("i", $_REQUEST["kustutareisitaja"]);
    $paring_select->execute();
    $paring_select->bind_result($kohtade_arv_current);
    $paring_select->fetch();
    $paring_select->close();
    $paring_select = $yhendus->prepare("SELECT kohtade_arv FROM lend WHERE id=?");
    $paring_select->bind_param("i", $_REQUEST["kustutareisitaja"]);
    $paring_select->execute();
    $paring_select->bind_result($initial_kohtade_arv);
    $paring_select->fetch();
    $paring_select->close();

    // Проверяем, чтобы значение не стало больше изначального
    if ($kohtade_arv_current < $initial_kohtade_arv) {
        $kask = $yhendus->prepare("UPDATE lend SET reisijate_arv=reisijate_arv+1 WHERE id=?");
        $kask->bind_param("i", $_REQUEST["kustutareisitaja"]);
        $kask->execute();
        // Дополнительный код, если необходимо выполнить дополнительные действия после выполнения запроса
        $kask->close();
    }
}
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="lennustyle.css">
    <title>Lennujaam haldusleht</title>
</head>
<body>
    <?php
    include("header.php");
    include("nav.php");
    ?>
    <table id="lennujaam">
        <tr>
        <th>Lennu number</th>
        <th>Reisijate arv</th>
        <th>Otskoht</th>
        <th>Sihtkoht</th>
        <th>Väjumisaeg</th>
        <th>Tegevus</th></tr>
    
        <?php
        global $yhendus;
        $paring = $yhendus->prepare("SELECT id,lennu_nr,reisijate_arv,ots,siht,valjumisaeg FROM lend");
        $paring->bind_result($id,$lennu_nr,$reisijate_arv,$ots,$siht,$valjumisaeg);
        $paring->execute();
        while ($paring->fetch())
        {
            echo "<tr>";
            echo "<td>$lennu_nr</td>";
            echo "<td>$reisijate_arv</td>";
            echo "<td>$ots</td>";
            echo "<td>$siht</td>";
            echo "<td>$valjumisaeg</td>";
            echo "<td><a href='?lisareisitaja=$id'>Lisa reisitaja</a></td>";
            echo "<td><a href='?kustutareisitaja=$id'>Kustuta reisitaja</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    include("footer.php")
    ?>
</body>
</html>
