<?php
session_start();
ob_start();
require_once("conf.php");
global $yhendus;




if (!empty($_POST['regnimi']) && !empty($_POST['passr'])) {

    $regnimi = htmlspecialchars(trim($_POST['regnimi']));
    $pass = htmlspecialchars(trim($_POST['passr']));

    $sool = 'superpaev';
    $kryp = crypt($pass, $sool);

    $kontrollimine=$yhendus-> prepare("SELECT kasutaja FROM kasutaja WHERE kasutaja=?");
    $kontrollimine->bind_param("s", $regnimi);
    $kontrollimine->execute();

    if ($kontrollimine->fetch()) {
        echo "Kasutajanimi '$regnimi' on võetud";
        header('Location: haldusLeht.php');
        $kontrollimine->close();
        $yhendus->close();
        exit();
    }
    $kontrollimine->close();

    $kaskINSERT = $yhendus->prepare("INSERT INTO kasutaja(kasutaja, parool, onAdmin, onKas) VALUES (?,?,0,1) ");
    $kaskINSERT->bind_param("ss", $regnimi, $kryp);

    if($kaskINSERT->execute()){
        $paring=$yhendus-> prepare("SELECT kasutaja,onAdmin, onKas FROM lennujaamkasutaja WHERE kasutaja=? AND parool=?");
        $paring->bind_param("ss", $regnimi, $kryp);
        $paring->bind_result($kasutaja, $onAdmin, $onKas);
        $paring->execute();

        if ($paring->fetch()) {
            $_SESSION['tuvastamine'] = 'misiganes';
            $_SESSION['kasutaja'] = $regnimi;
            $_SESSION['onAdmin'] = $onAdmin;
            $_SESSION['onKas'] = $onKas;
            header('Location: haldusLeht.php');
            $yhendus->close();
            exit();
        }
        else {
            echo "Kasutajanimi '$regnimi' on võetud";
            header('Location: haldusLeht.php');
            $yhendus->close();
        }
    }
    else {
        echo "Kasutajanimi '$regnimi' on võetud";
        header('Location: haldusLeht.php');
        $yhendus->close();
    }

    $yhendus->close();
    exit();
}
?>
<h1>Registreerimine</h1>
<form action="" method="post">
    Nimi: <input type="text" name="regnimi"><br><br>
    Password: <input type="password" name="passr"><br><br>
    <input type="submit" value="Registreeri">
</form>