
<?php
function isAdmin(){
    return  isset ($_SESSION['onAdmin']) && $_SESSION['onAdmin'];
}
?>
<link rel="stylesheet" type="text/css" href="logregstyle.css">

<nav>
    <ul class="lehed">
        <li><a href="https://aleksanderrogovski22.thkit.ee/">Koduleht</a></li>
        <?php if(isAdmin()) { ?>
            <li><a href="adminLeht.php">Admin leht</a></li>
        <?php } ?>
        <li><a href="haldusLeht.php">Kasutaja leht</a></li>
    </ul>
    <ul class="stylelogreg">
        <li><?php include('registreerimine.php'); ?></li>
        <li><?php include('logimine.php'); ?></li>
    </ul>
</nav>

