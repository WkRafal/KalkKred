<?php
require_once dirname(__FILE__).'/../config.php';

$amount = $_REQUEST ['x'];
$numOfInst = $_REQUEST ['y'];
$interest = $_REQUEST ['z'];

if ( ! (isset($amount) && isset($numOfInst) && isset($interest))) {
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

if ( $amount == "") {
	$messages [] = 'Nie podano kwoty porzyczki';
}
if ( $numOfInst == "") {
	$messages [] = 'Nie podano liczby rat';
}
if ( $interest == "") {
        $messages [] = 'Nie podano oprocentowania';
}

if (empty( $messages )) {
	
	if (! is_numeric( $amount )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $numOfInst )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}
        
        if (! is_numeric( $interest)) {
                $messages [] = 'Trzecia wartość nie jest liczbą rzeczywista';
        }

}

if (empty ( $messages )) {
    
	$amount = intval($amount);
	$numOfInst = intval($numOfInst);
	$interest = floatval($interest);
	
	$result = ($amount + $amount*$interest/100)/$numOfInst; 
}

include 'calc_credit_view.php';