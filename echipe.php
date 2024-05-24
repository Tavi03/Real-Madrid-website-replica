<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php" ?>
    <link rel="stylesheet" href="styles/echipestyle.css">
    <title>Real Madrid C.F. | Echipe</title>
</head>

<body>
    <!-- Navbar -->
    <?php include "navbar/navbar.php"; ?>

    <!-- Header -->
    <div class="header">
        <h1>
            Echipele clubului
        </h1>
        <img src="images/contact/real madrid logo gri.svg" alt="real madrid logo">
    </div>
    <!-- Header end -->

    <div class="content">
        <!-- Afisarea echipei de fotbal -->
        <div class="football-team">
            <h2 class="sport">Fotbal</h2>
            <?php
            include "inc/config.php";
            include "inc/connect.php";

            /** Afisarea portarilor */
            $query = "SELECT nume, numar_tricou FROM echipa_fotbal where post='Portar'";
            $result = mysqli_query($id_conexiune, $query);
            print ("<h3>Portari</h3>");
            if (mysqli_num_rows($result)) {
                print ("<ul class=\"players-list\">\n");
                while ($row = mysqli_fetch_array($result)) {
                    $vnume = htmlspecialchars($row['nume']);
                    $vnumar_tricou = $row['numar_tricou'];
                    print ("<li><span class='shirt-number'>$vnumar_tricou</span> $vnume</li>\n");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista niciun portar!</p>";
            }

            // Afisarea fundasilor
            $query = "SELECT nume, numar_tricou FROM echipa_fotbal where post='Fundas'";
            $result = mysqli_query($id_conexiune, $query);
            print ("<h3>Fundasi</h3>");
            if (mysqli_num_rows($result)) {
                print ("<ul class=\"players-list\">\n");
                while ($row = mysqli_fetch_array($result)) {
                    $vnume = htmlspecialchars($row['nume']);
                    $vnumar_tricou = $row['numar_tricou'];
                    print ("<li><span class='shirt-number'>$vnumar_tricou</span> $vnume</li>\n");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista niciun fundas!</p>";
            }

            // Afisarea Mijlocasilor
            $query = "SELECT nume, numar_tricou FROM echipa_fotbal where post='Mijlocas'";
            $result = mysqli_query($id_conexiune, $query);
            print ("<h3>Mijlocasi</h3>");
            if (mysqli_num_rows($result)) {
                print ("<ul class=\"players-list\">\n");
                while ($row = mysqli_fetch_array($result)) {
                    $vnume = htmlspecialchars($row['nume']);
                    $vnumar_tricou = $row['numar_tricou'];
                    print ("<li><span class='shirt-number'>$vnumar_tricou</span> $vnume</li>\n");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista niciun mijlocas!</p>";
            }

            // Afisarea Atacantilor
            $query = "SELECT nume, numar_tricou FROM echipa_fotbal where post='Atacant'";
            $result = mysqli_query($id_conexiune, $query);
            print ("<h3>Atacanti</h3>");
            if (mysqli_num_rows($result)) {
                print ("<ul class=\"players-list\">\n");
                while ($row = mysqli_fetch_array($result)) {
                    $vnume = htmlspecialchars($row['nume']);
                    $vnumar_tricou = $row['numar_tricou'];
                    print ("<li><span class='shirt-number'>$vnumar_tricou</span> $vnume</li>\n");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista niciun atacant!</p>";
            }
            ?>
        </div>

        <!-- Afisarea echipei de baschet -->
        <div class="football-team">
            <h2 class="sport">Baschet</h2>
            <?php
            /** Afisarea fundasilor */
            $query = "SELECT nume, numar_tricou FROM echipa_baschet where post='fundas'";
            $result = mysqli_query($id_conexiune, $query);
            print ("<h3>Fundasi</h3>");
            if (mysqli_num_rows($result)) {
                print ("<ul class=\"players-list\">\n");
                while ($row = mysqli_fetch_array($result)) {
                    $vnume = htmlspecialchars($row['nume']);
                    $vnumar_tricou = $row['numar_tricou'];
                    print ("<li><span class='shirt-number'>$vnumar_tricou</span> $vnume</li>\n");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista niciun fundas!</p>";
            }

            // Afisarea Pivotilor
            $query = "SELECT nume, numar_tricou FROM echipa_baschet where post='Pivot'";
            $result = mysqli_query($id_conexiune, $query);
            print ("<h3>Pivoti</h3>");
            if (mysqli_num_rows($result)) {
                print ("<ul class=\"players-list\">\n");
                while ($row = mysqli_fetch_array($result)) {
                    $vnume = htmlspecialchars($row['nume']);
                    $vnumar_tricou = $row['numar_tricou'];
                    print ("<li><span class='shirt-number'>$vnumar_tricou</span> $vnume</li>\n");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista niciun pivot!</p>";
            }

            // Afisarea extremelor
            $query = "SELECT nume, numar_tricou FROM echipa_baschet where post='extrema'";
            $result = mysqli_query($id_conexiune, $query);
            print ("<h3>Extreme</h3>");
            if (mysqli_num_rows($result)) {
                print ("<ul class=\"players-list\">\n");
                while ($row = mysqli_fetch_array($result)) {
                    $vnume = htmlspecialchars($row['nume']);
                    $vnumar_tricou = $row['numar_tricou'];
                    print ("<li><span class='shirt-number'>$vnumar_tricou</span> $vnume</li>\n");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista nicio extrema!</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include "footer/footer.php"; ?>
</body>

</html>