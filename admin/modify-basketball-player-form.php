<?php 
$eroareNume = "";
$eroarePost = "";
$eroareNumarTricou = "";
?>

<h2>Modifica un jucator de basket</h2>
<!-- Forma de modificare a unui jucator de basket -->
<form action="index.php" method="post">
    <input name="comanda" type="hidden" value="modify_basketball_player" />
    <input name="id" type="hidden" value="<?php echo htmlspecialchars($id); ?>" />
    
    <p>Nume: <span class="error"><?php echo $eroareNume; ?></span><br />
        <input type="text" name="nume" value="<?php echo htmlspecialchars($nume); ?>" />
    </p>
    
    <p>Post: <span class="error"><?php echo $eroarePost; ?></span><br />
        <input type="text" name="post" value="<?php echo htmlspecialchars($post); ?>" />
    </p>
    
    <p>Numar Tricou: <span class="error"><?php echo $eroareNumarTricou; ?></span><br />
        <input type="text" name="numar_tricou" value="<?php echo htmlspecialchars($numar_tricou); ?>" />
    </p>
    
    <input type="submit" value="Modifica" />
    <input type="reset" value="Reseteaza" />
</form>