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
    public function viewAction(string $userId)
    {
        $lm = $this->getModule('LaminasManager');
        $user=$lm->search("(&(cn={$userId})(objectClass=person))");

        return [
            'user' => $user?$user[0]:null
        ]; 
    }

    /**
     * Delete
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
