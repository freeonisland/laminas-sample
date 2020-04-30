<?php

declare(strict_types=1);

namespace Ldap\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Ldap\Factory\ServiceFactory;

class UserController extends AbstractActionController
{
    /**
     * List
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
     * Create
     */
    public function createAction()
    {   
        $lm = ServiceFactory::createLdapManager();
        $post = $this->getRequest()->getPost();
        
        if ($post && count($post) && 'yes' !== $post['onlychange']) {
            // Create data ...
            $data = (array)$post;
            unset($data['uid'], $data['onlychange'], $data['objectclass']);
            
            try{
                $lm->add($post['objectclass'], $data);
                $msg='Data inserted...';
            } catch(\Exception $e){ $msg = $e->getMessage(); }
        }

        return new ViewModel([
            'msg' => $msg,
            'schemas' => $lm->getSchemas(),
            'post' => $post
        ]);
    }

    /**
     * Update
     */
    public function updateAction()
    {
        $lm = ServiceFactory::createLdapManager();
        $post = $this->getRequest()->getPost();

        // get userid from url params
        $params = $this->getEvent()->getRouteMatch()->getParams()['params'];
        if(!$params) {
            return $this->notFoundAction();
        }

        // Search
        $userId = $params;
        $s="cn={$userId}";
        $user = $lm->search($s);

        if($user) {
            $user = $user[0];
        } else {
            throw new \InvalidArgumentException("{$userId} not found");
        }

        // Post request
        if ($post && count($post) && 'yes' !== $post['onlychange']) {
            // Create data ...
            $data = (array)$post;
            $cn = $data['cn'];
            unset($data['onlychange'], $data['schema']);
            
            try{
                $lm->update($post['objectclass'], $cn, $data);
                $msg='Data updated...';
            } catch(\Exception $e){ $msg = $e->getMessage(); }
        } else {
             // init data
            foreach($user as $param => $data) {
                if(is_array($data)) {
                    $post[$param] = implode(',',$data);
                } else {
                    $post[$param] = $data;
                }
            }
        }

        return new ViewModel([
            'msg' => $msg,
            'schemas' => $lm->getSchemas(),
            'post' => $post
        ]);
    }

    /**
     * View
     */
    public function viewAction()
    {
        $lm = ServiceFactory::createLdapManager();
        $post = $this->getRequest()->getPost();

        // get userid from url params
        $params = $this->getEvent()->getRouteMatch()->getParams()['params'];
        if(!$params) {
            return $this->notFoundAction();
        }

        // Search
        $userId = $params;
        $s="cn={$userId}";
        $user = $lm->search($s)[0];

        return new ViewModel([
            'user' => $user
        ]);
    }

    /**
     * Delete
     */
    public function deleteAction()
    {
        $lm = ServiceFactory::createLdapManager();
        $post = $this->getRequest()->getPost();

        // get CommonName from url params
        $params = $this->getEvent()->getRouteMatch()->getParams()['params'];
        if(!$params) {
            return $this->notFoundAction();
        }

        // Search
        $cn = $params;
        $user = $lm->search("cn={$cn}")[0];

        //s($user );
        if($post && count($post)) {
            // Delete data ...
            if('yes'===$post['confirm']) {
                $lm->delete($cn);
                //redirect
                header('Location: /ldap/user/list');
                die();
            }
        }

        return [
            'user' => $user
        ]; 
    }
}
