<?php

require_once 'init.php';

getConf()->login_action = 'login';


//2. wykonanie akcji
//switch ($action) {
//	default : // 'calcView'
//	    // załaduj definicję kontrolera
//            // utwórz obiekt i uzyj
//            $ctrl = new app\controllers\CalcCtrl();
//            $ctrl->generateView ();
//	break;
//	case 'calcCredit' :
//            // załaduj definicję kontrolera
//            // utwórz obiekt i uzyj
//            $ctrl = new app\controllers\CalcCtrl();
//            $ctrl->process ();
//	break;
//}

switch ($action) {
	default :
            control('app\\controllers', 'CalcCtrl', 'generateView', ['user','admin']);
	case 'login': 
            control('app\\controllers', 'LoginCtrl', 'doLogin');
	case 'calcCredit' : 
            control(null, 'CalcCtrl', 'process', ['user','admin']);
	case 'logout' : 
            control(null, 'LoginCtrl', 'doLogout', ['user','admin']);
}

