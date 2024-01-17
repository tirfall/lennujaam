<?php
require_once("conf.php");
global $yhendus;
//kontrollime kas väljad registreerimisvormis on täidetud
if (!empty($_POST['register_login']) && !empty($_POST['register_pass'])) {
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['register_login']));
    $pass = htmlspecialchars(trim($_POST['register_pass']));

    // Lisage siia vajalikud kontrollid, näiteks parooli tugevuse kontroll

    //SIIA UUS KONTROLL
    $cool = "superpaev";
    $kryp = crypt($pass, $cool);
    $kask = $yhendus->prepare("SELECT * FROM lennujaamkasutaja WHERE kasutaja=?");
    $kask->bind_param("s", $login);
    $kask->execute();
    //kontrollime, kas andmebaasis on juba selline kasutajanimi
    if ($kask->fetch())
    {
        echo "See nimi on võetud";
        $kask->close();
    }
    else{
        $kasutaja_lisamine_kask = $yhendus->prepare("INSERT INTO lennujaamkasutaja (kasutaja, parool) VALUES (?, ?)");
        $kasutaja_lisamine_kask->bind_param("ss", $login, $kryp);
        $kasutaja_lisamine_kask->execute();
        $kasutaja_lisamine_kask->close();
    }
}

?>

<h1>Registreeri</h1>
<form action="" method="post">
    Kasutajanimi: <input type="text" name="register_login"><br>
    Parool: <input type="password" name="register_pass"><br>
    <!-- Lisage siia muud väljad, mida soovite registreerimisvormis kasutada -->
    <input type="submit" value="Registreeri">
</form>
