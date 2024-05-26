<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php" ?>
    <link rel="stylesheet" href="styles/anunturistyle.css">
    <title>Real Madrid C.F. | Anunturi</title>
</head>

<body>
    <!-- Navbar -->
    <?php include "navbar/navbar.php"; ?>

    <!-- Header -->
    <div class="header">
        <h1>
            Anunturi
        </h1>
        <img src="images/contact/real madrid logo gri.svg" alt="real madrid logo">
    </div>
    <!-- Header end -->

    <!-- Content -->
    <div class="content">
        <div class="announcements">
            <?php
            include "inc/config.php";
            include "inc/connect.php";

            /** Afisarea anunturilor */
            $query = "SELECT mesaj, data FROM anunturi order by data desc";
            $result = mysqli_query($id_conexiune, $query);
            if (mysqli_num_rows($result)) {
                print ("<ul>");
                while ($row = mysqli_fetch_array($result)) {
                    $vmesaj = htmlspecialchars($row['mesaj']);
                    $vdata = $row['data'];
                    print ("<li class=\"announcement-card\"><p>$vmesaj</p> <span>$vdata</span></li>");
                }
                print ("</ul>\n");
            } else {
                print "<p>Nu exista niciun portar!</p>";
            }
            ?>
        </div>
    </div>

    <?php include DIR_BASE."footer/footer.php"?>
</body>

</html>