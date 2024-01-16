<?php
session_start();
ob_start();
require_once("conf.php");
global $yhendus;


//kontrollime kas väljad  login vormis on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $sool = 'superpaev';
    $kryp = crypt($pass, $sool);
    //kontrollime kas andmebaasis on selline kasutaja ja parool
    $kask=$yhendus-> prepare("SELECT kasutaja,onAdmin, onKas FROM kasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $kryp);
    $kask->bind_result($kasutaja, $onAdmin, $onKas);
    $kask->execute();
    //kui on, siis loome sessiooni ja suuname
    if ($kask->fetch()) {
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $login;
        $_SESSION['onAdmin'] = $onAdmin;
        $_SESSION['onKas'] = $onKas;
        if($onAdmin==1){
            header('Location: adminLeht.php');}
        else {
            header('Location: haldusLeht.php');
            $yhendus->close();
            exit();
        }
    } else {
        echo "kasutaja $login või parool $pass on vale";
        $yhendus->close();
    }
}
?>
<h1>Login</h1>
<form action="" method="post">
    Login nimi: <input type="text" name="login"><br><br>
    Password: <input type="password" name="pass"><br><br>
    <input type="submit" value="Logi sisse">
</form>