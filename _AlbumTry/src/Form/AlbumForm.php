<?php

namespace AlbumTry\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\{InputFilter, InputFilterInterface, InputFilterAwareInterface};
use Laminas\Filter\{ToInt, StripTags, StringTrim};
use Laminas\Validator\StringLength;

class AlbumForm extends Form
{
    public function custom_setup()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'artist',
            'type' => 'text'
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'text',

           /* 'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ],
            'validator' => [
                'name' => StringLength::class,
                'options' => [
                    'encoding' => 'UTF-8',
                    'min' => '1',
                    'max' => '10'
                ]
            ]*/
        ]);

        $this->add([
            "name" => 'my-submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Edit'
            ]
        ]);


       $this->setInputFilter($this->getFilters());
       return $this;
    }

    
    private function getFilters()
    {
        if ($this->filter) {
           // return $this->filter;
        }

        $this->filter = new InputFilter;

        $this->filter->add([
            'name' => 'artist',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => '1',
                        'max' => '10'
                    ]
                ]
            ]
        ]);

        $this->filter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => '1',
                        'max' => '10'
                    ]
                ]
            ]
        ]);

        return $this->filter;
    }
}