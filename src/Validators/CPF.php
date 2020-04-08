<?php

namespace FCodeDigital\Validators;

use Random\Validate\CPF\CPF as ValidateCPF;
use Zend\Validator\AbstractValidator;

class CPF extends AbstractValidator
{
    const INVALID_CPF = 'The given CPF information invalid.';

    protected $messageTemplates = array(
        self::INVALID_CPF => self::INVALID_CPF
    );

    private $blackList = array(
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999',
    );
    
    public function isValid($cpf)
    {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            $this->error(self::INVALID_CPF);

            return false;
        }

        if(empty($cpf) || in_array($cpf, $this->blackList) || strlen($cpf) != 11){
            $this->error(self::INVALID_CPF);

            return false;
        }
        
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $this->error(self::INVALID_CPF);

            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                $this->error(self::INVALID_CPF);

                return false;
            }
        }
        return true;
    }
}
