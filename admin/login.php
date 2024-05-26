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
            case 'modify_announcement':
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comanda']) && $_POST['comanda'] === 'modify_announcement') {
                    // Handle form submission
                    $id = isset($_POST["id"]) ? $_POST["id"] : null;
                    $mesaj = isset($_POST["mesaj"]) ? $_POST["mesaj"] : null;

                    // Validate parameters
                    if ($id === null || $mesaj === null) {
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
        listAnunturi();
        include DIR_BASE . "admin/announcement-form.php";
        // echo "<div class='separator'>mai scrie ba ceva</div>";
    }
    ?>

</body>

</html>