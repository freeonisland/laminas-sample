<?php

namespace Application\Form\Element;

use Laminas\Form\Element;
use Laminas\InputFilter\InputProviderInterface;

/*
 * Element
 * 
  2 => string 'setName' (length=7)
  4 => string 'setOptions' (length=10)
  7 => string 'setOption' (length=9)
  8 => string 'setAttribute' (length=12)
  10 => string 'removeAttribute' (length=15)
  11 => string 'hasAttribute' (length=12)
  12 => string 'setAttributes' (length=13)
  13 => string 'getAttributes' (length=13)
  14 => string 'removeAttributes' (length=16)
  15 => string 'clearAttributes' (length=15)
  16 => string 'setValue' (length=8)
  18 => string 'setLabel' (length=8)
  20 => string 'setLabelAttributes' (length=18)
  22 => string 'setLabelOptions' (length=15)
  24 => string 'clearLabelOptions' (length=17)
  25 => string 'removeLabelOptions' (length=18)
  26 => string 'setLabelOption' (length=14)
  28 => string 'removeLabelOption' (length=17)
  29 => string 'hasLabelOption' (length=14)
  30 => string 'setMessages' (length=11)
 */
class MyTextElement extends Element implements InputProviderInterface
{
    /**
     * @return array for Laminas\InputFilter\Factory::createInput().
     */
    public function getInputSpecification(): array
    {
        return [
            'name' => $this->getName(),
            'required' => true,
            'filters' => [
                ['name' => \Laminas\Filter\StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => \Laminas\Validator\Callback::class,
                    'options' => [
                        "callback" => function($value) {
                            return preg_match('/^.*$/', $value);
                        }
                    ]
                ],
                [
                    'name' => \Laminas\Validator\Between::class,
                    'options' => [
                        "min" => 5,
                        "max" => 10
                    ]
                ]
            ]
        ];
    }
}