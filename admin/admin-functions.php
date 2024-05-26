<?php
/**
 * Verifica detaliile de autentificare transmise ca parametru.
 * In caz de succes stocheaza in sesiune proprietatile:
 * 'user' - userul logat
 * 'logat' - cu valoarea TRUE
 */
function doLogin($user, $password)
{
    global $id_conexiune;
    $logat = FALSE;
    if (isLogged())
        doLogout();


    //$sql = "SELECT * FROM admin WHERE nume='$user' AND parola= md5('$password')";//Gresit! Permite SQL Injection
    $sql = sprintf(
        "SELECT * FROM admin WHERE nume='%s' AND parola= md5('%s')",
        mysqli_real_escape_string($id_conexiune, $user),
        mysqli_real_escape_string($id_conexiune, $password)
    );
    //echo "Query: $sql <br>";
    if (!($result = mysqli_query($id_conexiune, $sql))) {
        echo ('Error: ' . mysqli_error($id_conexiune));
    }
    if ($row = mysqli_fetch_array($result)) {
        $logat = TRUE;
        $_SESSION['user'] = $user;
        $_SESSION['logat'] = TRUE;
    }
    return $logat;
}
/**
 * Sterge din sesiune variabilele stocate la autentificare.
 */
function doLogout()
{
    unset($_SESSION['user']);
    unset($_SESSION['logat']);
}
/**
 * Verifica daca userul este logat sau nu.
 */
function isLogged()
{
    return isset($_SESSION['logat']) && $_SESSION['logat'] == TRUE;
}
/**
 * Extrage din sesiune numele userului logat.
 */
function getLoggedUser()
{
    return isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
}
/**
 * Sterge inregistrarea cu id-ul specificat.
 */
function deleteMesaj($id)
{
    global $id_conexiune;
    if (is_numeric($id)) {
        $sql = sprintf("DELETE FROM anunturi WHERE id=%d", $id);
        //echo "Query: $sql <br>";
        if (!mysqli_query($id_conexiune, $sql)) {
            die('Error: ' . mysqli_error($id_conexiune));
        }
        return TRUE;
    } else {
        return FALSE;
    }
}
function listAnunturi()
{
    global $id_conexiune;
    $query = "SELECT id, mesaj, data FROM anunturi order by data desc";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            print ('<p>');
            print ('<span>' . htmlspecialchars($row['id']) . '  </span>');
            print ('<span>' . htmlspecialchars($row['mesaj']) . '   </span>');
            print ('<span>' . htmlspecialchars($row['data']) . '    </span>');
            print ("<a href='login.php?comanda=delete_announcement&id=" . $row['id'] . "'>Delete</a>\n");    
            print ("<a href='login.php?comanda=modify_announcement&id=" . $row['id'] . "&mesaj=" . $row['mesaj'] . "'>Modifica</a>\n");
            print ('</p>');
        }
    } else {
        print "Nu exista anunturi!";
    }
}

function listJucatoriFotbal()
{
    global $id_conexiune;
    $query = "SELECT nume, post, numar_tricou FROM echipa_fotbal order by post desc";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            print ('<p>');
            print ('<span>' . htmlspecialchars($row['nume']) . '  </span>');
            print ('<span>' . htmlspecialchars($row['post']) . '   </span>');
            print ('<span>' . htmlspecialchars($row['numar_tricou']) . '    </span>');
            print ("<a href='login.php?comanda=delete_football_player&id=" . $row['id'] . "'>Delete</a>\n");    
            print ("<a href='login.php?comanda=modify_football_player&id=" . $row['id'] . "&mesaj=" . $row['mesaj'] . "'>Modifica</a>\n");
            print ('</p>');
        }
    } else {
        print "Nu exista jucatori de fotbal!";
    }
}

function listJucatoriBaschet()
{
    global $id_conexiune;
    $query = "SELECT nume, post, numar_tricou FROM echipa_baschet order by post desc";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            print ('<p>');
            print ('<span>' . htmlspecialchars($row['nume']) . '  </span>');
            print ('<span>' . htmlspecialchars($row['post']) . '   </span>');
            print ('<span>' . htmlspecialchars($row['numar_tricou']) . '    </span>');
            print ("<a href='login.php?comanda=delete_basketball_player&id=" . $row['id'] . "'>Delete</a>\n");    
            print ("<a href='login.php?comanda=modify_basketball_player&id=" . $row['id'] . "&mesaj=" . $row['mesaj'] . "'>Modifica</a>\n");
            print ('</p>');
        }
    } else {
        print "Nu exista jucatori de baschet!";
    }
}