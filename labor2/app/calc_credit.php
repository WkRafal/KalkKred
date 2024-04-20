<?php
require_once dirname(__FILE__).'/../config.php';

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$amount,&$numOfInst,&$interest){
	$amount = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
	$numOfInst = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
	$interest = isset($_REQUEST['z']) ? $_REQUEST['z'] : null;	
}


//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$amount,&$numOfInst,&$interest,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($amount) && isset($numOfInst) && isset($interest))) {
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ($amount == "") {
            $messages [] = 'Nie podano kwoty porzyczki';
	}
	if ($numOfInst == "") {
            $messages [] = 'Nie podano liczby rat';
	}
        if ($interest == "") {
            $messages [] = 'Nie podano oprocentowania';
        }

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) {
            return false;
        }
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $amount )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $numOfInst )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}
        
        if (! is_numeric( $interest)) {
                $messages [] = 'Trzecia wartość nie jest liczbą rzeczywista';
        }

	if (count ( $messages ) != 0) {
            return false;
        }
       
	else {
            return true;
        }
}

function process(&$amount,&$numOfInst,&$interest,&$messages,&$result){
	global $role;
	
	//konwersja parametrów na int
	$amount = intval($amount);
	$numOfInst = intval($numOfInst);
        $interest = floatval($interest);
        
        if ($role == 'admin'){
				$result = ($amount + $amount*$interest/100)/$numOfInst;
			} else {
				$messages [] = 'Tylko administrator może odejmować !';
			}
}


//definicja zmiennych kontrolera
$amount = null;
$numOfInst = null;
$interest = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($amount,$numOfInst,$interest);
if ( validate($amount,$numOfInst,$interest,$messages) ) { // gdy brak błędów
	process($amount,$numOfInst,$interest,$messages,$result);
}

include 'calc_credit_view.php';