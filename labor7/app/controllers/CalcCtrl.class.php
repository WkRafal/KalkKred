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

    public function action_calcCredit(){
   
        $this->getParams();
    
        if ($this->validate()){
	
    //konwersja parametrów na int
            $this->form->amount = intval($this->form->amount);
            $this->form->numOfInst = intval($this->form->numOfInst);
            $this->form->interest = floatval($this->form->interest);
            
            getMessages()->addInfo('Parametry poprawne.');
            
            if (inRole('admin')){
		$this->result->result = ($this->form->amount + $this->form->amount * $this->form->interest / 100) / $this->form->numOfInst;
            } else {
                getMessages()->addError('Tylko administrator może wykonać tę operację');
            }
                  
            getMessages()->addInfo('Wykonano obliczenia.');
            
            try {
                
                $database = new \Medoo\Medoo([
                // [required]
                'type' => 'mysql',
                'host' => 'localhost',
                'database' => 'calk',
                'username' => 'root',
                'password' => '',

                // [optional]
                'charset' => 'utf8',
                'collation' => 'utf8_polish_ci',
                'port' => 3306,
                'option' => [
                        \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]

                ]);
                
                $database->insert("wynik", [
                    "kwota" => $this->form->amount,
                    "raty" => $this->form->numOfInst,
                    "procent" => $this->form->interest,
                    "rata" => $this->result->result,
                    "data" => date("y-m-d H:i:m")
                ]);
                
            } catch (\PODException $ex) {
                getMessages()->addError("DB errors".$ex->getMessages());
            }
    
	}
        
        $this->generateView();
        
    }
    
    public function action_calcShow(){
	getMessages()->addInfo('Witaj w kalkulatorze');
	$this->generateView();
}

    public function generateView(){
                
        getSmarty()->assign('page_description','Baza Danych');
        getSmarty()->assign('page_header','Kontroler główny');
        
        getSmarty()->assign('user',unserialize($_SESSION['user']));
				
	getSmarty()->assign('page_title','Labor7 - Baza Danych');

        //pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
        getSmarty()->assign('form', $this->form);
        getSmarty()->assign('result', $this->result);
    
        getSmarty()->display('CalcCredit.tpl');
    }

}

