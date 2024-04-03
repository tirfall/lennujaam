<a name="top"></a>
# Lennujaam
![image](https://github.com/tirfall/lennujaam/assets/61885744/d1fd9871-a3d7-4b3e-89ee-15523b2b172e)
## Sisukord
1. [Loojad](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#loojad)
2. [Projekti eesmärgid](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#Projekti-eesmärgid)
3. [Kirjeldus](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#Kirjeldus)
4. [Lehed](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#lehed)
   - [Kasutaja leht](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#kasutaja-leht)
   - [Registreerimata kasutaja leht](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#registreerimata-kasutaja-leht)
   - [Admini leht](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#admini-leht)
5. [Logi sisse](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#logi-sisse)
6. [Registreerimine](https://github.com/tirfall/lennujaam/tree/main?tab=readme-ov-file#registreerimine)  

## Loojad
**Loojad:** @TimurDenisenko ja @tirfall (Aleksander Rogovski) 
<p align="right"><a href="#top">tagasi</a></p>

## Projekti eesmärgid
- [x] Looge süsteem lendude vaatamiseks
- [x] Lendude lisamiseks looge administraatori leht
- [x] Teostage registreerimist ja muid väiksemaid funktsioone
<p align="right"><a href="#top">tagasi</a></p>

## Kirjeldus
Lennujaama projektil on 3 lehekülge: admini leht, kasutaja leht, registreerimata leht. 
Kasutajalehele saab vaadata lende, mis toimuvad üle tunni aja. Samuti saab kasutaja lisada või vähendada reisijate arvu lennul. Kohtade arvu määrab administraator lennu lisamise ajal. 
Admini lehel saab administraator lisada lennu. Lennu loomisel määrab administraator väljumisaja, lennu numbri, kohtade arvu, väljumis- ja saabumiskohta. Pärast lennu loomist saab administraator määrata lõppaja või kustutada lennu.
Registreerimata kasutaja saab vaadata ainult lennugraafikuid ja registreeruda.
<p align="right"><a href="#top">tagasi</a></p>

## Lehed

### Kasutaja leht
![image](https://github.com/tirfall/lennujaam/assets/61885744/b95daa8b-9db5-4462-8b95-7ee837aeb203)

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

### Registreerimata kasutaja leht
![image](https://github.com/tirfall/lennujaam/assets/61885744/dca0e1d2-cab0-4170-9f82-66c1ba663702)
Registreerimata kasutaja leht
<p align="right"><a href="#top">tagasi</a></p>

### Admini leht
![image](https://github.com/tirfall/lennujaam/assets/61885744/8e23a0e3-ee10-4c52-993d-a2a68dffaf8d)

<p align="right"><a href="#top">tagasi</a></p>

## Logi sisse
![image](https://github.com/tirfall/lennujaam/assets/61885744/52c543e4-ee38-4bbd-bd92-c9cf78a84a1a)

<p align="right"><a href="#top">tagasi</a></p>

## Registreerimine
![image](https://github.com/tirfall/lennujaam/assets/61885744/ad75680b-437b-4c92-b03b-5a72521477ed)

<p align="right"><a href="#top">tagasi</a></p>
