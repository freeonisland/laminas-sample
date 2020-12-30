<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Application\Form\UserForm;
use Application\Form\UserAnnotForm;
use Application\Form\SampleForm;
use Laminas\View\Model\ViewModel;

use Laminas\Http\PhpEnvironment\Request;
use Laminas\Filter;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\FileInput;
use Laminas\Validator;

class FormController extends AbstractActionController
{
    private $yamlReader;

    public function __construct(\Laminas\Config\Reader\Yaml $yamlReader)
    {
        $this->yamlReader = $yamlReader;
    }

    public function indexAction()
    {
        $userMsg = $sampleMsg = "";
        $post = $this->getRequest()->getPost();
        $post_files = $this->getRequest()->getFiles();

        $postData = array_merge($post->toArray(), $post_files->toArray());
        
        


        /****************** user form **** */
        $user = new \Application\Form\Model\UserModel;

        /* 
          Annotation way!

          $builder = new \Laminas\Form\Annotation\AnnotationBuilder();
          $userForm = $builder->createForm(UserAnnotForm::class);
        */
        $userForm = new UserForm('userform');

        $userForm->setInputFilter(
            $user->getInputFilter()
        );
        

        // Bind object with ClassMethodsHydrator
        $objectToBind = new class {
            public $username="pourqyuoi",
                    $email="savoir@obj.com",
                    $phone;
        };

        $userForm->setData($postData);//set data to form
        $userForm->bind($objectToBind); //bind default values for unset post values

        // Need to validate before getData()
        $userForm->isValid(); //to display photo if no post data

        // INFO
        assert($userForm->getData() === $objectToBind); //objectToBind class

        $getFormDataA = $userForm->getData(\Laminas\Form\FormInterface::VALUES_AS_ARRAY);
        $getFormDataH = $userForm->getHydrator()->extract($objectToBind);
        assert($getFormDataA === $getFormDataH);
        
        // Validate
        if($this->getRequest()->isPost() && isset($post['form_user']) && $userForm->isValid()) {
            // Get filtered data instead of raw post 
            $user->exchangeArray($getFormDataH); 
            
            // ...save user model in database...
            
            $userMsg = "Ok";
        } else {
            $userMsg = var_export($userForm->getMessages(), true);
        }
        
        

        
        //********************* */ sample Form
        $sampleForm = (new SampleForm($this->yamlReader))->createFactory();
        $sampleForm->setData($post);

        $req_csrf = $post->get('my_security_csrf') ?? null;
        $csrfValid = $sampleForm->getElements()['my_security_csrf']->getCsrfValidator($req_csrf);

        // Validate
        if($this->getRequest()->isPost() && isset($post['form_sample'])) {// && $csrfValid && $sampleForm->isValid()) {
            $sampleMsg = "Ok";
        } else {
            $sampleMsg = var_export($sampleForm->getMessages(), true);
        }


        return new ViewModel([
            'userMsg' => $userMsg,
            'userForm' => $userForm,
            'sampleMsg' => $sampleMsg,
            'sampleForm' => $sampleForm
        ]);
    }
}