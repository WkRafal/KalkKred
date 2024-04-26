<?php

require_once 'init.php';

//2. wykonanie akcji
switch ($action) {
	default : // 'calcView'
	    // załaduj definicję kontrolera
            // utwórz obiekt i uzyj
            $ctrl = new app\controllers\CalcCtrl();
            $ctrl->generateView ();
	break;
	case 'calcCredit' :
            // załaduj definicję kontrolera
            // utwórz obiekt i uzyj
            $ctrl = new app\controllers\CalcCtrl();
            $ctrl->process ();
	break;
}

