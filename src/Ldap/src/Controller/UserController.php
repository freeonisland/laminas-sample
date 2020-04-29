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
        
        //s($schemas);
        /*
        

        return [
            'users' => $res??[]
        ];*/
        return new ViewModel([
            'users' => $res??[]
        ]);
    }

    /**
     * 
     */
    public function createAction()
    {   
        /*$lm = $this->getModule('LaminasManager');
        $schemas = $lm->getSchemas();
        
        if ($this->post && 'yes' !== $this->post['onlychange']) {
            // Create data ...
            $lm->add('person', [
                'cn' => $this->post['cn'],
                'sn' => $this->post['sn']
            ]);
        }

        $comm = 'ssh -o StrictHostKeyChecking=no root@ldap-server "ldapcompare" 2>&1';
        $exec=exec($comm, $out);*/
        //s($out);
        /*$exec=shell_exec($comm);
        s($exec);
        s($out);
        $exec=system($comm);
        s($exec);
        $exec=`ssh`;
        s($exec);
        $exec=passthru($comm);
        s($exec);

        exec("ping -c 1 yhoo.dsd 2>&1", $output, $return_var);
        s($output);
        s($return_var);*/

        /*return [
            'user' => [
                'cn'=>[''],
                'sn'=>['']
            ],
            'schemas' => $schemas,
            'post' => $this->post
        ]; */
        return new ViewModel();
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
