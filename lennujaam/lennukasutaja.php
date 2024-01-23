<?php
ob_start();

// Kontrollib, kas sessioon on juba käivitatud, ja alustab vajadusel uut sessiooni
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
if (isset($_REQUEST["lennu"])) {
    $paring = $yhendus->prepare("INSERT INTO lend (lennu_nr, kohtade_arv, ots, siht, valjumisaeg) VALUES(?,?,?,?,?)");
    $paring->bind_param("sisss", $_REQUEST["lennu"], $_REQUEST["kohtarv"], $_REQUEST["ots"], $_REQUEST["siht"], $_REQUEST["valju"]);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

$nool = 0;

// Vähendab reisijate arvu vastavalt päringule
if (isset($_REQUEST["kustutareisitaja"])) {
    $paring_select = $yhendus->prepare("SELECT reisijate_arv FROM lend WHERE id=?");
    $paring_select->bind_param("i", $_REQUEST["kustutareisitaja"]);
    $paring_select->execute();
    $paring_select->bind_result($kohtade_arv_current);
    $paring_select->fetch();
    $paring_select->close();

    if ($kohtade_arv_current != $nool) {
        global $yhendus;
        $kask = $yhendus->prepare("UPDATE lend SET reisijate_arv=reisijate_arv-1 WHERE id=?");
        $kask->bind_param("i", $_REQUEST["kustutareisitaja"]);
        $kask->execute();
    }
}
// Suurendab reisijate arvu vastavalt päringule
if (isset($_REQUEST["lisareisitaja"])) {
    $paring_select = $yhendus->prepare("SELECT reisijate_arv FROM lend WHERE id=?");
    $paring_select->bind_param("i", $_REQUEST["lisareisitaja"]);
    $paring_select->execute();
    $paring_select->bind_result($kohtade_arv_current);
    $paring_select->fetch();
    $paring_select->close();

    $paring_select = $yhendus->prepare("SELECT kohtade_arv FROM lend WHERE id=?");
    $paring_select->bind_param("i", $_REQUEST["lisareisitaja"]);
    $paring_select->execute();
    $paring_select->bind_result($initial_kohtade_arv);
    $paring_select->fetch();
    $paring_select->close();

    if ($kohtade_arv_current < $initial_kohtade_arv) {
        $kask = $yhendus->prepare("UPDATE lend SET reisijate_arv=reisijate_arv+1 WHERE id=?");
        $kask->bind_param("i", $_REQUEST["lisareisitaja"]);
        $kask->execute();
        $kask->close();
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
    ?>
    <table id="lennujaam">
        <tr>
            <th>Lennu number</th>
            <th>Reisijate arv</th>
            <th>Väljumiskoht</th>
            <th>Sihtkoht</th>
            <th>Väljumisaeg</th>

            <?php
            if (isset($_SESSION['kasutaja'])) {
            ?>
                <th>Tegevus</th>
        </tr>
            <?php
            }
            global $yhendus;
            $paring = $yhendus->prepare("SELECT id, lennu_nr, reisijate_arv,kohtade_arv, ots, siht, valjumisaeg FROM lend");
            $paring->bind_result($id, $lennu_nr, $reisijate_arv,$koht, $ots, $siht, $valjumisaeg);
            $paring->execute();

            while ($paring->fetch()) {
                date_default_timezone_set('Europe/Tallinn');
                $currentDateTime = new DateTime();
                $valjumisaegDateTime = new DateTime($valjumisaeg);
                $interval = $currentDateTime->diff($valjumisaegDateTime);

                if ($interval->h >= 1 && $currentDateTime < $valjumisaegDateTime) {
                    echo "<tr>";
                    echo "<td>$lennu_nr</td>";
                    echo "<td>$reisijate_arv</td>";
                    echo "<td>$ots</td>";
                    echo "<td>$siht</td>";
                    echo "<td>$valjumisaeg</td>";

                    if (isset($_SESSION['kasutaja'])) {
                        if($reisijate_arv!=0)
                        {
                            echo "<td><a href='?kustutareisitaja=$id'>Kustuta reisitaja</a>";
                        }
                        else{
                            echo "<td class='polet1'>Väärtus on null";
                        }
                        echo "<hr>";
                        if($koht!=$reisijate_arv)
                        {
                            echo "<a href='?lisareisitaja=$id'>Lisa reisitaja</a></td>";
                        }
                        else{
                            echo "<p class='polet1'>Maksimaalne väärtus</p>";
                        }
                    }
                    echo "</tr>";
                }
            }
            ?>
    </table>
    <?php
    include("footer.php")
    ?>
</body>

</html>