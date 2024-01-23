<?php
ob_start();

// Kui sessioon pole veel käivitatud, siis alusta sessiooni
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lisab konfiguratsioonifaili
require_once("conf.php");

// Ühenduse loomine andmebaasiga
global $yhendus;

// Kustutab lennu vastavalt päringule
if (isset($_REQUEST["kustuta"])) {
    $paring = $yhendus->prepare("DELETE FROM lend WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta"]);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

// Lisab uue lennu vastavalt päringule
if (isset($_REQUEST["lennu"]) && !empty($_REQUEST["lennu"]) && !empty($_REQUEST["ots"]) && !empty($_REQUEST["siht"])) {
    $paring = $yhendus->prepare("INSERT INTO lend (lennu_nr, kohtade_arv, ots, siht, valjumisaeg) VALUES(?,?,?,?,?)");
    $valju = $_REQUEST["valju"];
    if(empty($_REQUEST["valju"]))
    {
        $valju = date('Y-m-d H:i:s');
    }
    $paring->bind_param("sisss", $_REQUEST["lennu"], $_REQUEST["kohtarv"], $_REQUEST["ots"], $_REQUEST["siht"], $valju);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

// Lõpetab lennu vastavalt päringule ja arvutab kestvuse
if (isset($_REQUEST["lop"])) {
    $aeg = new DateTime($_REQUEST['aeg']);
    $lopDate = new DateTime($_REQUEST['lop']);
    $taeg = $aeg->diff($lopDate);
    $mins = ($taeg->y) * 365 * 24 * 60 + ($taeg->i) + ($taeg->h) * 60 + ($taeg->d) * 24 * 60 + ($taeg->m) * 24 * 60;

    // Kui aeg on positiivne ja lõpetamise aeg on või hiljem kui algselt planeeritud väljumisaeg
    if ($mins >= 0 && $aeg <= $lopDate) {
        $paring = $yhendus->prepare("UPDATE lend SET lopetatud=?,kestvus=? WHERE id=?");
        $paring->bind_param("ssi", $_REQUEST["lop"], $mins, $_REQUEST["lope"]);
        $paring->execute();
        header("Location: $_SERVER[PHP_SELF]");
    }
}
?>

<!doctype html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="lennustyle.css">
    <title>Lennujaam haldusleht</title>
</head>

<body>
    <?php
    include("header.php");
    include("nav.php");

    // Kontrollib, kas kasutaja on admin
    if (isAdmin()) {
    ?>
        <table id="lennujaam">
            <tr>
                <th>Lennu number</th>
                <th>Kohtade arv</th>
                <th>Väljumiskoht</th>
                <th>Sihtkoht</th>
                <th>Väljumisaeg</th>
                <th>Lõpetatud</th>
                <th>Kestvus</th>
                <th>Tegevus</th>
            </tr>

            <!-- Vorm uue lennu lisamiseks -->
            <form action="" method="post">
                <tr>
                    <td><input type="text" name="lennu" id="lennu"></td>
                    <td><input type="number" name="kohtarv" id="kohtarv" min="0" max="1000"></td>
                    <td><input type="text" name="ots" id="ots"></td>
                    <td><input type="text" name="siht" id="siht"></td>
                    <td><input type="datetime-local" name="valju" id="valju"></td>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="Lisa"></td>
                </tr>
            </form>

            <?php
            global $yhendus;
            $paring = $yhendus->prepare("SELECT id,lennu_nr,kohtade_arv,ots,siht,valjumisaeg,lopetatud,kestvus FROM lend");
            $paring->bind_result($id, $lennu_nr, $kohtade_arv, $ots, $siht, $valjumisaeg, $lopetatud, $kestvus);
            $paring->execute();

            while ($paring->fetch()) {
                echo "<tr>";
                echo "<td>$lennu_nr</td>";
                echo "<td>$kohtade_arv</td>";
                echo "<td>$ots</td>";
                echo "<td>$siht</td>";
                echo "<td>$valjumisaeg</td>";
                
                // Kuvab lõpetamise kuupäeva ja kestvuse, kui lend on lõpetatud
                if ($lopetatud != "0000-00-00 00:00:00") {
                    echo "<td>$lopetatud</td>";
                    $tundid = round($kestvus / 60,2);
                    echo "<td>$tundid tundit</td>";
                } else {
                    echo "<td class='polet'>Lennuk on endiselt õhus</td>";
                    echo "<td class='polet'>Lennuk on endiselt õhus</td>";
                }

                // Kuvab kustutamise ja lõpetamise vormi
                echo "<td>";
                echo "<a href='?kustuta=$id' class='btnhal'>Kustuta</a> <hr>";
                echo "<form action='' class='btnhal1'> <input type='hidden' name='lope' id='lope' value='$id'><input type='hidden' name='aeg' id='aeg' value='$valjumisaeg'><input type='datetime-local' name='lop' id='lop'> <input type='submit' name='lope1' id='lope1' value='Lõpeta'></form>";
                echo "</td></tr>";
            }
            ?>
        </table>
    <?php
    }
    include("footer.php")
    ?>
</body>

</html>
