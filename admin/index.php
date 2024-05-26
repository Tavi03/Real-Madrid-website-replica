<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "../inc/config.php";
    include DIR_BASE . "header.php";
    ?>
    <link rel="stylesheet" href="index.css">
    <title>Real Madrid C.F. | Sign in</title>
</head>

<body>

    <?php
    session_start();
    include DIR_BASE . "inc/connect.php";
    include DIR_BASE . "admin/admin-functions.php";
    ?>
    <div class="content">
        <h1>Administrare anunțuri și jucători Real Madrid</h1>
        <?php
        $comanda = isset($_REQUEST["comanda"]) ? $_REQUEST["comanda"] : NULL;
        if (isset($comanda)) {
            switch ($comanda) {
                case 'login':
                    $nume = $_REQUEST["nume"];
                    $parola = $_REQUEST["parola"];
                    //TODO: validare parametrii
                    if (!doLogin($nume, $parola)) {
                        echo "<div class='error'>Autentificare esuata!</div>";
                    }
                    break;
                case 'logout':
                    doLogout();
                    break;
            }
        }

        if (!isLogged()) {
            include "login-form.php";
        } else {
            printf('<div class="user-account">Welcome <b>%s</b> | <a href="index.php?comanda=logout">Logout</a></div>', getLoggedUser());
            /* Userul e autentificat */

            // Adaugare, modificare si stergere anunturi
            switch ($comanda) {
                case 'delete_announcement':
                    $id = $_REQUEST["id"];
                    //TODO: validare parametrii
                    if (deleteMesaj($id)) {
                        echo "<div class='succes'>Intrarea cu id-ul $id a fost stearsa cu succes.</div>";
                    } else {
                        echo "<div class='error'>Stergere esuata.</div>";
                    }
                    break;
                case 'add_announcement':
                    $mesaj = isset($_REQUEST["mesaj"]) ? $_REQUEST["mesaj"] : NULL;
                    if ($mesaj) {
                        $stmt = mysqli_prepare(
                            $id_conexiune,
                            "INSERT INTO anunturi(mesaj, data) VALUES (?, CURDATE())"
                        );
                        if (!mysqli_stmt_bind_param($stmt, "s", $mesaj)) {
                            die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));
                        }
                        if (!mysqli_stmt_execute($stmt)) {
                            die('Eroare : ' . mysqli_stmt_error($stmt));
                        }
                        $mesaj = "";
                        echo "<div class='succes'>Anuntul a fost adaugat cu succes!</div>";
                    } else {
                        echo "<div class='error'>Nu poti lasa campul gol!</div>";
                    }
                    break;
                case 'modify_announcement':
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comanda']) && $_POST['comanda'] === 'modify_announcement') {
                        // Handle form submission
                        $id = isset($_POST["id"]) ? $_POST["id"] : null;
                        $mesaj = isset($_POST["mesaj"]) ? $_POST["mesaj"] : null;

                        // Validate parameters
                        if ($id === null || $mesaj == "") {
                            $eroareMesaj = 'Parametrii invalidi.';
                        } else {
                            // Prepare the statement
                            $stmt = mysqli_prepare($id_conexiune, "UPDATE anunturi SET mesaj = ? WHERE id = ?");
                            if (!$stmt) {
                                die('Eroare pregatire statement: ' . mysqli_error($id_conexiune));
                            }

                            // Bind the parameters
                            if (!mysqli_stmt_bind_param($stmt, "si", $mesaj, $id)) {
                                die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));
                            }

                            // Execute the statement
                            if (!mysqli_stmt_execute($stmt)) {
                                die('Eroare executie: ' . mysqli_stmt_error($stmt));
                            }

                            // Clear the message
                            $mesaj = "";

                            // Close the statement
                            mysqli_stmt_close($stmt);

                            // Output success message
                            echo "<div class='succes'>Anuntul a fost modificat cu succes!</div>";
                        }
                    } else {
                        // Display the form when 'modify' case is triggered
                        if (isset($_REQUEST["id"])) {
                            $id = $_REQUEST["id"];
                            // Fetch the current message if needed for displaying in the form
                            $stmt = mysqli_prepare($id_conexiune, "SELECT mesaj FROM anunturi WHERE id = ?");
                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "i", $id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $mesaj);
                                mysqli_stmt_fetch($stmt);
                                mysqli_stmt_close($stmt);
                            }
                        }
                        include "modify-announcement-form.php";
                    }
                    break;

                default:
            }
            echo "<div class='section'>";
            listAnunturi();
            include DIR_BASE . "admin/announcement-form.php";
            echo "</div>";
            echo "<div class='separator'></div>";

            // Adaugare, modificare si stergere jucatori de fotbal
            switch ($comanda) {
                case 'delete_football_player':
                    $id = $_REQUEST["id"];
                    //TODO: validare parametrii
                    if (deleteFootballPlayer($id)) {
                        echo "<div class='succes'>Intrarea cu id-ul $id a fost stearsa cu succes.</div>";
                    } else {
                        echo "<div class='error'>Stergere esuata.</div>";
                    }
                    break;
                case 'add_football_player':
                    $nume = isset($_REQUEST["nume"]) ? $_REQUEST["nume"] : NULL;
                    $post = isset($_REQUEST["post"]) ? $_REQUEST["post"] : NULL;
                    $numar_tricou = isset($_REQUEST["numar_tricou"]) ? $_REQUEST["numar_tricou"] : NULL;
                    $stmt = mysqli_prepare(
                        $id_conexiune,
                        "INSERT INTO echipa_fotbal(post, nume, numar_tricou) VALUES (?, ?, ?)"
                    );
                    if (!mysqli_stmt_bind_param($stmt, "ssi", $post, $nume, $numar_tricou)) {
                        die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));
                    }
                    if (!mysqli_stmt_execute($stmt)) {
                        die('Eroare : ' . mysqli_stmt_error($stmt));
                    }
                    echo "<div class='succes'>Jucatorul $nume a fost adaugat cu succes!</div>";
                    $post = "";
                    $nume = "";
                    $numar_tricou = "";
                    break;
                case 'modify_football_player':
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comanda']) && $_POST['comanda'] === 'modify_football_player') {
                        // Handle form submission
                        $id = isset($_POST["id"]) ? $_POST["id"] : null;
                        $nume = isset($_POST["nume"]) ? $_POST["nume"] : null;
                        $post = isset($_POST["post"]) ? $_POST["post"] : null;
                        $numar_tricou = isset($_POST["numar_tricou"]) ? $_POST["numar_tricou"] : null;

                        // Validate parameters
                        if ($id === null || $nume === null || $post === null || $numar_tricou === null) {
                            $eroareMesaj = 'Parametrii invalizi.';
                            echo "<div class='error'>$eroareMesaj</div>";
                        } else {
                            // Prepare the statement
                            $stmt = mysqli_prepare($id_conexiune, "UPDATE echipa_fotbal 
                        SET nume = ?,
                        post = ?,
                        numar_tricou = ?  
                        WHERE id = ?");
                            if (!$stmt) {
                                die('Eroare pregatire statement: ' . mysqli_error($id_conexiune));
                            }

                            // Bind the parameters
                            if (!mysqli_stmt_bind_param($stmt, "ssii", $nume, $post, $numar_tricou, $id)) {
                                die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));
                            }

                            // Execute the statement
                            if (!mysqli_stmt_execute($stmt)) {
                                die('Eroare executie: ' . mysqli_stmt_error($stmt));
                            }

                            // Clear the message
                            echo "<div class='succes'>Jucatorul $nume a fost modificat cu succes!</div>";
                            $nume = "";
                            $post = "";
                            $numar_tricou = "";

                            // Close the statement
                            mysqli_stmt_close($stmt);

                        }
                    } else {
                        // Display the form when 'modify' case is triggered
                        if (isset($_REQUEST["id"])) {
                            $id = $_REQUEST["id"];
                            // Fetch the current message if needed for displaying in the form
                            $stmt = mysqli_prepare($id_conexiune, "SELECT nume, post, numar_tricou FROM echipa_fotbal WHERE id = ?");
                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "i", $id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $nume, $post, $numar_tricou);
                                mysqli_stmt_fetch($stmt);
                                mysqli_stmt_close($stmt);
                            }
                        }
                        include "modify-football-player-form.php";
                    }
                    break;
                default:
            }
            echo "<div class='section'>";
            listJucatoriFotbal();
            include DIR_BASE . "admin/football-player-form.php";
            echo "</div>";
            echo "<div class='separator'></div>";

            // Adaugare, modificare si stergere jucatori de baschet
            switch ($comanda) {
                case 'delete_basketball_player':
                    $id = $_REQUEST["id"];
                    //TODO: validare parametrii
                    if (deleteBasketballPlayer($id)) {
                        echo "<div class='succes'>Intrarea cu id-ul $id a fost stearsa cu succes.</div>";
                    } else {
                        echo "<div class='error'>Stergere esuata.</div>";
                    }
                    break;
                case 'add_basketball_player':
                    $nume = isset($_REQUEST["nume"]) ? $_REQUEST["nume"] : NULL;
                    $post = isset($_REQUEST["post"]) ? $_REQUEST["post"] : NULL;
                    $numar_tricou = isset($_REQUEST["numar_tricou"]) ? $_REQUEST["numar_tricou"] : NULL;
                    $stmt = mysqli_prepare(
                        $id_conexiune,
                        "INSERT INTO echipa_baschet(post, nume, numar_tricou) VALUES (?, ?, ?)"
                    );
                    if (!mysqli_stmt_bind_param($stmt, "ssi", $post, $nume, $numar_tricou)) {
                        die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));
                    }
                    if (!mysqli_stmt_execute($stmt)) {
                        die('Eroare : ' . mysqli_stmt_error($stmt));
                    }
                    echo "<div class='succes'>Jucatorul $nume a fost adaugat cu succes!</div>";
                    $post = "";
                    $nume = "";
                    $numar_tricou = "";
                    break;
                case 'modify_basketball_player':
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comanda']) && $_POST['comanda'] === 'modify_basketball_player') {
                        // Handle form submission
                        $id = isset($_POST["id"]) ? $_POST["id"] : null;
                        $nume = isset($_POST["nume"]) ? $_POST["nume"] : null;
                        $post = isset($_POST["post"]) ? $_POST["post"] : null;
                        $numar_tricou = isset($_POST["numar_tricou"]) ? $_POST["numar_tricou"] : null;

                        // Validate parameters
                        if ($id === null || $nume === null || $post === null || $numar_tricou === null) {
                            $eroareMesaj = 'Parametrii invalizi.';
                            echo "<div class='error'>$eroareMesaj</div>";
                        } else {
                            // Prepare the statement
                            $stmt = mysqli_prepare($id_conexiune, "UPDATE echipa_baschet 
                        SET nume = ?,
                        post = ?,
                        numar_tricou = ?  
                        WHERE id = ?");
                            if (!$stmt) {
                                die('Eroare pregatire statement: ' . mysqli_error($id_conexiune));
                            }

                            // Bind the parameters
                            if (!mysqli_stmt_bind_param($stmt, "ssii", $nume, $post, $numar_tricou, $id)) {
                                die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));
                            }

                            // Execute the statement
                            if (!mysqli_stmt_execute($stmt)) {
                                die('Eroare executie: ' . mysqli_stmt_error($stmt));
                            }

                            // Clear the message
                            echo "<div class='succes'>Jucatorul $nume a fost modificat cu succes!</div>";
                            $nume = "";
                            $post = "";
                            $numar_tricou = "";

                            // Close the statement
                            mysqli_stmt_close($stmt);

                        }
                    } else {
                        // Display the form when 'modify' case is triggered
                        if (isset($_REQUEST["id"])) {
                            $id = $_REQUEST["id"];
                            // Fetch the current message if needed for displaying in the form
                            $stmt = mysqli_prepare($id_conexiune, "SELECT nume, post, numar_tricou FROM echipa_baschet WHERE id = ?");
                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "i", $id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $nume, $post, $numar_tricou);
                                mysqli_stmt_fetch($stmt);
                                mysqli_stmt_close($stmt);
                            }
                        }
                        include "modify-basketball-player-form.php";
                    }
                    break;
                default:
            }
            echo "<div class='section'>";
            listJucatoriBaschet();
            include DIR_BASE . "admin/basketball-player-form.php";
            echo "</div>";
        }
        ?>
    </div>

</body>

</html>