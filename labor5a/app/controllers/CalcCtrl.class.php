<?php

namespace app\controllers;

use app\forms\CalcForm;
use app\transfer\CalcResult;

class CalcCtrl{

    private $form;
    private $result;
    
    public function __construct(){
        $this->form = new CalcForm();
        $this->result = new CalcResult();
    }

    public function getParams(){
        $this->form->amount = getFromRequest('amount');
	$this->form->numOfInst = getFromRequest('numOfInst');
	$this->form->interest = getFromRequest('interest');
    }


    //walidacja parametrów z przygotowaniem zmiennych dla widoku
    public function validate(){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($this->form->amount) && isset($this->form->numOfInst) && isset($this->form->interest))) {
		return false;
	}

        // sprawdzenie, czy potrzebne wartości zostały przekazane
	if ($this->form->amount == "") {
            getMessages()->addError('Nie podano kwoty porzyczki');
	}
	if ($this->form->numOfInst == "") {
            getMessages()->addError('Nie podano liczby rat');
	}
        if ($this->form->interest == "") {
            getMessages()->addError('Nie podano oprocentowania');
        }

	//nie ma sensu walidować dalej gdy brak parametrów
	if (! getMessages()->isError()) {
                if (! is_numeric( $this->form->amount )) {
                    getMessages()->addError('Pierwsza wartość nie jest liczbą całkowitą');
            }
                if (! is_numeric( $this->form->numOfInst )) {
                    getMessages()->addError('Druga wartość nie jest liczbą całkowitą');
            }
                if (! is_numeric( $this->form->interest)) {
                    getMessages()->addError('Trzecia wartość nie jest liczbą rzeczywista');
            }
        }
	return ! getMessages()->isError();
    }

    public function process(){
   
        $this->getParams();
    
        if ($this->validate()){
	
    //konwersja parametrów na int
            $this->form->amount = intval($this->form->amount);
            $this->form->numOfInst = intval($this->form->numOfInst);
            $this->form->interest = floatval($this->form->interest);
            
            getMessages()->addInfo('Parametry poprawne.');
        
            $this->result->result = ($this->form->amount + $this->form->amount * $this->form->interest / 100) / $this->form->numOfInst;
            
            getMessages()->addInfo('Wykonano obliczenia.');
    
	}
        
        $this->generateView();
        
    }

    public function generateView(){
                
        getSmarty()->assign('page_title','Labor5a');
        getSmarty()->assign('page_description','Zmiana w postaci nowej struktury foderów, skryptu inicjalizacji oraz pomocniczych funkcji i dołożono automatyczne ładowanie klas wykorzystując w strukturze przestrzenie nazw..');
        getSmarty()->assign('page_header','Kontroler główny');

        //pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
        getSmarty()->assign('form', $this->form);
        getSmarty()->assign('result', $this->result);
    
        getSmarty()->display('CalcCredit.tpl');
    }

}

