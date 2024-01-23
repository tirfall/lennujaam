<?php 

// Funktsioon, mis kontrollib, kas kasutaja on administraator
function isAdmin()
{
    if(isset($_SESSION['onAdmin']))
    {
        // Kontrollib, kas administraatori märge on seansis olemas ja väärtus on 1
        if ($_SESSION['onAdmin'] == 1)
            return true; // Kui on administraator, tagastab true
        else
            return false; // Kui pole administraator, tagastab false
    }
    else
        return false; // Kui üldse ei ole administraatori märget, tagastab false
}
?>

<!-- Lingid välisele stiililehele -->
<link rel="stylesheet" type="text/css" href="logregstyle.css">

<!-- Navigatsioonipaneel -->
<nav><?php
// Kontrollib, kas kasutaja on sisselogitud
if(isset($_SESSION['kasutaja']))
{?>
    <!-- Kui kasutaja on sisselogitud -->
    <ul class="lehed"><?php
    // Kontrollib, kas kasutaja on administraator
    if(isAdmin())
    {?>
        <!-- Administraatori leht - lingi kuvamine ainult administraatorile -->
        <li><a href="lennuhaldus.php">Admin leht</a></li><?php
    }?>
        <!-- Kasutaja leht -->
        <li><a href="lennukasutaja.php">Kasutaja leht</a></li>
    </ul>
    <!-- Logi välja nupp -->
    <ul class="stylelogreg">
        Tere, <?="$_SESSION[kasutaja]"?>
        <button onclick="location.href='logout.php';">Logi välja</button>
    </ul><?php
}
else{?>
    <!-- Kui kasutaja pole sisselogitud -->
    <ul class="lehed">
        <!-- Kasutaja leht -->
        <li><a href="lennukasutaja.php">Kasutaja leht</a></li>
    </ul>
    <!-- Sisselogimise ja registreerimise nupud -->
    <ul class="stylelogreg">
        <li>
            <!-- Sisselogimise nupp, käivitab modaalakna avamise funktsiooni -->
            <button onclick="openModal()">Logi sisse</button>
            <!-- Sisselogimise modaalaken -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <!-- Sulgemisnupp modaalakna sulgemiseks -->
                    <span class="close" onclick="closeModal()">&times;</span>
                    <?php include 'login.php'; ?> <!-- Sisselogimise vormi sisu -->
                </div>
            </div>
            <!-- JavaScript funktsioonid modaalakna juhtimiseks -->
            <script>
                function openModal() {
                    document.getElementById('myModal').style.display = 'block';
                }

                function closeModal() {
                    document.getElementById('myModal').style.display = 'none';
                }
            </script>
        </li>
        <li>
            <!-- Registreerimise nupp, käivitab modaalakna avamise funktsiooni -->
            <button onclick="openModal1()">Registreerimine</button>
            <!-- Registreerimise modaalaken -->
            <div id="myModal1" class="modal">
                <div class="modal-content">
                    <!-- Sulgemisnupp modaalakna sulgemiseks -->
                    <span class="close" onclick="closeModal1()">&times;</span>
                    <?php include 'register.php'; ?> <!-- Registreerimise vormi sisu -->
                </div>
            </div>
            <!-- JavaScript funktsioonid modaalakna juhtimiseks -->
            <script>
                function openModal1() {
                    document.getElementById('myModal1').style.display = 'block';
                }

                function closeModal1() {
                    document.getElementById('myModal1').style.display = 'none';
                }
            </script>
        </li>
    </ul>
<?php } ?>
</nav>
