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
