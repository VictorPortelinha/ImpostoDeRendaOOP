<?php

class IRPF {
    private $actualRange;
    private $baseDeCalc;
    private int  $income;
    private int $nDep;
    private array $otherDeductions = [0];
    private int $alimony = 0; // pensões
    private $discByDep = 189.59;
    private $tax; //Taxa de imposto da faixa que se encontra
    private $realTax; //Taxa efetiva à ser retornada
    private $valueTax; //imposto final à ser retornado

    public function __construct($novoSalario,$numDep){
        $this->income = $novoSalario;
        $this->nDep = $numDep;
    }
    
    public function getBCalc(){
        echo $this->baseDeCalc;
    }   
    

    public function setAlimony($novaAlimony){
        $this->alimony = $novaAlimony;
    }

    public function addDeductions($newDeduction) {
        $this->otherDeductions[0] = $newDeduction;
        
    }

    public function setDiscByDep($newDepValue) {
        $this->discByDep = $newDepValue;
    }

    public function getIRPF(){
       echo 'O valor do imposto de renda é '. $this-> valueTax;
       echo '<br/>' ;

    }

    public function getTax(){
        echo 'A taxa do imposto é '. $this->tax;
        
        echo ' se encontrando na faixa '. $this->actualRange;
        echo '<br/>';

    }
    public function getRealTax(){
        $this->calcRealTax();
        printf('A taxa real do imposto é '.$this->realTax);
        echo '<br/>';

    }

    private function calcRealTax(){
        $this->realTax = $this->valueTax / $this->baseDeCalc * 100;
        
    }

    public function calcIRPF(){

        $faixas = array(); 
        $faixas[0] = array(0,0);
        $faixas[1] = array(1903.98, 0);
        $faixas[2] = array(2826.65, 0.075);
        $faixas[3] = array(3751.05, 0.15);
        $faixas[4] = array(4664.68, 0.225);
        $faixas[5] = array(4664.68, 0.275);



        $this->baseDeCalc = $this->income+(($this->discByDep*$this->nDep) + $this->alimony + $this->otherDeductions[0]);

        for ($i=5;$i>0;$i--) {
            if ($this->baseDeCalc > $faixas[$i][0]){
                if ($this->baseDeCalc < 4664.68){
                    $this->actualRange = $i+1;
                    $this->tax = ($this->baseDeCalc - $faixas[$i][0]) * $faixas[$i+1][1];
                    
                    
                }
                else {
                $this->actualRange = $i;
                $this->tax = ($this->baseDeCal - $faixas[$i][0]) * $faixas[$i][1];
               }
                for ($j=5;$j>0;$j--) {
                    if($j == 1){
                        break 2;
                    }
                    $adtionalTax = ($faixas[$j][0] - $faixas[$j-1][0]) * $faixas[$j][1];
                    $this->valueTax = $this->tax + $adtionalTax;
                    }

            }

        }


    }

    

    
}

