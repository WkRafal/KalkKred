<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator Kredytowy</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/calc_credit.php" method="post">
	<label for="id_x">Kwota kredytu: </label>
        <input id="id_x" type="text" name="x" value="<?php if(isset($amount)){ print($amount); } ?>" /><br />
        <label for="id_y">Liczba rat: </label>
        <input id="id_y" type="text" name="y" value="<?php if(isset($numOfInst)){ print($numOfInst); } ?>" /><br />
        <label for="id_z">Oprocentowanie: </label>
        <input id="id_z" type="text" name="z" value="<?php if(isset($interest)){ print($interest); } ?>" /><br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Wysokość raty: '.$result; ?>
</div>
<?php } ?>

</body>
</html>