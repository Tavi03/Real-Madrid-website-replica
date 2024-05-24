<?php
include "inc/config.php";
include "inc/connect.php";
include "inc/header.php";
?>
<h1>Carte de oaspeti</h1>
<?php
/* Definim si initializam cu sirul vid variabilele */
$nume = "";
$email = "";
$mesaj = "";
/* Presupunem ca nu avem erori de validare a parametrilor */
$eroareNume = "";
$eroareEmail = "";
$eroareMesaj = "";
$comanda = isset($_REQUEST["comanda"]) ? $_REQUEST["comanda"] : NULL;
if (isset($comanda)) {
    switch ($comanda) {

        case 'add': //Adauga un comentariu in guestbook
//Preluam parametri trimisi din forma de adaugare.
            $nume = isset($_REQUEST["nume"]) ? $_REQUEST["nume"] : NULL;
            $email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : NULL;
            $mesaj = isset($_REQUEST["mesaj"]) ? $_REQUEST["mesaj"] : NULL;
            //Validam parametri primiti.
            $valid = true;
            if (empty($nume)) {
                $eroareNume = "Numele nu poate fi vid!";
                $valid = false;
            }
            if (empty($email)) {
                $eroareEmail = "Emailul nu poate fi vid!";
                $valid = false;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $eroareEmail = "Emailul este invalid!";
                $valid = false;
            }
            if (empty($mesaj)) {
                $eroareMesaj = "Mesajul nu poate fi vid!";
                $valid = false;
            }
            if ($valid) {
                //Construim fraza SQL pentru inserarea mesajului.
/*
$sql = sprintf(
"INSERT INTO mesaje(nume, email, data, mesaj) VALUES ('%s','%s', CURDATE(), '%s')",
mysqli_real_escape_string($id_conexiune, $nume),
mysqli_real_escape_string($id_conexiune, $email),
mysqli_real_escape_string($id_conexiune, $mesaj)
);
if (!mysqli_query($id_conexiune, $sql)) {
die('Error: ' . mysqli_error($id_conexiune));
}
*/
                $stmt = mysqli_prepare(
                    $id_conexiune,

                    "INSERT INTO mesaje(nume, email, data, mesaj) VALUES (?,?, CURDATE(), ?)"
                );
                if (!mysqli_stmt_bind_param($stmt, "sss", $nume, $email, $mesaj)) {
                    die('Eroare legare parametri: ' . mysqli_stmt_error($stmt));

                }
                if (!mysqli_stmt_execute($stmt)) {

                    die('Eroare : ' . mysqli_stmt_error($stmt));
                }
                $nume = $email = $mesaj = "";
                echo "<div class='succes'>Mesajul tau a fost adaugat cu succes</div>";
            }
            break;
    }
}
?>
<?php
/** Afisarea mesajelor din guestbook */
$query = "SELECT nume, mesaj, data FROM mesaje";
$result = mysqli_query($id_conexiune, $query);
if (mysqli_num_rows($result)) {
    print ("<ul>\n");
    while ($row = mysqli_fetch_array($result)) {
        $vnume = htmlspecialchars($row['nume']);
        $vmesaj = htmlspecialchars($row['mesaj']);
        $vdata = $row['data'];
        print ("<li>Mesaj din data <b>$vdata</b> de la <b>$vnume</b>: <i>$vmesaj</i></li>\n");
    }
    print ("</ul>\n");
} else {
    print "Nu exista niciun mesaj!";
}
?>
<h2>Lasa un mesaj</h2>
<!-- Forma de adaugare mesaj-->
<form action="index.php" method="post">
    <input name="comanda" type="hidden" value="add" />
    <p>Nume*:
        <input type="text" name="nume" value="<?php echo htmlspecialchars($nume); ?>" size="30" />
        <span class="error"><?php echo $eroareNume; ?></span>
    </p>
    <p>Email*:
        <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" size="30" />
        <span class="error"><?php echo $eroareEmail; ?></span>

    </p>
    <p>Mesaj*: <span class="error"><?php echo $eroareMesaj; ?></span><br />
        <textarea name="mesaj" rows="5" cols="60"><?php echo htmlspecialchars($mesaj); ?></textarea>
    </p>
    <input type="submit" value="Adauga" />
    <input type="reset" value="Reset" />
</form>
<?php
include "inc/footer.php";
?>