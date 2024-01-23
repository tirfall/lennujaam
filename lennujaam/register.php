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
