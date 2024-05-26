<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "../inc/config.php";
    include DIR_BASE . "header.php";
    ?>
    <link rel="stylesheet" href="login.css">
    <title>Real Madrid C.F. | Sign in</title>
</head>

<body>

    <?php
    session_start();
    include DIR_BASE . "inc/connect.php";
    include DIR_BASE . "admin/admin-functions.php";
    ?>
    <h1>Administrare Anunturi Real Madrid</h1>
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
        printf('<div align="right">Welcome <b>%s</b> | <a href="login.php?comanda=logout">Logout</a></div>', getLoggedUser());
        /* Userul e autentificat */
        switch ($comanda) {
            case 'delete':
                $id = $_REQUEST["id"];
                //TODO: validare parametrii
                if (deleteMesaj($id)) {
                    echo "<div class='succes'>Intrarea cu id-ul $id a fost stearsa cu succes.</div>";
                } else {
                    echo "<div class='error'>Stergere esuata.</div>";
                }
                break;
            case 'add':
                $mesaj = isset($_REQUEST["mesaj"]) ? $_REQUEST["mesaj"] : NULL;
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
                break;
            case 'modify':
                $id = $_REQUEST["id"];
                $mesaj = isset($_REQUEST["mesaj"]) ? $_REQUEST["mesaj"] : NULL;
                
                //TODO: validare parametrii
                $stmt = mysqli_prepare(
                    $id_conexiune,
                    "UPDATE anunturi set mesaj = ? WHERE id = ?"
                );
                if (!$stmt) {
                    die('Eroare pregatire statement: ' . mysqli_error($id_conexiune));
                }
                if (!mysqli_stmt_bind_param($stmt, "si", $mesaj, $id)) {
                    die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));
                }
                if (!mysqli_stmt_execute($stmt)) {
                    die('Eroare : ' . mysqli_stmt_error($stmt));
                }
                $mesaj = "";
                echo "<div class='succes'>Anuntul a fost modificat cu succes!</div>";
                break;
            default:
        }
        listAnunturi();
        include DIR_BASE . "admin/announcement-form.php";
    }
    ?>
</body>

</html>