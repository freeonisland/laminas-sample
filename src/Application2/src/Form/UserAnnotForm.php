<?php

namespace Application\Form;

use Laminas\Form\Annotation;

/**
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class UserAnnotForm 
{
    /**
     * @Annotation\Exclude()
     */
    public $id;

    /**
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":25}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Username:"})
     */
    public $username;

    /**
     * @Annotation\Type("Laminas\Form\Element\Email")
     * @Annotation\Options({"label":"Your email address:"})
     */
    public $email;

    public $phone;

    public $file;

    public $send;



    /*function __construct($name=null, $options=[])
    {
        $name = $name ?? 'userform';
        //parent::__construct($name, $options);

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
    }*/
}