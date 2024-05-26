<?php
$eroareMesaj = "";
$eroareData = "";
$mesaj = "";
$data = "";
?>

<h2>Posteaza un anunt</h2>
<!-- Forma de adaugare mesaj-->
<form action="login.php" method="post">
    <input name="comanda" id="mesaj" type="hidden" value="add_announcement" />
    <p>Mesaj: <span class="error"><?php echo $eroareMesaj; ?></span><br />
        <textarea name="mesaj" rows="5" cols="60"><?php echo htmlspecialchars($mesaj); ?></textarea>
        <!-- <input type="text" name="mesaj" id="mesaj" size="30" value="echo htmlspecialchars($mesaj);"> -->
    </p>
    <input type="submit" value="Adauga" />
    <input type="reset" value="Reseteaza" />
</form>