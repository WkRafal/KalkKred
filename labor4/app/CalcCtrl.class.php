<?php
require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/CalcForm.class.php';
require_once $conf->root_path.'/app/CalcResult.class.php';

class CalcCtrl{
    
    private $msgs;
    private $form;
    private $result;
    
    public function __construct(){
        $this->msgs = new Messages();
        $this->form = new CalcForm();
        $this->result = new CalcResult();
    }

    public function getParams(){
        $this->form->amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
	$this->form->numOfInst = isset($_REQUEST['numOfInst']) ? $_REQUEST['numOfInst'] : null;
	$this->form->interest = isset($_REQUEST['interest']) ? $_REQUEST['interest'] : null;	
    }


    //walidacja parametrów z przygotowaniem zmiennych dla widoku
    public function validate(){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($this->form->amount) && isset($this->form->numOfInst) && isset($this->form->interest))) {
		return false;
	}

        // sprawdzenie, czy potrzebne wartości zostały przekazane
	if ($this->form->amount == "") {
            $this->msgs->addError('Nie podano kwoty porzyczki');
	}
	if ($this->form->numOfInst == "") {
            $this->msgs->addError('Nie podano liczby rat');
	}
        if ($this->form->interest == "") {
            $this->msgs->addError('Nie podano oprocentowania');
        }

	//nie ma sensu walidować dalej gdy brak parametrów
	if (! $this->msgs->isError()) {
                if (! is_numeric( $this->form->amount )) {
                    $this->msgs->addError('Pierwsza wartość nie jest liczbą całkowitą');
            }
                if (! is_numeric( $this->form->numOfInst )) {
                    $this->msgs->addError('Druga wartość nie jest liczbą całkowitą');
            }
                if (! is_numeric( $this->form->interest)) {
                    $this->msgs->addError('Trzecia wartość nie jest liczbą rzeczywista');
            }
        }
	return ! $this->msgs->isError();
    }

    public function process(){
   
        $this->getParams();
    
        if ($this->validate()){
	
    //konwersja parametrów na int
            $this->form->amount = intval($this->form->amount);
            $this->form->numOfInst = intval($this->form->numOfInst);
            $this->form->interest = floatval($this->form->interest);
            
            $this->msgs->addInfo('Parametry poprawne.');
        
            $this->result->result = ($this->form->amount + $this->form->amount * $this->form->interest / 100) / $this->form->numOfInst;
            
            $this->msgs->addInfo('Wykonano obliczenia.');
    
	}
        
        $this->generateView();
        
    }

    public function generateView(){
        global $conf;

        $smarty = new Smarty();

        $smarty->assign('conf',$conf);
        
        $smarty->assign('page_title','Labor4');
        $smarty->assign('page_description','Obiektowość. Funkcjonalność aplikacji zamknięta w metodach różnych obiektów. Pełen model MVC.');
        $smarty->assign('page_header','Obiekty w PHP');

        //pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
        $smarty->assign('form', $this->form);
        $smarty->assign('result', $this->result);
        $smarty->assign('msgs', $this->msgs);

        $smarty->display($conf->root_path.'/app/calc_credit.tlp');
    }

}
