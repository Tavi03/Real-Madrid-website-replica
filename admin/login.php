<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="login.css">
    <title>Real Madrid C.F. | Sign in</title>
</head>

<body>

    <?php
    session_start();
    require_once "../inc/config.php";
    include DIR_BASE . "inc/connect.php";
    include DIR_BASE . "admin/admin-functions.php";
    include DIR_BASE . "header.php";
    ?>
    <h1>Administrare Real Madrid</h1>
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
        printf('<div align="right">Welcome <b>%s</b> | <a href="index.php?comanda=logout">Logout</a></div>', getLoggedUser());
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
            default:
        }
        listMesaje();
        include DIR_BASE. "admin/announcement-form.php";
    }
    ?>
    <?php
    include DIR_BASE . "footer/footer.php";
    ?>
</body>

</html>