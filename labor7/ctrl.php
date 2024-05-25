<?php

require_once 'init.php';

//getConf()->login_action = 'login';
//
//switch ($action) {
//	default :
//            control('app\\controllers', 'CalcCtrl', 'generateView', ['user','admin']);
//	case 'login': 
//            control('app\\controllers', 'LoginCtrl', 'doLogin');
//	case 'calcCredit' : 
//            control(null, 'CalcCtrl', 'process', ['user','admin']);
//	case 'logout' : 
//            control(null, 'LoginCtrl', 'doLogout', ['user','admin']);
//}

getRouter()->setDefaultRoute('calcShow'); // akcja/ścieżka domyślna
getRouter()->setLoginRoute('login'); // akcja/ścieżka na potrzeby logowania (przekierowanie, gdy nie ma dostępu)

getRouter()->addRoute('calcShow',    'CalcCtrl',  ['user','admin']);
getRouter()->addRoute('calcCredit', 'CalcCtrl',  ['user','admin']);
getRouter()->addRoute('login',       'LoginCtrl');
getRouter()->addRoute('logout',      'LoginCtrl', ['user','admin']);
getRouter()->addRoute('results',      'ResultsCtrl', ['user','admin']);

getRouter()->go();
