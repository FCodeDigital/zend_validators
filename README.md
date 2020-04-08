# Instalando

##### Composer

```
composer require fcodedigital/zend_validators
```

# Como utilizar.
```
$inputFilter->add(array(
    'name'     => 'cpf',
    'required' => true,
    'filters'  => array(
        array('name' => 'StripTags'),
        array('name' => 'StringTrim'),
    ),
    'validators' => array(
        array(
            'name'    => 'StringLength',
            'options' => array(
                'encoding' => 'UTF-8',
                'min'      => 11,
                'max'      => 11,
            ),
        ),
        array(
            'name' => 'FCodeDigital\Validators\CPF'
        ),
    ),
));
```
