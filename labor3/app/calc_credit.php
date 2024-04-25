<?php
require_once dirname(__FILE__).'/../config.php';

//załaduj Smarty
require_once _ROOT_PATH.'/lib/smarty/Smarty.class.php';

//pobranie parametrów
function getParams(&$form){
	$form['amount'] = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
	$form['numOfInst'] = isset($_REQUEST['numOfInst']) ? $_REQUEST['numOfInst'] : null;
	$form['interest'] = isset($_REQUEST['interest']) ? $_REQUEST['interest'] : null;	
}


//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form,&$infos,&$msgs,&$hide_intro){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form['amount']) && isset($form['numOfInst']) && isset($form['interest']))) {
		return false;
	}
        
        $hide_intro = true;

	$infos [] = 'Przekazano parametry.';

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ($form['amount'] == "") {
            $msgs [] = 'Nie podano kwoty porzyczki';
	}
	if ($form['numOfInst'] == "") {
            $msgs [] = 'Nie podano liczby rat';
	}
        if ($form['interest'] == "") {
            $msgs [] = 'Nie podano oprocentowania';
        }

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ($msgs) == 0) {
                if (! is_numeric( $form['amount'] )) {
                    $msgs [] = 'Pierwsza wartość nie jest liczbą całkowitą';
            }
                if (! is_numeric( $form['numOfInst'] )) {
                    $msgs [] = 'Druga wartość nie jest liczbą całkowitą';
            }
                if (! is_numeric( $form['interest'])) {
                    $msgs [] = 'Trzecia wartość nie jest liczbą rzeczywista';
            }
        }
	if (count($msgs) > 0) {
            return false;
        }
        else {
            return true;
        }
}

function process(&$form,&$infos,&$msgs,&$result){
    
    $infos [] = 'Parametry poprawne. Wykonuję obliczenia.';
	
    //konwersja parametrów na int
    $form['amount'] = intval($form['amount']);
    $form['numOfInst'] = intval($form['numOfInst']);
    $form['interest'] = floatval($form['interest']);
        
    $result = ($form['amount'] + $form['amount'] * $form['interest'] / 100) / $form['numOfInst'];
	
}


//definicja zmiennych kontrolera
$form = null;
$infos = array();
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($form);
if ( validate($form,$infos,$messages,$hide_intro) ) { // gdy brak błędów
	process($form,$infos,$messages,$result);
}

//include 'calc_credit_view.php';

$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Labor3');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/calc_credit.html');