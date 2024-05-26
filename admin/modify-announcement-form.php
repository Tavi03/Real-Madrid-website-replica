<?php $eroareMesaj = "";
$eroareData = "";
?>

<h2>Modifica un anunt</h2>
<!-- Forma de modificare a unui mesaj -->
<form action="index.php" method="post">
    <input name="comanda" type="hidden" value="modify_announcement" />
    <input name="id" type="hidden" value="<?php echo htmlspecialchars($id); ?>" />
    <p>Mesaj: <span class="error"><?php echo $eroareMesaj; ?></span><br />
        <textarea name="mesaj" rows="5" cols="60"><?php echo htmlspecialchars($mesaj); ?></textarea>
    </p>
    <input type="submit" value="Modifica" />
    <input type="reset" value="Reseteaza" />
</form>