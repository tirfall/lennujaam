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
        <th>Kohtade arv</th>
        <th>Otskoht</th>
        <th>Sihtkoht</th>
        <th>Väjumisaeg</th>
        <th>Tegevus</th></tr>
    <form action="" method="post">
        <tr>
        <td><input type="text" name="lennu" id="lennu"></td>
        <td><input type="number" name="kohtarv" id="kohtarv" min="0" max="1000"></td>
        <td><input type="text" name="ots" id="ots"></td>
        <td><input type="text" name="siht" id="siht"></td>
        <td><input type="datetime-local" name="valju" id="valju"></td>
        <td><input type="submit" value="Lisa"></td>
        </tr>
    </form>
        <?php
        global $yhendus;
        $paring = $yhendus->prepare("SELECT id,lennu_nr,kohtade_arv,ots,siht,valjumisaeg FROM lend");
        $paring->bind_result($id,$lennu_nr,$kohtade_arv,$ots,$siht,$valjumisaeg);
        $paring->execute();
        while ($paring->fetch())
        {
            echo "<tr>";
            echo "<td>$lennu_nr</td>";
            echo "<td>$kohtade_arv</td>";
            echo "<td>$ots</td>";
            echo "<td>$siht</td>";
            echo "<td>$valjumisaeg</td>";
            echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    include("footer.php")
    ?>
</body>
</html>
