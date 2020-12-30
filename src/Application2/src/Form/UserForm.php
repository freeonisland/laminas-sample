<?php

namespace Application\Form;

use Laminas\Form\Form;


class UserForm extends Form
{
    function __construct($name=null, $options=[])
    {
        $name = $name ?? 'userform';
        parent::__construct($name, $options);

        $this->setHydrator(new \Laminas\Hydrator\ObjectPropertyHydrator);
        //$this->setHydrator(new \Laminas\Hydrator\ArraySerializableHydrator);

        $this->add([
            'name' => 'form_user',
            'type' => 'Hidden'
        ]);

        $this->add([
            'name' => 'username',
            'type' => 'Text',
            'options' => [
                'label' => 'Username: '
            ]
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'Email',
            'options' => [
                'label' => 'Email: '
            ]
        ]);

        $this->add([
            'name' => 'phone',
            'type' => 'Text',
            'options' => [
                'label' => 'Phone: '
            ]
        ]);

        $this->add([
            'name' => 'f',
            'type' => 'File',
            'required' => false,
            'options' => [
                'label' => 'Filing file: '
            ],
            'attributes' => [
               // 'multiple' => true
            ]
        ]);

        $this->add([
            'name' => 'send',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Send'
            ]
        ]);
    }
}