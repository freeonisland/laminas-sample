<?php

declare(strict_types=1);

namespace AlbumTry\Controller;

use AlbumTry\Gateway\AlbumGateway;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class EditController extends AbstractActionController
{
    public function __construct(AlbumGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function editAction()
    {
        //get id
        $id = (int) $this->params()->fromRoute('id', 0);
        
        //if id==0 redirect
        if (!$id) {
            throw new \RuntimeException("Id $id non trouvé");
        }

        $album = $this->gateway->fetching($id);
        
        $form = new \AlbumTry\Form\AlbumForm;
        $form->custom_setup()->bind($album);
        //$form->get('my-submit')->setAttribute('value', 'go');

        /*
         * if !post redirect
         */
        if( !$this->getRequest()->isPost()) {       //Get
            return new ViewModel(['id'=>$id, 'form'=>$form]);
        }
        
        $form->setData($this->getRequest()->getPost());

        //continue post
        if( !$form->isValid() ) {
            return new ViewModel(['id'=>$id, 'form'=>$form]);
        }
        
        //if form valid edit data
        $this->gateway->edit($album);

        return $this->redirect()->toRoute('albumtry', ['action'=>'edit', 'id'=>8]);
    }
}