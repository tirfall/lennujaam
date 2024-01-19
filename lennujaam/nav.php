
<link rel="stylesheet" type="text/css" href="logregstyle.css">

<nav>
    <ul class="lehed">
            <li><a href="lennuhaldus.php">Admin leht</a></li>
        <li><a href="lennukasutaja.php">Kasutaja leht</a></li>
    </ul>
    <ul class="stylelogreg">
        <li>
            <button onclick="openModal()">Logi sisse</button>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <?php include 'login.php'; ?>
                </div>
            </div>
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
            <button onclick="openModal1()">Registreerimine</button>
            <div id="myModal1" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal1()">&times;</span>
                    <?php include 'register.php'; ?>
                </div>
            </div>
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
</nav>
