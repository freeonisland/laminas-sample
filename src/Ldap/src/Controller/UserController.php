<?php

declare(strict_types=1);

namespace Ldap\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Ldap\Factory\ServiceFactory;

class UserController extends AbstractActionController
{
    /**
     * 
     */
    public function listAction()
    {
        $lm = ServiceFactory::createLdapManager();
        $res = $lm->search('objectClass=person');
        
        return new ViewModel([
            'users' => $res??[]
        ]);
    }

    /**
     * 
     */
    public function createAction()
    {   
        $lm = ServiceFactory::createLdapManager();
        $schemas = $lm->getSchemas();

        $post = $this->getRequest()->getPost();
        
        if ($post && count($post) && 'yes' !== $post['onlychange']) {
            // Create data ...
            if($post['cn'])
                $lm->add('person', [
                    'cn' => $post['cn'],
                    'sn' => $post['sn']
                ]);
        }

        return new ViewModel([
            'user' => [
                'cn'=>[''],
                'sn'=>['']
            ],
            'schemas' => $schemas,
            'post' => $post
        ]);
    }

    public function updateAction(string $userId)
    {
        $lm=$this->getModule('LaminasManager');

        if($this->post) {
            // Update data ...
            $lm->update('person', $this->post['uid'], [
                'cn' => $this->post['cn'],
                'sn' => $this->post['sn']
            ]);
        }

        $s="(&(objectClass=person)(cn={$userId}))";
        $user=$lm->search($s);

        return [
            'user' => $user[0]
        ]; 
    }

    /**
     * 
     */
    public function viewAction(string $userId)
    {
        $lm = $this->getModule('LaminasManager');
        $user=$lm->search("(&(cn={$userId})(objectClass=person))");

        return [
            'user' => $user?$user[0]:null
        ]; 
    }

    /**
     * 
     */
    public function deleteAction(string $userId)
    {
        $lm = $this->getModule('LaminasManager');
        $user=$lm->get($userId);
        
        if(count($this->post)) {
            // Delete data ...
            s($this->post);
            if('yes'===$this->post['confirm']) {
                $lm->delete($userId);
                //redirect
                die();
            }
        }

        return [
            'user' => $user[0]
        ]; 
    }
}
