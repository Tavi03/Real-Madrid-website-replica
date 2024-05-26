<?php
$eroareNume = "";
$eroarePost = "";
$eroareNumarTricou = "";
$nume = "";
$post = "";
$numar_tricou = "";
?>

<h2>Adauga un jucator de fotbal</h2>
<!-- Forma de adaugare jucator -->
<form action="index.php" method="post">
    <input name="comanda" type="hidden" value="add_football_player" />
    
    <p>Nume: <span class="error"><?php echo $eroareNume; ?></span><br />
        <input type="text" name="nume" value="<?php echo htmlspecialchars($nume); ?>" />
    </p>
    
    <p>Post: <span class="error"><?php echo $eroarePost; ?></span><br />
        <input type="text" name="post" value="<?php echo htmlspecialchars($post); ?>" />
    </p>
    
    <p>Numar Tricou: <span class="error"><?php echo $eroareNumarTricou; ?></span><br />
        <input type="text" name="numar_tricou" value="<?php echo htmlspecialchars($numar_tricou); ?>" />
    </p>
    
    <input type="submit" value="Adauga" />
    <input type="reset" value="Reseteaza" />
</form>
