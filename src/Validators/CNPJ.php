<?php

namespace FCodeDigital\Validators;

use Random\Validate\CNPJ\CNPJ as ValidateCNPJ;
use Zend\Validator\AbstractValidator;

class CNPJ extends AbstractValidator
{
    const INVALID_CNPJ = 'The given CNPJ information invalid.';

    protected $messageTemplates = array( self::INVALID_CNPJ => self::INVALID_CNPJ );

    private $blackList = array(
        '00000000000000',
        '11111111111111',
        '22222222222222',
        '33333333333333',
        '44444444444444',
        '55555555555555',
        '66666666666666',
        '77777777777777',
        '88888888888888',
        '99999999999999',
    );
    
    public function isValid($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        $cnpj = (int)$cnpj;
        
        if(empty($cnpj) || in_array($cnpj, $this->blackList) || strlen($cnpj) != 14){
            $this->error(self::INVALID_CNPJ);

            return false;
        }
	
        // Valida tamanho
        if (strlen($cnpj) != 14){
            $this->error(self::INVALID_CNPJ);

            return false;
        }

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)){
            $this->error(self::INVALID_CNPJ);

            return false;	
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)){
            $this->error(self::INVALID_CNPJ);
            
            return false;
        }
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return true;
    }
}
