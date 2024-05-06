<a name="top"></a>
# Lennujaam
![image](https://github.com/tirfall/lennujaam/assets/61885744/d1fd9871-a3d7-4b3e-89ee-15523b2b172e)
## Sisukord
1. [Loojad](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#loojad)
2. [Projekti eesmärgid](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#Projekti-eesmärgid)
3. [Lehed](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#lehed)
   - [Kasutaja leht](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#kasutaja-leht)
   - [Registreerimata kasutaja leht](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#registreerimata-kasutaja-leht)
   - [Admini leht](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#admini-leht)
4. [Logi sisse](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#logi-sisse)
5. [Registreerimine](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#registreerimine)  

## Loojad
**Loojad:** @TimurDenisenko ja @tirfall (Aleksander Rogovski) 
<p align="right"><a href="#top">tagasi</a></p>

## Projekti eesmärgid
- [x] Looge süsteem lendude vaatamiseks
- [x] Lendude lisamiseks looge administraatori leht
- [x] Teostage registreerimist ja muid väiksemaid funktsioone
<p align="right"><a href="#top">tagasi</a></p>

## Lehed

### Kasutaja leht
![image](https://github.com/tirfall/lennujaam/assets/61885744/b95daa8b-9db5-4462-8b95-7ee837aeb203)

Kasutajalehele saab vaadata lende, mis toimuvad üle tunni aja. Samuti saab kasutaja lisada või vähendada reisijate arvu lennul. Kohtade arvu määrab administraator lennu lisamise ajal. 
<details><summary>Kood</summary>
   
```
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
```

</details>
<p align="right"><a href="#top">tagasi</a></p>

### Registreerimata kasutaja leht
![image](https://github.com/tirfall/lennujaam/assets/61885744/dca0e1d2-cab0-4170-9f82-66c1ba663702)

Registreerimata kasutaja saab vaadata ainult lennugraafikuid ja registreeruda.
<p align="right"><a href="#top">tagasi</a></p>

### Admini leht
![image](https://github.com/tirfall/lennujaam/assets/61885744/8e23a0e3-ee10-4c52-993d-a2a68dffaf8d)

Admini lehel saab administraator lisada lennu. Lennu loomisel määrab administraator väljumisaja, lennu numbri, kohtade arvu, väljumis- ja saabumiskohta. Pärast lennu loomist saab administraator määrata lõppaja või kustutada lennu.
<details><summary>Kood</summary>
   
```
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
```

</details>

<p align="right"><a href="#top">tagasi</a></p>

## Logi sisse
![image](https://github.com/tirfall/lennujaam/assets/61885744/52c543e4-ee38-4bbd-bd92-c9cf78a84a1a)
PHP kood kontrollib kas kasutaja nimi ja parool on õigesti. Kui kasutaja sisaldab admini nimi ja admini parool, siis avatakse admini leht.
<details><summary>Kood</summary>
   
```
<?php
// Konfiguratsioonifaili (conf.php) sisselugemine
require_once("conf.php");

// Ühenduse loomine andmebaasiga
global $yhendus;

// Kontrollib, kas kasutaja on saatnud logimisvormi andmed
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    // Saab ja puhastab kasutajanime ja parooli
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));

    // Soolamine (salting) parooli jaoks
    $cool = "superpaev";
    $kryp = crypt($pass, $cool);

    // Andmebaasis oleva kasutaja kontrollimine
    $kask = $yhendus->prepare("SELECT kasutaja, onAdmin FROM lennujaamkasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $kryp);
    $kask->bind_result($kasutaja, $onAdmin);
    $kask->execute();

    // Kui kasutaja on andmebaasis leitud
    if ($kask->fetch()) {
        // Seansimuutujate seadmine kasutaja tuvastamiseks
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $login;
        $_SESSION['onAdmin'] = $onAdmin;

        // Suunab administraatori lehele, kui kasutaja on admin
        if ($_SESSION['onAdmin'] == 1) {
            header('Location: lennuhaldus.php');
        } else {
            // Suunab tavakasutaja lehele
            header("Location: lennukasutaja.php");
        }
    } else {
        // Kui kasutajat ei leitud andmebaasist, väljastatakse viga
        echo "Kasutaja $login või parool $kryp on vale";
    }
}
?>

<!-- HTML-vorm kasutajanime ja parooli sisestamiseks -->
<h1>Login</h1>
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
```

</details>

<p align="right"><a href="#top">tagasi</a></p>

## Registreerimine
![image](https://github.com/tirfall/lennujaam/assets/61885744/ad75680b-437b-4c92-b03b-5a72521477ed)

PHP kood registreeri kasutaja andmebaasi kui kasutaja sisaldab oma andmed (nimi ja parool).
<details><summary>Kood</summary>
   
```
<?php
require_once("conf.php");

// Ühenduse loomine andmebaasiga
global $yhendus;

// Kontroll, kas registreerimisvormi andmed on saadetud
if (!empty($_POST['register_login']) && !empty($_POST['register_pass'])) {

    // Kasutajanime ja parooli saamine ja puhastamine
    $login = htmlspecialchars(trim($_POST['register_login']));
    $pass = htmlspecialchars(trim($_POST['register_pass']));

    // Soolamine (salting) parooli jaoks
    $cool = "superpaev";
    $kryp = crypt($pass, $cool);

    // Andmebaasis olemasoleva kasutajanime kontroll
    $kask = $yhendus->prepare("SELECT * FROM lennujaamkasutaja WHERE kasutaja=?");
    $kask->bind_param("s", $login);
    $kask->execute();

    // Kui kasutajanimi on juba võetud
    if ($kask->fetch()) {
        echo "See nimi on võetud";
        $kask->close();
    } else {
        // Kui kasutajanimi on vaba, siis lisatakse uus kasutaja andmebaasi
        $kasutaja_lisamine_kask = $yhendus->prepare("INSERT INTO lennujaamkasutaja (kasutaja, parool) VALUES (?, ?)");
        $kasutaja_lisamine_kask->bind_param("ss", $login, $kryp);
        $kasutaja_lisamine_kask->execute();
        $kasutaja_lisamine_kask->close();
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $login;
        // Suunab tavakasutaja lehele
        header("Location: lennukasutaja.php");
    }
}

?>

<!-- Registreerimisvorm HTML kujul -->
<h1>Registreeri</h1>
<form action="" method="post">
    Kasutajanimi: <input type="text" name="register_login"><br>
    Parool: <input type="password" name="register_pass"><br>
    <input type="submit" value="Registreeri">
</form>
```

</details>

<p align="right"><a href="#top">tagasi</a></p>

##Ülesanded

1. Muutke teksti värv punaseks "Lennuk on õhus", "Väärtus on null" ja "Maksimaalne väärtus".
2. Muutke teksti värv mustaks "Kustuta reisitaja" ja "Lisa reisitaja"
3. Muuda tekst punaseks hiirekursori hõljutamisel administraatori lehel "kustuta"
4. Muutke tabeli ülemise rea taustavärvi. Teie valitud värv
5. Värvige taust footer
6. Administraatorilehel oleva nupu "Lisa" taust muutub roheliseks, kui hõljute kursorit selle kohal
