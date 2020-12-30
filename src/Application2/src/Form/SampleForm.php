<?php

namespace Application\Form;

use Laminas\Form;
use Laminas\InputFilter;


class SampleForm 
{
    protected $yamlReader;

    function __construct(\Laminas\Config\Reader\Yaml $yamlReader)
    {
        $this->yamlReader = $yamlReader;
    }

    /**
     * Using factory way
     */
    function createFactory()
    {   

        /**
         * Create form
         */
        $form = (new Form\Factory)->createForm(
            $this->yamlReader->fromString($this->getConfig())
        );
        $form->setName('sampleform');

        $this->addCustomElements($form);
        $this->addSpecificElements($form);
        
        return $form;
    }

    /**
     * Config
     */
    protected function getConfig()
    {
        $config = <<<YAML
hydrator: Laminas\Hydrator\ArraySerializableHydrator
elements:
    - spec:
        name: my_security_csrf
        type: Laminas\Form\Element\Csrf
    - spec:
        name: form_sample
        type: Laminas\Form\Element\Hidden
fieldsets:
    - spec:
        name: my_field1
        attributes:
            class: border border-info p-2
        elements:
            - spec:
                name: my_name
                type: Text
                options: 
                    label: "Name: "
                attributes:
                    placeholder: "My name"
            - spec:
                name: my_email
                type: Laminas\Form\Element\Email
                required: false
                options:
                    label: "Email: "
                attributes:
                    placeholder: "email@sample.com"

    - spec:
        name: my_field2
        attributes:
            class: border border-info p-2
        elements:
            - spec:
                name: my_textarea
                type: Laminas\Form\Element\Textarea
                options:    
                    label: "Message: "
                attributes:
                    placeholder: "Message"
            - spec:
                name: my_send
                type: Laminas\Form\Element\Submit
                attributes:
                    value: "Send"

# can't add filters to fieldset !
input_filter:
    -   name: my_security_csrf
        required: true
        validators:
            -   name: Laminas\Validator\Regex
                options:
                    pattern: /^.*$/

# select only validating fields 
#validation_group:
#    email_field:
#        - textarea

YAML;
        return $config;
    }

    /**
     * Elements outside config
     */
    protected function addCustomElements($form)
    {
        $formFilter = $form->getInputFilter();

        /*************
         * textarea filter FIELD2
         */
        $str9Filter = (new \Laminas\InputFilter\Factory)->createInputFilter([
            'my_textarea' => [ 
                'name' => 'string_length_nine',
                'require' => true,
                'validators' => [
                    new \Laminas\Validator\StringLength(9)
                ]
            ]
        ]);
        $str9Filter->add(
            new \Laminas\InputFilter\Input(), 
            'my_textarea'
        ); 
        $formFilter->add($str9Filter, 'my_field2');

        /**
        *  add fieldset3 and phone element
        */ 
        $phone = new \Laminas\Form\Element\Tel('my_phone');
        $phone->setLabel('Phone: ');

        $field3 = new \Laminas\Form\Fieldset('my_field3');
        $field3->setAttributes(["labelo", 'my3']);
        $field3->setLabel("field3");
        $field3->add($phone);
        
        // *** phone filter FIELD3
        $phoneFilter = new \Laminas\InputFilter\InputFilter();
        $phoneFilter->add([
            'name' => 'string_length_seven',
            'require' => true,
            'validators' => [
                new \Laminas\Validator\StringLength(7)
            ]
        ], 'my_phone');

        /**
         * Add filters to fieldset
         */
        $formFilter->add($phoneFilter, 'my_field3');

        $form->add($field3);
    }

    function addSpecificElements(\Laminas\Form\Form $form)
    {
        $myElement = new \Application\Form\Element\MyTextElement('it_is_my_element');
        $myField = new \Application\Form\Element\MyFieldset();
        $myField->setName('and_thats_my_field');
        $myField->setLabel('my_field');
        $myField->add($myElement);

        $inputForElement = new \Laminas\InputFilter\InputFilter;
        $inputForElement->add(
            $myElement->getInputSpecification(),
            'it_is_my_element'
        );

        $form->getInputFilter()->add(
            $inputForElement,
            'and_thats_my_field'
        );
        $form->add($myField);
    }

    

    
    /***************
     * Using elements way
     */
    function _createSample()
    {
        $name = new Form\Element('name');
        $name->setLabel('Name: ')->setAttribute('type', 'text');

        $nameInput = new InputFilter\Input('name');
        $inputFilter = new InputFilter\InputFilter;
        $inputFilter->add($nameInput);

        $email = new Form\Element('email');
        $email->setLabel('Email: ')->setAttribute('type', 'text')->setAttribute('placeholder', 'my email');

        $message = new Form\Element\Textarea('message');
        $message->setLabel('Message');

        $captcha = new Form\Element\Captcha('captcha');
        $captcha->setCaptcha(new \Laminas\Captcha\Dumb());
        $captcha->setLabel("Please verify");

        $csrf = new Form\Element\Csrf('security');

        $send = new Form\Element\Submit('send');
        $send->setValue('Send');

        /*
         * field
         */
        $sender = new Form\Fieldset('sender');
        $sender->setAttribute('class', "border border-warning p-2");
        $sender
            ->add($name)
            ->add($email);

        $form = (new Form\Form('contact'));
        $form
            ->add($csrf)
            ->add($sender)
            ->add($message)
      //      ->add($captcha)
            ->add($send);
        
        /**
         * Filter
         */
        $form->setInputFilter($inputFilter);
        
        return $form;
    }
}























