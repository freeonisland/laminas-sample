<?php

namespace Application\Form\Model;

use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;

class UserModel implements InputFilterAwareInterface
{
    public $username;
    public $email;
    public $phone;
    public $file;

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \LogicException("Not used");
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        $inputFilter = new InputFilter;

        $inputFilter->add([
            'name' => 'username',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8', 
                        'min' => 3,
                        'max' => 20
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'phone',
            'required' => false,
            'filters' => [
                
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 20
                    ]
                ]
            ]
        ]);

        /*
         * file rename
         * 
         * Don't forget to merge $request->post and $request->FILES
         */

        $file = new \Laminas\InputFilter\FileInput('f'); 
        $file->setRequired(false);
        $file->getValidatorChain()->attach(
            new \Laminas\Validator\File\UploadFile()
        );
        $file->getFilterChain()->attach( 
            new \Laminas\Filter\File\RenameUpload([ 
                'target'    => './public/', 
                'overwrite' => true,
                'use_upload_name' => true,
                //randomize' => true, 
                'use_upload_extension' => true 
            ])
        );
        $inputFilter->add($file);



        return $inputFilter;
    }

    public function exchangeArray(array $data)
    {
        $this->username = $data['username'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->phone = $data['phone'] ?? null;
    }
}