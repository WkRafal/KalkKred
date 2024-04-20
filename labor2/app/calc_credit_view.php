<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Kalkulator Kredytowy</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>
    
<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/instruktarz.php" class="pure-button">instruktarz</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>
    
<div style="width:90%; margin: 2em auto;">

    <form action="<?php print(_APP_URL);?>/app/calc_credit.php" method="post" class="pure-form pure-form-stacked">
        <legend>Kalkulator Kredytowy</legend>
        <fieldset>
            <label for="id_x">Kwota kredytu: </label>
            <input id="id_x" type="text" name="x" value="<?php out($x) ?>" /><br />
            <label for="id_y">Liczba rat: </label>
            <input id="id_y" type="text" name="y" value="<?php out($y) ?>" /><br />
            <label for="id_z">Oprocentowanie: </label>
            <input id="id_z" type="text" name="z" value="<?php out($z) ?>" /><br />
            <input type="submit" value="Oblicz" class="pure-form pure-form-stacked"/>
        </fieldset>
    </form>	

    <?php
    //wyświeltenie listy błędów, jeśli istnieją
    if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
    }
    ?>

    <?php if (isset($result)){ ?>
    <div style="margin-top: 1em; padding: 1em; border-radius: 0.5em; background-color: #ff0; width:25em;">
    <?php echo 'Wysokość raty: '.$result; ?>
    </div>
    <?php } ?>
    
</div>

</body>
</html>