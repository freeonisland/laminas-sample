<?php

namespace Application\Form\Element;

use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;


class MyFieldset extends Fieldset implements InputFilterProviderInterface
{
    /**
     * @return array for Laminas\InputFilter\Factory::createInputFilter().
     */
    public function getInputFilterSpecification(): array
    {
        return [
            'it_is_my_element' => [
                'name' => $this->getName(),
                'required' => true,
                'filters' => [
                    ['name' => \Laminas\Filter\StringTrim::class],
                ]
            ]
        ];
    }
}